<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 01/08/2017
 * Time: 7:37 PM
 */

namespace app\api\service;


use app\api\model\OrderModel;
use app\api\model\OrderProductModel;
use app\api\model\ProductModel;
use app\api\model\UserAddressModel;
use app\lib\exception\OrderException;
use app\lib\exception\UserNotFoundException;
use think\Db;
use think\Exception;

class OrderService {
    //客户端传递过来的products参数
    protected $rawProducts;
    //真实的商品信息 包括库存量
    protected $mProductsDatabase;
    protected $uid;

    /*
     * @$uid 下单目标
     * @$rawProducts 下单参数
     *
     * */
    public function submitOrder($uid, $rawProducts) {
        //对比$rawProducts和$mProductsDatabase
        $this->rawProducts = $rawProducts;
        //从数据库查询$mProductsDatabase
        $this->mProductsDatabase = $this->getProductsByRaw($rawProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();

        //如果pass是false, 那么依然返回客户端一个-1的订单号,流程结束!
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //如果没有结束,开始创建订单

        //订单快照, 用户下单瞬间生成的商品信息, 以后任何数据改变都不会改变快照, 快照信息保存在订单表里
        $orderSnap = $this->snapOrder($status);
        //创建订单 写入数据库
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    private function createOrder($snap) {
        //为了防止多个任务处理的时候出现异常,所以用事物处理
        Db::startTrans();
        try {
            //order和product是多对多关系
            //处理多对多关系拆成2个模型单独保存(一对多同理拆成2方一对一,先保存1,再保存多)
            //存储order表
            $orderNumber = $this->makeOrderNo();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_no = $orderNumber;
            $order->total_price = $snap['orderSum'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();

            //处理多对对关系order_product中间表
            $orderID = $order->id;
            $create_time = $order->create_time;
            //&$p! 不是 $p, 否则$this->rawProducts的值并不会改变, 推测这玩意取的是地址!
            foreach ($this->rawProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProductModel();
            //存储对象是一个数组,所以用saveall
            $orderProduct->saveAll($this->rawProducts);
            Db::commit();
            return ['order_no' => $orderNumber, 'order_id' => $orderID, 'create_time' => $create_time];
        } catch (Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    private function snapOrder($status) {
        $snap = ['orderSum' => 0, 'totalCount' => 0, ' pStatus' => [], 'snapAddress' => null, 'snapName' => '',
                 'snapImg' => ''];
        $snap['orderSum'] = $status['sumPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        //把数组序列化橙json字符串才能保存到数据库中
        //* 存 储对象最好用nosql 数据库比如mogodb,而非关系型数据库
        //* 这种存数方式对于检索历史信息很困难 就要做索引了
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        //订单缩略信息
        $snap['snapName'] = $this->mProductsDatabase[0]['name'];
        $snap['snapImg'] = $this->mProductsDatabase[0]['main_img_url'];
        if (count($this->mProductsDatabase) > 1) {
            $snap['snapName'] .= "等";
        }
        return $snap;
    }

    private function getUserAddress() {
        $address = UserAddressModel::where('user_id ', '=', $this->uid)
                                   ->find();
        if (!$address) {
            throw new UserNotFoundException(['messgae' => 'User address does not exist', '$errorCode' => 60001]);
        } else {
            return $address->toArray();
        }
    }

    //公有方法查询库存量
    public function checkOrderStock($orderID) {
        //我写的
//        $orderProducts = OrderProductModel::get($orderID);
        //为什么不用get?get是干什么的?
        $orderProducts = OrderProductModel::where('order_id', '=', $orderID)
                                          ->select();
        $this->rawProducts = $orderProducts;
        $this->mProductsDatabase = $this->getProductsByRaw($this->rawProducts);
        $status = $this->getOrderStatus();
        return $status;
    }

    //判断库存量业务逻辑
    //每次判断库存量都要通过拿到raw 和原始数据重新比较
    private function getOrderStatus() {
        //一组商品中任何一个商品缺货都认为订单失败
        //pStatusArray保存订单商品详细信息,客户端可以在历史订单和未支付订单中查看
        $status = ['pass' => true, 'sumPrice' => 0, 'totalCount' => 0, 'pStatusArray' => []];
        foreach ($this->rawProducts as $product) {
            $pStatus = $this->getProductStatus($product['product_id'], $product['count'], $this->mProductsDatabase);
            //任何一个商品缺货都把订单pass设为false
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['totalCount'] += $product['count'];
            $status['sumPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    //生成每一种商品的库存量状态和的总价
    //$pIndex表示$rawPID在$products数组中id 的序号
    private function getProductStatus($rawPID, $rawCount, $products) {
        $pIndex = -1;
        $pStatus = ['id' => null, 'haveStock' => false, 'count' => 0, 'name' => '', 'totalPrice' => 0];

        for ($i = 0; $i < count($products); $i++) {
            if ($rawPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            // 客户端传递的productid有可能根本不存在
            throw new OrderException(['message' => 'product id is' . $rawPID . "doesn't exist，creat order fail"]);
        } else {
            //拿到真实product
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $rawCount;
            $pStatus['totalPrice'] = $product['price'] * $rawCount;

            if ($product['stock'] - $rawCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    //根据订单信息查找真实商品信息
    private function getProductsByRaw($raw) {
        $rawPIDs = [];
        //把id全部取出一次性查询, 避免循环查询数据库!
        foreach ($raw as $item) {
            array_push($rawPIDs, $item['product_id']);
        }
        //传一个数组查询所有
        $products = ProductModel::all($rawPIDs)
                                ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])//查询出来是个collection转化成数组更好!
                                ->toArray();
        return $products;
    }

    public static function makeOrderNo() {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
}