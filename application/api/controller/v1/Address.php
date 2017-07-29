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
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserNotFoundException;

class Address {
    public function createOrUpdateAddress() {
        $validate = new AddressNew();
        $validate->validate();
        //通过token换取uid
        //根据uid查找用户是否存在. 如果不存在抛异常
        //如果存在,获取客户端传的地址信息
        //在adress表查找对应的user address信息,如果存在则修改不存在则新增
        $uid = TokenService::getCurrentUID();
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserNotFoundException();
        }
        //input从客户端获取所有post参数变量
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address($uid);
        if (!$userAddress) {
            //用关联模型save? 这玩意不知用来查询的么?还能save?
            $user->address()
                 ->save($$dataArray);
        } else {
            //更新的话没有()直接读取address?
            $user->address->save($dataArray);
        }
        //不返回整个对象
//        return $user;
        return new SuccessMessage();
    }
}