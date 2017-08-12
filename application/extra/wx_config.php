<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 2:32 PM
 */

return ['app_id' => 'wx11a0aa6575e0a479',
        'app_secret' => '10cd8cc728162c6897b9ecf5a24003bb',
        'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?' .
            'appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
        'pay_back_url' => 'http://z.cn/api/v1/pay/notify'
        //微信服务器是无法直接访问我们本机的z.cn虚拟域名的. 我们需要部署在云服务器上,就有了外网访问权限.
        //Ngrok这类软件可以把本机作为反向代理,提供一个域名就可以给外网调用, 其实是他自己的服务器转发到你的本机
        //推荐用阿里云或者腾腾讯ecs等,安全一些
];