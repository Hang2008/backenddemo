<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 02/08/2017
 * Time: 10:24 PM
 */

namespace app\api\model;


class OrderModel extends BaseModel {
    protected $table = 'order';
    protected $hidden = ['delete_time', 'update_time', 'user_id'];
    protected $autoWriteTimestamp = true;

    public static function getSummaryByUser($uid, $page = 1, $size = 15) {
//查询出所有
        //        self::where('user_id', '=', $uid)->select();
        //分页查询
        //简洁模式不需要知道总记录数
        //返回Paginator
        $pagingData = self::where('user_id', '=', $uid)
                          ->order('create_time desc')
                          ->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }

    //因为返回的snapitems不是jon格式 所以用读取器转换一下再返回
    public function getSnapItemsAttr($value) {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value) {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }
}