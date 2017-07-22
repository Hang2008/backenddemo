<?php

namespace app\api\model;

class ThemeModel extends BaseModel {
    protected $table = 'theme';

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
}
