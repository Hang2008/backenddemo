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
use think\Request;

class ExceptionHandler extends Handle {
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e) {


        if ($e instanceof BaseException) {
            //处理自定义异常
            $this->code = $e->code;
            $this->msg = $e->message;
            $this->errorCode = $e->errorCode;

        } else {
            //处理内部异常
            $this->code = 500;
            $this->msg = 'Internal Server Error';
            $this->errorCode = 500;
        }
        //这个request怎么哪里都能取
        $request = Request::instance();
        $result = ['errorCode' => $this->errorCode, 'msg' => $this->msg, 'request_url' => $request->url()];
        return json($result, $this->code);
    }
}