<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 22/07/2017
 * Time: 10:33 PM
 */

namespace app\lib\exception;


class ThemeNotFoundException extends BaseException {
    public $code = 404;
    public $message = "Themes you are looking for does't exist";
    public $errorCode = 30000;
}