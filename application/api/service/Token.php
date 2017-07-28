<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 25/07/2017
 * Time: 1:44 PM
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token {
    public static function generateToken() {
        //随机字符串32个字符
        $randomCharts = getRandChar(32);
        //用三组字符串进行md5加密,为了安全性
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 随机字符串
        $salt = config('encrypt.tokensalt');
        return md5($randomCharts . $timestamp . $salt);
    }

    public static function getCurrentTokenVar($key) {
        //Request是个全局的 不光是在controller里面能调用
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            //用默认的缓存存没问题,因为默认存起来的是string.用其他的缓存可能是数组
//            $vars = json_decode($vars, true);
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception("The key doesn't exsit in the cache for the token");
            }
        }

    }

    public static function getCurrentUID() {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}