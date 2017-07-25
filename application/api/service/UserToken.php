<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 2:19 PM
 */

namespace app\api\service;


use app\api\model\UserModel;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;

class UserToken extends Token {
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    /**
     * UserToken constructor.
     * @param $code
     * @param $wxAppId
     * @param $wxAppSecret
     * @param $wxLoginUrl
     */
    public function __construct($code) {
        $this->code = $code;
        $this->wxAppId = config('wx_config.app_id');
        $this->wxAppSecret = config('wx_config.app_secret');
        //可以替换占位符%s
        $this->wxLoginUrl = sprintf(config('wx_config.login_url'), $this->wxAppId, $this->wxAppSecret, $this->code);
    }

    public function get() {
        $response = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($response, true);
        if (empty($wxResult)) {
            throw new Exception('get session_key and openid exception, internal error');
        } else if (array_key_exists('errcode', $wxResult)) {
            $this->processLoginError($wxResult);
        } else {
            //拿到了openid然后去去拿token
            return $this->grantToken($wxResult);
        }
    }

    private function processLoginError($wxResult) {
        throw new WeChatException(['message' => $wxResult['errmsg'], 'errorCode' => $wxResult['errcode']]);
    }

    private function grantToken($wxResult) {
        //拿到openid后服务器端生成token并返回给客户端
        //看数据库里是否存在此openid, 如果存在则不处理,如果不存在,新增一条记录
        //生成令牌,准备缓存数据,写入缓存
        //返回令牌到客户端
        //令牌对应所有信息是key
        //key: token
        //value: $wxResult, uid, scope
        $openid = $wxResult['openid'];
        $user = UserModel::getUserByOpenID($openid);
        if ($user) {
            $uid = $user->id;
        } else {
            //如果数据库中没有用户则插入一条数据创建用户
            $uid = $this->createUser($openid);
        }
        $value = $this->createCahceValue($wxResult, $uid);
        return $this->saveToCache($value);
    }

    //创建缓存数据, 需要保存wx数据, uid和scope 是一组数字
    private function createCahceValue($wxResult, $uid) {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = 16;
        return $cacheValue;
    }

    private function createUser($openid) {
        $user = UserModel::create(['openid' => $openid]);
        return $user->id;
    }

    private function saveToCache($value) {
        $key = self::generateToken();
        //数组转化成json格式字符串
        $value = json_encode($value);
        //给token设置一个过期时间
        $expire_in = config('custom.token_expire_in');

        //这个地方既能保存又能获取?很神奇..
        $request = cache($key, $value, $expire_in);
        if (!$request) {
            throw new TokenException([
                'message' => 'Server cache error',
                'errorCode' => 10003
            ]);
        }
        return $key;
    }
}