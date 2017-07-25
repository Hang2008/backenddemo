<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 25/07/2017
 * Time: 1:44 PM
 */

namespace app\api\service;


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
}