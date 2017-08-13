<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 30/07/2017
 * Time: 5:32 PM
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\OrderModel;
use app\api\service\OrderService;
use app\api\validate\IDPositiveIntValidate;
use app\api\validate\OrderValidate;
use app\api\service\Token as TokenService;
use app\api\validate\PageParamsValidate;
use app\lib\exception\OrderException;

class Order extends BaseController {
    protected $beforeActionList = ['checkIsNotAdminUser' => ['only' => 'submitOrder'],
                                   'checkUserPrivilege' => ['only' => 'getDetail, getSummaryByUser']];
    //用户向api提交商品包含商品相关信息
    //API接收到信息后,检查商品库存量
    //有库存的话把订单数据存入数据库中. 返回客户下单成功, 提示可以支付了
    //调用支付接口进行支付
    //扣款的时候再次检测库存量
    //服务器调用微信支付接口进行支付
    //小程序根据服务器返回结果拉起微信支付
    //不管支付成功还是失败微信返回支付结果(异步)
    //如果支付成功了, *再进行库存量检测(可选)*, 操作数据库减少库存量;
    //如果失败了不处理
    //*由微信返回客户端支付结果

    public function submitOrder() {
        (new OrderValidate())->validate();
        //products是一个数组,要用/a才能获取的到
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUID();
        $order = new OrderService();
        $status = $order->submitOrder($uid, $products);
        return $status;
    }

    public function getSummaryByUser($page = 1, $size = 15) {
        (new PageParamsValidate())->validate();
        $uid = TokenService::getCurrentUID();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
//对象不能这样判空!
        //        if(!$pagingOrders){
//
//        }
        //要这样
        if ($pagingOrders->isEmpty()) {
            return ['data' => [], 'current_page' => $pagingOrders->getCurrentPage()];
        }
        //hodden方法都没找到居然能隐藏
        $data = $pagingOrders->hidden(['snap_items', 'snap_address', 'prepay_id'])
                             ->toArray();
        return ['data' => $data, 'current_page' => $pagingOrders->getCurrentPage()];
    }

    public function getDetail($id) {
        (new IDPositiveIntValidate())->validate();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail) {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }
}