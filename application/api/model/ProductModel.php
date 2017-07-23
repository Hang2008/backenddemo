<?php

namespace app\api\model;

class ProductModel extends BaseModel {
    protected $table = 'product';
    protected $hidden = ['delete_time', 'update_time', 'create_time', 'pivot', 'from', 'category_id'];

    protected function getMainImgUrlAttr($value, $data) {
        return $this->handleImageUrl($value, $data);
    }
}