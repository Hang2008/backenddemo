<?php

namespace app\api\model;

class BannerItemModel extends BaseModel {
    protected $table = 'banner_item';
    protected $hidden = ['delete_time', 'update_time', 'id', 'img_id', 'banner_id'];

//belongsTo 表示关联关系为1对1的关系
    public function img() {
        return $this->belongsTo('ImageModel', 'img_id', 'id');
    }
}
