<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-17 23:23:38
 * @Version 1.0
 */
/**
 * 用户登陆模块
 */
namespace Admin\Controller;
class LoginController extends \Think\Controller {
	//用户登陆表单
	public function logForm() {
		$this->display();
	}

	//生成验证码
	public function verifyCode() {
		//实例化verify类
		$verify = new \Think\Verify(array("useCurve" => false, "fontSize" => 13, "length" => 4, "useImgBg" => FALSE, "useNoise" => FALSE));
		//生成验证码
		$verify->entry();
	}

	//验证验证码的方法
	public function chkVerify($code) {
		$verify = new \Think\Verify();
		//开始验证 返回结果
		return $verify->check($code);
	}

	//登录验证
	public function logTodo() {
		//验证用户信息的有效性和真实性
		$userModel = D("User");
		if (FALSE == $userModel->create()) {
			$this->error($userModel->getError());
			exit();
		}
		//验证验证码
		if (!$this->chkVerify(I("post.code"))) {
			$this->error("验证码错误");
		}
		//验证账号
		$userRec = $userModel->where(array("uname" => I("post.uname")))->find();
		if (empty($userRec)) {
			$this->error("账号不存在，请检查！");
		} else if ($userRec['password'] != md5(I("post.password"))) {
			$this->error("密码错误，请重新输入！");
		} else {//登陆成功
			//将用户信息写入session 用以判断是否登陆
			session(array('name' => session_name(), 'expire' => 3600));
			session("userData", $userRec);
			//修改登陆状态
			$userModel->where(array("uid" => $userRec['uid']))->setInc("times", 1);
			//将createtime字段的值给logined 
			$userModel->where(array("uid" => $userRec['uid']))->data(array("logined" => $userRec['createtime']))->save();
			//将当前时间写入createtime
			$userModel->where(array("uid" => $userRec['uid']))->data(array("createtime" => date("Y-m-d H:i:s")))->save();
			//跳转至首页
			$this->success("登陆成功，正在跳转", U("Index/index"), 3);
		}
	}

	//用户退出
	public function logout() {
		//销毁用来检测登陆状态的userData属性
		session("userData", null);
		//跳转回首页
		$this->redirect("Index/index");
	}
	
	public function tips() {
		
	}

}
