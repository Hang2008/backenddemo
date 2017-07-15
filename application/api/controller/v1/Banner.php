<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 4:57 PM
 */

namespace app\api\controller\v1;


use app\api\validate\IDPositiveIntValidate;

class Banner {
    /**
     * @url /banner/:id
     * @http GET
     * @param $id
     * 指定banner的id号
     */
    public function getBanner($id) {
//        $data = ['id' => $id];
//        $mValidate = new IDPositiveIntValidate();
//
//        $result = $mValidate->batch()->check($data);
//        var_dump($mValidate->getError());
        (new IDPositiveIntValidate())->validate();
        $c = 1;
    }
}