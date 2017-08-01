<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 01/08/2017
 * Time: 7:37 PM
 */

namespace app\api\service;


use app\api\model\ProductModel;
use app\lib\exception\OrderException;

class OrderService {
    //客户端传递过来的products参数
    protected $rawProducts;
    //真实的商品信息 包括库存量
    protected $mProductsDatabase;
    protected $uid;

    public function submitOrder($uid, $rawProducts) {
        //对比$rawProducts和$mProductsDatabase
        //从数据库查询$mProductsDatabase
        $this->rawProducts = $rawProducts;
        $this->mProductsDatabase = $this->getProductsByRaw($rawProducts);
        $this->uid = $uid;
    }

    private function getOrderStatus() {
        //一组商品中任何一个商品缺货都认为订单失败
        //pStatusArray保存订单商品详细信息,客户端可以在历史订单和未支付订单中查看
        $status = ['pass' => true, 'sumPrice' => 0, 'pStatusArray' => []];

        //遍历来对比库存量
        foreach ($this->rawProducts as $product) {
            $pStatus = $this->getProductStatus($product['product_id'], $product['count'], $this->mProductsDatabase);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            } 
            $status['sumPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);
        }

    }

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
        foreach ($raw as $item) {
            array_push($rawPIDs, $item['product_id']);
        }
        $products = ProductModel::all($rawPIDs)
                                ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])//查询出来是个collection转化成数组更好!
                                ->toArray();
        return $products;
    }
}