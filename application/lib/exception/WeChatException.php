<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 3:29 PM
 */

namespace app\lib\exception;


class WeChatException extends BaseException {
    public $code = 400;
    public $message = "WeChat has encounterd a problem";
    public $errorCode = 10002;
}