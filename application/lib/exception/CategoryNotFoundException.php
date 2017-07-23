<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 23/07/2017
 * Time: 9:48 PM
 */

namespace app\lib\exception;


class CategoryNotFoundException extends BaseException {
    public $code = 404;
    public $message = "category not found";
    public $errorCode = 50000;
}