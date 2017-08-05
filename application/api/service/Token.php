<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 25/07/2017
 * Time: 1:44 PM
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\UserPrivilegeException;
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
        $token = Request::instance()
                        ->header('token');
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

    public static function getCurrentPrivilege() {
        $scope = self::getCurrentTokenVar('scope');
        return $scope;
    }

    //检查是否是用户和管理员都可以访问
    public static function checkPrimaryPrivilege() {
        $scope = self::getCurrentPrivilege();
        if ($scope) {
            if ($scope < ScopeEnum::User) {
                throw new UserPrivilegeException();
            }
        } else {
            throw new TokenException();
        }
    }

    //检查是否是不允许管理员访问
    public static function excludeAdminUser() {
        $scope = self::getCurrentPrivilege();
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new UserPrivilegeException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function isValidOperation($uidToCheck) {
        if (!$uidToCheck) {
            throw new Exception('Validate operation but uid is null');
        }
        $currentUid = self::getCurrentUID();
        return ($uidToCheck == $currentUid) ? true : false;
    }
}