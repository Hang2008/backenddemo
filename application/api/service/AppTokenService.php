<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 05/09/2017
 * Time: 4:19 PM
 */

namespace app\api\service;


use app\api\model\ThirdAppModel;
use app\lib\exception\TokenException;

class AppTokenService extends Token {
    public function get($ac, $se)
    {
        $app = ThirdAppModel::check($ac, $se);
        if(!$app)
        {
            throw new TokenException([
                'msg' => '授权失败',
                'errorCode' => 10004
            ]);
        }
        else{
            $scope = $app->scope;
            $uid = $app->id;
            $values = [
                'scope' => $scope,
                'uid' => $uid
            ];
            $token = $this->saveToCache($values);
            return $token;
        }
    }

    private function saveToCache($values){
        $token = self::generateToken();
        $expire_in = config('setting.token_expire_in');
        $result = cache($token, json_encode($values), $expire_in);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $token;
    }
}