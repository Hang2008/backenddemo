<?php

namespace app\api\model;

class ImageModel extends BaseModel {
    protected $table = 'image';
    protected $hidden = ['delete_time', 'update_time', 'id', 'from'];

    //模型内部可以使用获取器attr方式在获取字段后自动处理
    public function getUrlAttr($value, $data) {
        return $this->handleImageUrl($value, $data);
    }
}
