<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 4:57 PM
 */

namespace app\api\controller\v2;

class Banner {
    /**
     * @url /banner/:id
     * @http GETls
     * @param $id
     * 指定banner的id号
     */
    public function getBanner($id) {
        return 'This is api v2';
    }
}