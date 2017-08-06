<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 05/08/2017
 * Time: 3:26 PM
 */

namespace app\api\service;


use app\api\model\OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\Loader;
use think\Log;

//引用没有命名空间的类, 比如加载SDK类
//TP5中代表extend文件夹的默认值为EXTEND_PATH
//如果不修改EXTEND_PATH,那么在这个路径下凡是带有命名空间的类都会被自动加载
//WxPay 没有命名空间所以不能被自动加载
//  extend/WxPay/Wxpay.Api.php
//引入这个文件他自己跟着引入了它需要的其他文件
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class PayService {
    private $orderID;
    private $orderNo;

    /**
     * PayService constructor.
     * @param $orderID
     * @param $orderNo
     */
    public function __construct($orderID) {
        if (!$orderID) {
            throw new Exception("Order id is null");
        }
        $this->orderID = $orderID;
    }

    //支付业务逻辑主方法
    public function pay() {
        //客户端传来的订单号不可信
        //1有可能不存在
        //2当前用户与订单号不匹配
        //3订单有可能已经被支付过
        $this->valideOrder();
        //进行库存量检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            //库存量没通过 终端支付流程
            return $status;
        }
        return $this->makeWxPreorder($status['sumPrice']);
    }

    private function makeWxPreorder($total) {
        //支付当然要知道用户openid是什么,不然微信扣谁的钱?
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        //没有命名空间的类new的时候前面要加\
        //
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($total * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        //支付结果回调
        $wxOrderData->SetNotify_url('http://qq.com');
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData) {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
//            throw new Exception('获取预支付订单失败');
        }
        return null;
    }

    private function valideOrder() {
        $order = OrderModel::where('id', '=', $this->orderID)
                           ->find();
        if (!$order) {
            throw new OrderException();
        }
        //查找到了order后比对uid
        //accesstoken从缓存中换取uid和order中的uid比较是否相同
        if (!Token::isValidOperation($order->user_id)) {
            throw new TokenException(["message" => "Order and user doesn't match", 'errorCode' => 10005]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException(["message" => "Order is already paid", 'errorCode' => 10005, 'code' => 400]);
        }
        $this->orderNo = $order->order_no;
        return true;
    }
}