<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 30/07/2017
 * Time: 3:54 PM
 */

namespace app\lib\enum;

//php里面没有枚举类型, 所以自定义一个类模拟枚举类型
class ScopeEnum {
    const User = 16;
    const Super = 32;
}