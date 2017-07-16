<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 5:10 PM
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;

class ExceptionHandler extends Handle {
    public function render(Exception $e) {
        return json('我擦擦擦擦车');
    }
}