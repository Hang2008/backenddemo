<?php

namespace app\api\model;

class ProductModel extends BannerModel {
    protected $table = 'product';
    protected $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];
}
