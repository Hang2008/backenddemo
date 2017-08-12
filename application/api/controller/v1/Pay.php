<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 05/08/2017
 * Time: 3:09 PM
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\MyWxNotify;
use app\api\service\PayService;
use app\api\validate\IDPositiveIntValidate;

class Pay extends BaseController {
    protected $beforeActionList = ['checkIsNotAdminUser' => ['only' => 'getPreOrder']];

    //客户端需要传给服务器订单id, 生成preorder,其他字段不需要客户端关心. openid可以由accesstoken获取
    public function getPreOrder($id = '') {
        (new IDPositiveIntValidate())->validate();
        $pay = new PayService($id);
        return $pay->pay();
    }

    //只调一次和连续不断调用是有区别的
    public function receiveNotify() {
        //微信会有一个时间频率连续调用我们的支付回调借口
        //15/15/...../1800/3600秒/停止

        //收到微信的回调后
        //1.检测库存量, 超卖
        //2.更新这个订单的status状态
        //3.减库存
        //如果成功处理, 我们返回微信成功处理的消息
        //如果发生异常,微信会继续发送通知

        //微信回调格式:post请求,不带参数, 返回结果携带xml数据
        $notify = new MyWxNotify();
        $notify->Handle();
    }
}