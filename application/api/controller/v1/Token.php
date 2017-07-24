<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 1:41 PM
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token {
    public function getToken($code='') {
        (new TokenGet())->validate();
        $ut = new UserToken($code);
        $token = $ut->get();
    }
}