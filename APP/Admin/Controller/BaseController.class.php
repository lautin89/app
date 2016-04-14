<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-17 14:57:17
 * @Version 1.0
 */
/**
 * 基本控制器类
 */

namespace Admin\Controller;

class BaseController extends \Think\Controller {

	//初始化控制器时的执行动作
	public function _initialize() {
//		检查安装
		$this->chkInstall();
		//验证登陆
		$this->chkLogin();
		//验证权限
		$this->chkAuth();
		//查询所有栏目 写入模板中
		$this->col_list = M("column")->order("CONCAT_WS(',',path,cid)")->select();
	}

	//检查用户是否已经登陆
	public function chkLogin() {
		//用户控制器过来的操作都无需验证
		if (!session("?userData")) {
//			$this->error("用户尚未登陆，无法查看！");
			//跳转到登陆页面
			$this->redirect("Login/logForm");
		}
	}

	//检查用户是否有相应操作的权限
	public function chkAuth() {
		//获取要验证的URL
		$rows = M("auth_rule")->where("status = 1")->field("name,title")->select();
		$auth_list = array();
		foreach ($rows as $tmp) {//array("Post/add" => "日志添加", "Post/delete" => "日志删除", "Post/update"......);
			$auth_list[$tmp['name']] = $tmp['title'];
		}
		//判断当前要访问的路由是否需要验证
		if (array_key_exists(CONTROLLER_NAME . "/" . ACTION_NAME, $auth_list)) {
			$Auth = new \Think\Auth();
			$userRec = session("userData");
			if (!$Auth->check(CONTROLLER_NAME . "/" . ACTION_NAME, $userRec['uid'])) {
				$this->error("用户无权" . $auth_list[CONTROLLER_NAME . "/" . ACTION_NAME] . "！");
			}
		}
	}

	/**
	 * 操作成功跳转提示的方法
	 * @param string $msg		提示信息
	 * @param string $url		跳转地址
	 * @param int $delay		延迟时间
	 */
	public function showMsg($msg, $url = NULL, $delay = 3, $isScript = FALSE) {
		empty($url) && $url = $_SERVER['REQUEST_URI'];
		if ($isScript) {
			echo "<html><meta charset='utf-8' /><body>{$msg}，{$delay}秒后为你跳转！<script>setTimeout(function () {";
			echo "var L = parent.location || location; ";
			echo "L.href = '{$url}';";
			echo "},{$delay}*1000);</script></body></html>";
		} else {
			echo "<html><meta charset='utf-8' /><meta http-equiv='refresh' content='{$delay};url={$url}' />";
			echo "<body>{$msg}，{$delay}秒后为你跳转~</body></html>";
		}
	}

	//检查安装
	public function chkInstall() {
		if (!file_exists(APP_PATH."/Install/Common/lock.txt")) {
			$this->redirect("Install/Index/index");
		}
	}
}
