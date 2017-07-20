<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 3:53 PM
 */

namespace app\api\model;


use think\Model;

class BannerModel extends Model {
    protected $table = 'banner';
//    public static function getBannerByID($id) {
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
//    }
}