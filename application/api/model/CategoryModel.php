<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 23/07/2017
 * Time: 10:04 PM
 */

namespace app\api\model;


class CategoryModel extends BaseModel {
    protected $table = 'category';

    public function topicImg() {
        //一对一的关系看情况用belongsTo或者hasOne
        return $this->belongsTo('ImageModel', 'topic_img_id', 'id');
    }
}