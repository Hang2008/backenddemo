<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 28/07/2017
 * Time: 9:14 PM
 */

namespace app\api\validate;


class AddressNew extends BaseValidate {
    protected $rule = ['name' => 'require|isNotempty', 'mobile' => 'require|isMobile',
                       'province' => 'require|isNotempty', 'city' => 'require|isNotempty',
                       'country' => 'require|isNotempty', 'detail' => 'require|isNotempty'];
}