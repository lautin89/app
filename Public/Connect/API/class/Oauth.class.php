<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

require_once(CLASS_PATH."Recorder.class.php");
require_once(CLASS_PATH."URL.class.php");
require_once(CLASS_PATH."ErrorCase.class.php");

class Oauth{

    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    protected $recorder;
    public $urlUtils;
    protected $error;
    
	/**
	 * 实例化工具类
	 */
    function __construct(){
        $this->recorder = new Recorder();
        $this->urlUtils = new URL();
        $this->error = new ErrorCase();
    }
	
	//发送QQ登陆请求的方法
    public function qq_login(){
        $appid = $this->recorder->readInc("appid");
        $callback = $this->recorder->readInc("callback");
        $scope = $this->recorder->readInc("scope");

        //-------生成唯一随机串防CSRF攻击 并存入data中
        $state = md5(uniqid(rand(), TRUE));
        $this->recorder->write('state',$state);

        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",		//授权类型 固定值为code
            "client_id" => $appid,			//申请的app ID号
            "redirect_uri" => $callback,	//回调地址
            "state" => $state,				//携带参数 防CSRF(CROSS-SIZE REQUST FORERY)
            "scope" => $scope				//拉取的权限
        );
		
		//请求至QQ服务器
        $login_url =  $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
        header("Location:$login_url");
    }
	
	
	/**
	 * 回调地址的入口
	 * @return array
	 */
    public function qq_callback(){
		//--------验证state防止CSRF攻击
        $state = $this->recorder->read("state");
        if($_GET['state'] != $state){
            $this->error->showError("30001");
        }

        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",				//固定值为authorization_code 
            "client_id" => $this->recorder->readInc("appid"),	//申请接入的app的分配的ID号
            "redirect_uri" => urlencode($this->recorder->readInc("callback")),	//登陆跳转回调地址
            "client_secret" => $this->recorder->readInc("appkey"),	//申请接入的app的密钥
            "code" => $_GET['code']		//获取到的authorization_code
        );

        //------构造请求access_token的url
        $token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
        $response = $this->urlUtils->get_contents($token_url);
		
		//返回值中包含callback
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
                $this->error->showError($msg->error, $msg->error_description);
            }
        }

        $params = array();
        parse_str($response, $params);
		//将access_token写入data数据中
        $this->recorder->write("access_token", $params["access_token"]);
        return $params["access_token"];

    }

    public function get_openid(){
        //-------请求参数列表
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );

        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            $this->error->showError($user->error, $user->error_description);
        }

        //------记录openid
        $this->recorder->write("openid", $user->openid);
        return $user->openid;

    }
}
