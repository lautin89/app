<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-4-3 1:08:49
 * @Version 1.0
 */

namespace Home\Controller;

class LoginController extends \Think\Controller {

	//
	public function register() {
		$this->display();
	}

	//用户登陆
	public function login() {
		$this->display();
	}
	
	public function logout() {
		unset($_SESSION['QC_userData']);
		$this->success("成功退出", U("Index/index"),2);
	}
	

	//-----使用QQ互联登陆跳转窗口
	public function QCLogin() {
		$Oauth = new \Org\QConnect\Oauth();
		$Oauth->qq_login();
	}

	//------互联登陆回调入口
	public function QCTodo() {
		/**
		 * 获取authorize_code
		 */
		$Oauth = new \Org\QConnect\Oauth();
		/**
		 * 获取该用户的access_token和openid ,并将值
		 * 每个用户的access_token授权有效期为3个月 openid唯一
		 */
		$access_token = $Oauth->qq_callback();
		//获取openid
		$openid = $Oauth->get_openid();
		//获取用户基本信息
		$keysArr = array(
			"oauth_consumer_key" => $Oauth->recorder->readInc("appid"),
			"access_token" => $access_token,
			"openid" => $openid,
		);
		$graph_url = $Oauth->urlUtils->combineURL("https://graph.qq.com/user/get_user_info", $keysArr);
		$response = $Oauth->urlUtils->get_contents($graph_url);
		$member = json_decode($response);
		//判断用户登陆状态 通过access_token和openid识别唯一用户
		$result = M("member")->where(array("access_token" => $access_token, "openid" => $openid))->find();
		/**
		 * 如果查找结果为空 则说明该用户是第一次使用登陆QQ 执行流程如下：
		 *		添加该用户信息---->完善用户个人资料----->登陆成功记录状态并跳转到主页
		 */
		if (empty($result)) {//添加用户信息
			$member->access_token = $access_token;
			$member->openid = $openid;
			$this->stepOne($member);
		} else if (!$result['tel'] || !$result['email']) {//完善用户信息
			$this->stepTwo($result['mid']);
		} else {//登陆成功 记录状态
			$this->stepThree($result['mid']);
		}
	}

	//添加一条用户信息
	public function stepOne($member) {
		//重组数据值 由对象转化成数组 并进行自动验证
		$data = array();
		if(is_object($member)) {
			foreach ($member as $k=>$v) {
				$data[$k] = $v;
			}
		}
		$memModel = D("Member");
		//创建数据对象 进行字段映射 过滤非法字段
		if (FALSE == $memModel->create($data)) {
			$this->error($memModel->getError());
		} 
		//执行数据添加
		if (FALSE !== $result = $memModel->add()) {
			//添加信息成功进入完善数据页面
			$this->stepTwo($result);
		} else {
			$this->error("登陆失败！");
		}
	}

	//完善用户信息
	public function stepTwo($mid = NULL) {
		if (isset($_POST['submit'])) {//有POST表单数据 执行插入
			$memModel = D("Member");
			//创建数据对象 执行自动验证的过程
			if (FALSE == $memModel->create()) {
				$this->error($memModel->getError());
			}
			//执行修改数据操作
			if (FALSE !== $memModel->where(array("mid" => I('post.mid')))->save()) {
				$this->stepThree(I("post.mid"));
			} else {
				$this->error("操作失败");
			}
		} else if ($mid) {//显示表单数据值
			$this->mid = $mid;
			$this->display("Login/stepTwo");
		}
	}

	//完善信息成功后的操作
	public function stepThree($mid = NULL) {
		//查找用户信息
		!empty($_GET['mid']) && $mid = $_GET['mid'];
		$member = M("member")->where(array("mid" => $mid))->find();
		//将用户信息写入session
		session("QC_USER", $member);
		//同步更新微博
		$Oauth = new \Org\QConnect\Oauth();
		//组装参数
		$keysArr = array(
			"format" => "json",
			"content" => "我刚刚登陆了http://www.ahphp.org！",
			"access_token" => $member["access_token"],
			"oauth_consumer_key" => $Oauth->recorder->readInc("appid"),
			"openid" => $member["openid"],
		);
		$response = $Oauth->urlUtils->post("https://graph.qq.com/t/add_t", $keysArr);
		$data = json_decode($response);
		//跳转至首页登陆框
		$this->success("登陆成功".$data->msg, U("Index/index"), 10);
	}

}
