<?php

namespace app\api\model;

class ProductModel extends BaseModel {
    protected $table = 'product';
    protected $hidden = ['delete_time', 'update_time', 'create_time', 'pivot', 'from', 'category_id'];

    protected function getMainImgUrlAttr($value, $data) {
        return $this->handleImageUrl($value, $data);
    }

    public static function getRecents($count) {
        //对当前查询模型进行直接排序
        return self::limit($count)
                   ->order('create_time', 'desc')
                   ->select();
    }

    public static function getByCategory($id) {
        //我写的
        //        return self::find($id);
        return self::where('category_id', '=', $id)
                   ->select();
    }

    public static function getDetailById($id) {
        //连续链式with方法,可以针对每一步传递闭包方法
//        $product = self::with(['images.imgUrl'])->with(['properties'])->find($id);
        $product = self::with(['images' => function ($query) {
            //这里可以针对关联模型进行排序
            $query->with(['imgUrl'])
                  ->order('order', 'asc');
        }])->with(['properties'])
           ->find($id);
//        var_dump($product);
        return $product;
    }

    public function images() {
        return $this->hasMany('ProductImageModel', 'product_id', 'id');
    }

    public function properties() {
        return $this->hasMany('PropertiesModel', 'product_id', 'id');
        //是对当前模型进行排序, 所以要对关联模型进行排序不能这么写
//        $this->order();
    }
}