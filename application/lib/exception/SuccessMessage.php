<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 29/07/2017
 * Time: 8:48 PM
 */

namespace app\lib\exception;

//自定义一个成功消息返回给客户端, 比如在新增用户地址的时候并不需要把整个user返回,只需返回一个success message
class SuccessMessage {
    public $code = 201;
    public $message = "ok";
    public $errorCode = 0;
}