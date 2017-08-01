<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 01/08/2017
 * Time: 9:27 PM
 */

namespace app\lib\exception;


class OrderException extends BaseException {
    public $code = 404;
    public $message = "Oder doesn't exist";
    public $errorCode = 80000;
}