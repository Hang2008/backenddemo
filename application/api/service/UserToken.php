<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 2:19 PM
 */

namespace app\api\service;


use app\api\model\UserModel;
use app\lib\exception\WeChatException;
use think\Exception;

class UserToken {
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
            $this->grantToken($wxResult);
        }
        return '';
    }

    private function processLoginError($wxResult) {
        throw new WeChatException(['message' => $wxResult['errmsg'], 'errorCode' => $wxResult['errcode']]);
    }

    private function grantToken($wxResult) {
        //拿到openid
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
            $uid = $this->createUser($openid);
        }
        $value = $this->createCahceValue($wxResult, $uid);

    }

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

    private function saveToCache($key, $value) {

    }
}