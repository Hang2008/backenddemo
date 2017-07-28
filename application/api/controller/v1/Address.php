<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 28/07/2017
 * Time: 9:02 PM
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;

class Address {
    public function createOrUpdateAddress() {
        (new AddressNew())->validate();
        //通过token换取uid
        //根据uid查找用户是否存在. 如果不存在抛异常
        //如果存在,获取客户端传的地址信息
        //在adress表查找对应的user address信息,如果存在则修改不存在则新增
        $uid = TokenService::getCurrentUID();
        
    }
}