<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 30/07/2017
 * Time: 5:10 PM
 */

namespace app\lib\exception;


class UserPrivilegeException extends BaseException {
    public $code = 403;
    public $message = 'Current user has no privilege to access';
    public $errorCode = 10004;
}