<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 27/07/2017
 * Time: 9:08 PM
 */

namespace app\api\model;


class ProductImageModel extends BaseModel {
    protected $table = 'product_image';
    protected $hidden = ['delete_time', 'product_id', 'img_id', 'id'];

    //在相应model里面定义关联表,不要在最开始的model定义,一般是中间表
    public function imgUrl() {
        return $this->belongsTo('ImageModel', 'img_id', 'id');
    }
}