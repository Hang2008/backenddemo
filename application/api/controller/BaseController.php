<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 31/07/2017
 * Time: 4:49 PM
 */

namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller {
    //不能用private我也是醉了
    protected function checkUserPrivilege() {
        TokenService::checkPrimaryPrivilege();
    }

    protected function checkIsNotAdminUser() {
        TokenService::excludeAdminUser();
    }
}