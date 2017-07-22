<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 3:53 PM
 */

namespace app\api\model;


class BannerModel extends BaseModel {
    protected $table = 'banner';
    protected $hidden = ['delete_time', 'update_time'];
    //返回模型关联模型的多个数据
    //public 函数并返回hasmany 称为关联
    //hasmany 表示关联关系为1对多的关系
    public function items() {
        //关联模型模型名,关联模型外键,当前模型主键
        return $this->hasMany('BannerItemModel', 'banner_id', 'id');
    }

    public static function getBaanerById($id) {
        //原生语句不好
        //$result = Db::query('select * from banner_item where banner_id=?', [$id]);
        //使用查询构建器
        //DB::辅助方法->执行方法
        //表达式法
//        $result = Db::table('banner_item')->where('banner_id', '=', $id)->select();
        //闭包法
//        $result = Db::table('banner_item')->where(function ($query) use ($id) {
//            $query->where('banner_id', '=', $id);
//        })->select();
//        return $result;
        $banner = self::with(['items', 'items.img'])->find($id);

        return $banner;
    }
}