<?php

namespace app\api\model;

class ThemeModel extends BaseModel {
    protected $table = 'theme';
    protected $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];

    public static function getThemes() {
        return self::with(['topicImg', 'headImg']);
    }

//定义关联关系
    public function topicImg() {
        //一对一的关系看情况用belongsTo或者hasOne
        return $this->belongsTo('ImageModel', 'topic_img_id', 'id');
    }

    public function headImg() {
        return $this->belongsTo('ImageModel', 'head_img_id', 'id');
    }

    public function products() {
        return $this->belongsToMany('ProductModel', 'theme_product', 'product_id', 'theme_id');
    }
}
