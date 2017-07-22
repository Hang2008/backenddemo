<?php

namespace app\api\model;

class ImageModel extends BaseModel {
    protected $table = 'image';
    protected $hidden = ['delete_time', 'update_time', 'id', 'from'];

    public function getUrlAttr($value, $data) {
        return $this->handleImageUrl($value, $data);
    }
}
