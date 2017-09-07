<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


//动态注册写法
use think\Route;

Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme', 'api/:version.Theme/getSimpleThemes');
Route::get('api/:version/theme/:id', 'api/:version.Theme/getThemeWithProducts');

//Route::get('api/:version/product/category/:id', 'api/:version.Product/getByCategory');
//Route::get('api/:version/product/:id', 'api/:version.Product/getOneById', [], ['id' => '\d+']);
//Route::get('api/:version/product/recent', 'api/:version.Product/getRecentProduct');

//路由分组
Route::group('api/:version/product', function () {
    Route::get('/category/:id', 'api/:version.Product/getByCategory');
    Route::get('/:id', 'api/:version.Product/getOneById', [], ['id' => '\d+']);
    Route::get('/recent', 'api/:version.Product/getRecentProduct');
});

Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');

Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::get('api/:version/address', 'api/:version.Address/getUserAddress');
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order', 'api/:version.Order/submitOrder');
Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail', [], ['id' => '\d+']);

Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');

Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');