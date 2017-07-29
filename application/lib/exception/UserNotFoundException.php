<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 29/07/2017
 * Time: 8:15 PM
 */

namespace app\lib\exception;


class UserNotFoundException extends BaseException {
    //http 状态码 404, 200
    public $code = 404;
    public $message = 'User does not exists';
    public $errorCode = 60000;
}