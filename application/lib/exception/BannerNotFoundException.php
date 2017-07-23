<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 5:29 PM
 */

namespace app\lib\exception;


class BannerNotFoundException extends BaseException {
    //http 状态码 404, 200
    public $code = 404;
    public $message = 'BannerModel does not exists';
    public $errorCode = 20000;
}