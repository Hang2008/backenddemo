<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 23/07/2017
 * Time: 9:48 PM
 */

namespace app\lib\exception;


class ProductNotFoundException extends BaseException {
    public $code = 404;
    public $message = "product not found";
    public $errorCode = 40000;
}