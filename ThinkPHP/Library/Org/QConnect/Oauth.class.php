<?php

/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

namespace Org\QConnect;

class Oauth {

	const VERSION = "2.0";
	const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
	const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
	const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

	public $recorder;
	public $urlUtils;
	protected $error;

	function __construct() {
		$this->recorder = new Recorder();
		$this->urlUtils = new URL();
		$this->error = new ErrorCase();
	}

	/**
	 * QQ登陆的方法：发送请求到authorization服务器 征求授权 并获取authorization_code
	 * 如果授权过程中 用户取消登陆 则登陆页面直接关闭 
	 * 否则跳转至回调页面 并携带authorization_code和state参数值
	 */
	public function qq_login() {
		$appid = $this->recorder->readInc("appid");
		$callback = $this->recorder->readInc("callback");
		$scope = $this->recorder->readInc("scope");
		//-------生成唯一随机串防CSRF攻击
		$state = md5(uniqid(rand(), TRUE));
		$this->recorder->write('state', $state);

		//-------构造请求参数列表
		$keysArr = array(
			"response_type" => "code",
			"client_id" => $appid,
			"redirect_uri" => $callback,
			"state" => $state,
			"scope" => $scope
		);
		//---------发起请求
		$login_url = $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
		header("Location:$login_url");
	}

	/**
	 * 请求回调的处理
	 * 1、验证state 防止CSRF
	 * 2、由获取到的authorization_code请求access_token  获取到的code会在10分钟内过期 你不能重复获取
	 */
	public function qq_callback() {
		/**
		 * 验证state参数值 防CSRF攻击
		 */
		$state = $this->recorder->read("state");
		if ($_GET['state'] != $state) {
			$this->error->showError("30001");
		}

		//-------请求参数列表
		$keysArr = array(
			"grant_type" => "authorization_code",
			"client_id" => $this->recorder->readInc("appid"),
			"redirect_uri" => $this->recorder->readInc("callback"),
			"client_secret" => $this->recorder->readInc("appkey"),
			"code" => $_GET['code']   //传入authorization_code值
		);

		//------构造请求access_token的url
		$token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
		$response = $this->urlUtils->get_contents($token_url);

		/**
		 * 请求错误时的显示消息
		 * callback( { } );
		 */
		if (strpos($response, "callback") !== false) {
			$lpos = strpos($response, "(");
			$rpos = strrpos($response, ")");
			$response = substr($response, $lpos + 1, $rpos - $lpos - 1);
			//获取有效的返回值信息  并进行json反编码
			$msg = json_decode($response);
			//判断是否发生错误
			if (isset($msg->error)) {//"error":100020,"error_description":"code is reused error"
				$this->error->showError($msg->error, $msg->error_description);
			}
		}
		$params = array();
		//如果 response 是 URL 传递入的查询字符串（query string），则将它解析为变量并设置到当前作用域。
		parse_str($response, $params);
		$this->recorder->write("access_token", $params["access_token"]);
		return $params["access_token"];
	}

	public function get_openid() {

		//-------请求参数列表
		$keysArr = array(
			"access_token" => $this->recorder->read("access_token")
		);

		$graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
		$response = $this->urlUtils->get_contents($graph_url);
		//--------返回值"callback( {"client_id":"101047309","openid":"97F9CDA2755FE366628282CFA0E918C5"} ); " 
		if (strpos($response, "callback") !== false) {
			$lpos = strpos($response, "(");
			$rpos = strrpos($response, ")");
			$response = substr($response, $lpos + 1, $rpos - $lpos - 1);
		}

		$user = json_decode($response);
		if (isset($user->error)) {
			$this->error->showError($user->error, $user->error_description);
		}

		//------记录openid
		$this->recorder->write("openid", $user->openid);
		return $user->openid;
	}

}

class URL {

	private $error;

	public function __construct() {
		$this->error = new ErrorCase();
	}

	/**
	 * combineURL
	 * 拼接url
	 * @param string $baseURL   基于的url
	 * @param array  $keysArr   参数列表数组
	 * @return string           返回拼接的url
	 */
	public function combineURL($baseURL, $keysArr) {
//		$combined = $baseURL . "?";
//		$valueArr = array();
//
//		foreach ($keysArr as $key => $val) {
//			$valueArr[] = "$key=$val";
//		}
//
//		$keyStr = implode("&", $valueArr);
//		$combined .= ($keyStr);
		$combined = $baseURL;
		$join = "?";
		foreach ($keysArr as $key => $val) {
			$combined.= $join . "{$key}={$val}";
			$join = "&";
		}
		return $combined;
	}

	/**
	 * get_contents
	 * 服务器通过get请求获得内容
	 * @param string $url       请求的url,拼接后的
	 * @return string           请求返回的内容
	 */
	public function get_contents($url) {
		//如果开启了 allow_url_fopen函数 则使用file_get_contents获取
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		//执行curl指令
		$response = curl_exec($ch);
		//关闭curl服务
		curl_close($ch);
//		var_dump($response);exit;//debug
		//-------请求为空
		if (empty($response)) {
			$this->error->showError("50001");
		}
		return $response;
	}

	/**
	 * get
	 * get方式请求资源
	 * @param string $url     基于的baseUrl
	 * @param array $keysArr  参数列表数组      
	 * @return string         返回的资源内容
	 */
	public function get($url, $keysArr) {
		$combined = $this->combineURL($url, $keysArr);
		return $this->get_contents($combined);
	}

	/**
	 * post
	 * post方式请求资源
	 * @param string $url       基于的baseUrl
	 * @param array $keysArr    请求的参数列表
	 * @param int $flag         标志位
	 * @return string           返回的资源内容
	 */
	public function post($url, $keysArr, $flag = 0) {
		$ch = curl_init();
		if (!$flag)	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		//curl_return transfer
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);

		curl_close($ch);
		return $ret;
	}

}

/**
 * 数据操作类
 */
class Recorder {

	private static $data;
	private $inc;
	private $error;

	/**
	 * 初始化读取用户配置信息存入inc属性
	 * 初始化用户信息写入data静态属性中
	 */
	public function __construct() {
		//------实例化错误处理案例
		$this->error = new ErrorCase();

		//------初始化互联登陆应用信息
		if (C("QCLOGIN") && !file_exists(APP_PATH . "/Home/Conf/qclogin.inc")) {//如果文件不存在则创建inc文件
			file_put_contents(APP_PATH . "/Home/Conf/qclogin.inc", json_encode(C("QCLOGIN")));
		}
		//读取配置的互联信息 并进行json反编码 转化成对象形式
		$this->inc = json_decode(file_get_contents(APP_PATH . "/Home/Conf/qclogin.inc"));
		//如果为空 则进行报错
		if (empty($this->inc)) {
			$this->error->showError("20001");
		}
		/**
		 * 初始化data数据值为空 当已经登陆后将数据值写入session中 下次登陆从session中取
		 */
		if (empty($_SESSION['QC_userData'])) {
			self::$data = array();
		} else {
			self::$data = $_SESSION['QC_userData'];
		}
	}

	//---------写入data数据值
	public function write($name, $value) {
		self::$data[$name] = $value;
	}

	//--------读取data中的属性
	public function read($name) {
		if (empty(self::$data[$name])) {
			return null;
		} else {
			return self::$data[$name];
		}
	}

	//--------读取配置属性
	public function readInc($name) {
		if (empty($this->inc->$name)) {
			return null;
		} else {
			return $this->inc->$name;
		}
	}

	//--------删除data属性值
	public function delete($name) {
		unset(self::$data[$name]);
	}

	//--------析构函数 
	//脚本结束时 将当前存储的data属性写入session 便于下次再使用
	function __destruct() {
		$_SESSION['QC_userData'] = self::$data;
	}

}

/*
 * @brief ErrorCase类，封闭异常
 * */

class ErrorCase {

	private $errorMsg;

	public function __construct() {
		$this->errorMsg = array(
			"20001" => "<h2>配置文件损坏或无法读取，请重新执行intall</h2>",
			"30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
			"50001" => "<h2>可能是服务器无法请求https协议</h2>可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
		);
	}

	/**
	 * showError
	 * 显示错误信息
	 * @param int $code    错误代码
	 * @param string $description 描述信息（可选）
	 */
	public function showError($code, $description = '$') {
		$recorder = new Recorder();
		if (!$recorder->readInc("errorReport")) {
			die(); //die quietly
		}


		echo "<meta charset=\"UTF-8\">";
		if ($description == "$") {
			die($this->errorMsg[$code]);
		} else {
			echo "<h3>error:</h3>$code";
			echo "<h3>msg  :</h3>$description";
			exit();
		}
	}

	public function showTips($code, $description = '$') {
		
	}

}
