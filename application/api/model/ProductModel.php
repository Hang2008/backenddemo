<?php

namespace app\api\model;

class ProductModel extends BaseModel {
    protected $table = 'product';
    protected $hidden = ['delete_time', 'update_time', 'create_time', 'pivot', 'from', 'category_id'];

    protected function getMainImgUrlAttr($value, $data) {
        return $this->handleImageUrl($value, $data);
    }

    public static function getRecents($count) {
        return self::limit($count)->order('create_time', 'desc')->select();
    }

    public static function getByCategory($id) {
        //我写的
        //        return self::find($id);
        return self::where('category_id', '=', $id)->select();
    }
}