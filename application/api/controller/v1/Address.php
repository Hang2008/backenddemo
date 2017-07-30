<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 28/07/2017
 * Time: 9:02 PM
 */

namespace app\api\controller\v1;


use app\api\model\UserModel;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserNotFoundException;
use app\lib\exception\UserPrivilegeException;
use think\Controller;

//为了使用前置方法必须继承基类控制器
class Address extends Controller {
    //表示只有createOrUpdateAddress方法需要前置操作checkUserPrivilege
    protected $beforeActionList = ['checkUserPrivilege' => ['only' => 'createOrUpdateAddress']];

    //不能用private我也是醉了
    protected function checkUserPrivilege() {
        $scope = TokenService::getCurrentPrivilege();
        if ($scope) {
            if ($scope<ScopeEnum::User) {
                throw new UserPrivilegeException();
            }
        } else {
            throw new TokenException();
        }
    }

    public function createOrUpdateAddress() {
        $validate = new AddressNew();
        $validate->validate();
        //通过token换取uid
        //根据uid查找用户是否存在. 如果不存在抛异常
        //如果存在,获取客户端传的地址信息
        //在adress表查找对应的user address信息,如果存在则修改不存在则新增
        $uid = TokenService::getCurrentUID();
        //get方法是取主键
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserNotFoundException();
        }
        //input从客户端获取所有post参数变量
        $dataArray = $validate->getDataByRule(input('post.'));
        //通过模型获取
        $userAddress = $user->address;
        if (!$userAddress) {
            //通过关联模型来新增address
            //用关联模型save? 这玩意不是用来查询的么?还能save?
            //答:首先关联模型返回一个数据, 模型的save方法可以用来新增数据
            $user->address()
                 ->save($dataArray);
        } else {
            //更新的话没有()直接读取address?
            $user->address->save($dataArray);
        }
        //不返回整个对象
//        return $user;
        //可以加一个状态码指定http返回不然默认是200
        return json(new SuccessMessage(), 201);
    }
}