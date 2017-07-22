<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model {
    //框架自动执行读取器方法,但是不灵活,所有model都会执行
    //读取器get{字段名}Arrr
//    public function getUrlAttr($value, $data) {
//        if ($data['from'] == 1) {
//            return config('custom.img_prefix') . $value;
//        } else {
//            return $value;
//        }
//    }
    protected function handleImageUrl($value, $data) {
        if ($data['from'] == 1) {
            return config('custom.img_prefix') . $value;
        } else {
            return $value;
        }
    }
}
