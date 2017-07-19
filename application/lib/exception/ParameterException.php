<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 18/07/2017
 * Time: 3:09 PM
 */

namespace app\lib\exception;


class ParameterException extends BaseException {
    public $code = 400;
    public $message = 'Bad Params';
    public $errorCode = 10001;
}