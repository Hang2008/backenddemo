<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 30/07/2017
 * Time: 5:32 PM
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\OrderValidate;
use app\api\service\Token as TokenService;

class Order extends BaseController {
    protected $beforeActionList = ['checkIsNotAdminUser' => ['only' => 'submitOrder']];
    //用户向api提交商品包含商品相关信息
    //API接收到信息后,检查商品库存量
    //有库存的话把订单数据存入数据库中. 返回客户下单成功, 提示可以支付了
    //调用支付接口进行支付
    //扣款的时候再次检测库存量
    //服务器调用微信支付接口进行支付
    //不管支付成功还是失败微信返回支付结果(异步)
    //如果支付成功了, *再进行库存量检测(可选)*, 操作数据库减少库存量;
    //如果失败了不处理
    //*由微信返回客户端支付结果

    public function submitOrder() {
        (new OrderValidate())->validate();
        //products是一个数组,要用/a才能获取的到
         $products = input('post.products/a');
         $uid = TokenService::getCurrentUID();
    }
}