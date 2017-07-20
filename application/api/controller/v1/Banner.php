<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 4:57 PM
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IDPositiveIntValidate;
use app\lib\exception\BannerNotFoundException;
use think\Model;

class Banner {
    /**
     * @url /banner/:id
     * @http GET
     * @param $id
     * 指定banner的id号
     */
    public function getBanner($id) {
        (new IDPositiveIntValidate())->validate();
        $banner = BannerModel::get($id);
//        $banner = Banner::getBannerByID($id);
        if (!$banner) {
            throw new BannerNotFoundException();
        }
        //返回的model就可以不用自己组装json
//        return json($banner);
        return $banner;
    }
}