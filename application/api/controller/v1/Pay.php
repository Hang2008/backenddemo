<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 05/08/2017
 * Time: 3:09 PM
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDPositiveIntValidate;

class Pay extends BaseController {
    protected $beforeActionList = ['checkIsNotAdminUser' => ['only' => 'getPreOrder']];

    //客户端需要传给服务器订单id, 生成preorder,其他字段不需要客户端关心. openid可以由accesstoken获取
    public function getPreOrder($id = '') {
        (new IDPositiveIntValidate())->validate();
    }
}