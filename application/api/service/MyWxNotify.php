<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 12/08/2017
 * Time: 5:28 PM
 */

namespace app\api\service;

use app\api\model\OrderModel;
use app\api\model\ProductModel;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

//引入api.php而不是notify因为 api是对外接口内部引入了其他类
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class MyWxNotify extends \WxPayNotify {
    //微信回调,我们复写SDK方法执行自己的业务逻辑

    //*这个地方有可能有并发!
    //微信第一次返回成功但是微信回调平率之后我们没有来得及减少库存 第二次返回成功又过来了, 那么支付状态还是未支付.
    //这时我们又进入减少库存逻辑,就会减少2次
    //用事物来解决!
    public function NotifyProcess($data, &$msg) {
        if ($data['result_code'] == 'SUCESS') {
            $orderNo = $data['out_trade_no'];
            //加上事物后,其他请求过来会排队了
            Db::startTrans();
            try {
                $order = OrderModel::where('order_no', '=', $orderNo)
                                   ->find();
                //不是每一个订单都要处理,只处理订单未支付的情况
                if ($order->status == 1) {
                    $service = new OrderService();
                    //返回库存量检测信息
                    $stockStatus = $service->checkOrderStock($order->id);
                    if ($stockStatus['pass']) {
                        //如果通过检测
                        //1. 更新订单支付状态
                        //2. 更新库存量
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
                //控制微信是否继续发送回调通知
                return true;
            } catch (Exception $e) {
                Log::error($e);
                Db::rollback();
                return false;
            }
        } else {
            //返回false微信还会继续返回错误消息 是没有意义的, 需要去微信商户号里去看为什么失败
            return true;
        }
    }

    private function reduceStock($stockStatus) {
        foreach ($stockStatus['pStatusArray'] as $singlePstatus) {
            //tp5 通过模型直接可以在数据库中作数量增减
            ProductModel::where('id', '=', $singlePstatus['id'])
                        ->setDec('stock', $singlePstatus['count']);
        }
    }

    private function updateOrderStatus($orderID, $success) {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)
                  ->update(['status' => $status]);
    }
}