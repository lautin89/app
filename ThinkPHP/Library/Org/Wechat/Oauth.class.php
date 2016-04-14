<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-30 21:34:47
 * @Version 1.0
 */
namespace Org\Wechat;
class Oauth {
	//初始化数据操作类和错误处理类
	public function __construct() {
		
	}
	/**
	 * 接入有效性验证：
	 *	如果签名和token保持一致 则输入原样字符串
	 */
	public function valid() {
		$echoStr = $_GET["echostr"];
		//valid signature , option 验证签名 【可选】
		if ($this->checkSignature()) {
			echo $echoStr;
			exit;
		}
	}
	
	//验证签名
	private function checkSignature() {
		// you must define TOKEN by yourself
		if (!C("TOKEN")) {
			throw new Exception('请先设置TOKEN配置');
		}
		/**
		 * 获取签名、时间戳、随机值
		 */
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		$token = C("TOKEN");
		/**
		 * 由token生成signature签名
		 * 1、组装数组，使用sort进行字典排序
		 * 2、拼接成字符串
		 * 3、使用shal加密
		 */
		$tmpStr = shal(implode(sort(array($token, $timestamp, $nonce))));
		 
		/**
		 * 验证并返回结果
		 */
		return $tmpStr == $signature;
	}
	
	
	//获取POST请求结果
	public function postTo() {
		//获取post请求结果 依据不同环境
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		//extract post data
		if (!empty($postStr)) {
			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
			  the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
			if (!empty($keyword)) {
				$msgType = "text";
				$contentStr = "Welcome to wechat world!";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;
			} else {
				echo "Input something...";
			}
		} else {
			echo "";
			exit;
		}
	}
	
	//获取access_token
	function getAccessToken() {
		
	}
	
}

//读取信息的方法
class Record {
	protected $inc;							//配置信息初始化
	protected static $data;					//静态属性data 存放access_token 定期刷新
	//初始化属性值
	private function __construct() {
		if (!C("WECHAT") || !is_array(C("WECHAT"))) {
			throw new Exception("请先配置WECHAT选项！");
		}
		
		//初始化应用信息
		if (!file_exists(APP_PATH."/Wechat/Conf/wechat.inc")) {
			file_put_contents(APP_PATH."/Wechat/Conf/wechat.inc", json_encode(C("WECHAT")));
		}
		
		//读取配置文件信息
		$this->inc = json_decode(file_get_contents(APP_PATH."/Wechat/Conf/wechat.inc"));
		
		//初始化data属性值
		if (!session("WC_Data")) {
			self::$data = array();
		} else {
			self::$data = session("WC_Data");
		}
	}
	
	/**
	 * 读取配置信息
	 * @param type $name
	 * @return type
	 */
	public function readInc($name) {
		if (empty($this->inc->$name)) {
			return null;
		} else {
			return $this->inc->$name;
		}
	}
	
	//读取data属性值
	public function read($name) {
		if (empty(self::$data[$name])) {
			return null;
		} else {
			return self::$data[$name];
		}
	}
	
	//写入data属性值
	public function write($name, $value) {
		self::$data[$name] = $value;
	}
	
	//删除data中的某个属性
	public function delete($name) {
		unset(self::$data[$name]);
	}
	
	//脚本结束时 将data属性值写入session 便于下次使用
	public function __destruct() {
		session("WC_Data", self::$data);
	}
}

//URL 路由操作类
class Url {
	public function __construct() {
		;
	}
	
	/**
	 * URL拼接 返回组装好的接口地址
	 * @param string $url		接口地址
	 * @param array $keysArr	请求参数 键值对形式
	 */
	public function combineUrl($url, $keysArr) {
		$baseUrl = $url;
		$join = "?";
		foreach($keysArr as $name=>$val) {
			$baseUrl.= $join.$name."=".$val;
			$join = "&";
		}
	}
	
	/**
	 * 请求一个http资源
	 * @param string $url		请求地址
	 * @return string			返回结果
	 */
	public function get($url) {
		//创建一个新的CURL资源
		$ch = curl_init();
		//发起连接的等待时常 0则无限制
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		//将执行结果以文件流的形式返回 而不直接输出
		curl_setopt($ch, CURL_OPT_RETURNTRANSFER, TRUE);
		//设置url等选项参数
		curl_setopt($ch, CURL_OPT_URL, $url);
		//返回结果而不输出
		$response = curl_exec($ch);
		//关闭curl资源 释放系统资源
		curl_close($ch);
		//返回结果
		return $response;
	}
}