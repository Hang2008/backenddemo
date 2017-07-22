<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 4:57 PM
 */

namespace app\api\controller\v1;

use app\api\model\BannerModel;
use app\api\validate\IDPositiveIntValidate;
use app\lib\exception\BannerNotFoundException;

class Banner {
    /**
     * @url /banner/:id
     * @http GETls
     * @param $id
     * 指定banner的id号
     */
    public function getBanner($id) {
        (new IDPositiveIntValidate())->validate();

        //$banner = BannerModel::get($id);
        //with参数是model中自定义的关联方法名, 可以传数组关联方法
        $banner = BannerModel::getBaanerById($id);

        //为了删除不想要的字段先把data取出来转换成数组
        //不是一个好的办法删除对象中的属性, 应该用对象的方法
//        $data = $banner->toArray();
//        unset($data['delete_time']);

        //对象的几种方法
//        $banner->hidden(['delete_time', 'update_time']);
//        $banner->visible(['id']);
        if (!$banner) {
            throw new BannerNotFoundException();
        }

        //返回的model就可以不用自己组装json
//        return json($banner);

        //这个工作应该交给模型在内部处理 返回的时候直接返回完整地址
        //$prefix = config('custom.img_prefix');
        //结局方案模型读取器
        return $banner;
    }
}