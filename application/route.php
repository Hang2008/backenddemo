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
Route::get('api/:version/product/recent', 'api/:version.Product/getRecentProduct');
Route::get('api/:version/product/category/:id', 'api/:version.Product/getByCategory');
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

