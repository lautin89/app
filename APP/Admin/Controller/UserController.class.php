<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-17 14:05:25
 * @Version 1.0
 */

/**
 * 用户模块
 */
namespace Admin\Controller;
class UserController extends BaseController {
	//显示所有用户列表
	public function index() {
		//判断有没有提交上来的查询关键字
		if (isset($_POST['keyword'])) {
			$keyword = trim(I("post.keyword"));
			$where = " uname LIKE '%".$keyword."%' OR nickname LIKE '%".$keyword."%'";
		} else {
			$keyword = "请输入用户名或昵称";
			$where = NULL;
		}
		//查询用户数据
		$user_list = D("User")->relation(true)->page(I("get.p", 1), C("PER_PAGE"))->where($where)->select();
//		var_dump($user_list);exit;//debug
		//查询页马兰
		$P = new \Think\Page(M("User")->count(), C("PER_PAGE"));
		$page_show = $P->show();
		//获取权限组数据
		$auth_group = M("auth_group")->select();
		//发送数据
		$this->assign("user_list", $user_list);
		$this->assign("keyword", $keyword);
		$this->assign("auth_group", $auth_group);
		$this->assign("page_show", $page_show);
		//驱动模板
		$this->display();
	}

	//设置用户角色
	public function setAuthGroupAccess() {
		//实例化控制器对象
		$AuthGroupAccessModel = M("AuthGroupAccess");
		//执行修改
		$result = $AuthGroupAccessModel->where(array("uid" => I("get.uid")))->data(array("group_id" => I("get.group_id")))->save();
		if ($result !== FALSE) {
			//返回一个经过json格式编码的数据
			$this->ajaxReturn(array("status" => 1, "info" => "执行成功"));
		} else {
			$this->ajaxReturn(array("status" => 0, "info" => "执行失败"));
		}
	}

	//删除用户操作
	public function delete() {
		if (FALSE === $result = M("User")->delete(I("get.uid"))) {
			$this->error("删除失败！");
		} else {
			$this->success("成功删除了{$result}条记录", U("User/index"), 2);
		}
	}

	//编辑用户信息
	public function edit() {
		//获取用户信息
		$userModel = D("User");
		$user_rec = $userModel->where(array("uid" => I("get.uid")))->relation(true)->find();
		//获取权限信息
		$auth_group_list = M("auth_group")->select();
		//发送数据
		$timestamp = time();
		$this->assign("timestamp", $timestamp);
		$this->assign("token", md5("uniqueID", $timestamp));
		$this->assign("user_rec", $user_rec);
		$this->assign("auth_group_list", $auth_group_list);
		//显示模板
		$this->display();
	}

	//修改用户数据
	public function update() {
		/**
		 * 修改用户基本信息
		 * 1、创建用户表模型
		 * 2、自动验证数据
		 * 3、校验密码 重组数据
		 * 4、执行修改
		 */
		//1、创建数据表模型
		$userModel = D("User");
		//3、创建数据对象
		if (FALSE === $userModel->create()) {
			$this->error($userModel->getError());
			exit();
		}
		//如果密码为空 则表示不重写 使用原有值
		if ($userModel->data['password'] == md5("")) {
			unset($userModel->data['password']);
		}
		//4、执行修改
		if (FALSE !== $result = $userModel->where(array("uid" => I("post.uid")))->save()) {
			//修改用户权限
			if (FALSE !== $result = M("auth_group_access")->where(array("uid" => I("post.uid")))->data(array("group_id" => I("post.group_id")))->save()) {
				$this->success("修改成功", U("User/index"), 3);
			} else {
				$this->error("修改失败~");
			}
		} else {
			$this->error("修改失败~");
		}
	}
	
	//添加用户
	public function add() {
		//获取权限信息
		$auth_group_list = M("auth_group")->select();
		//发送数据
		$this->assign("auth_group_list", $auth_group_list);
		//显示模板
		$this->display();
	}
	
	//插入用户
	public function insert() {
		//创建数据对象 执行相关验证和自动完成
		$userModel = D("User");
		if (FALSE === $userModel->create()) {
			$this->error($userModel->getError());
			exit();
		}
		//插入用户基本信息
		if (FALSE !== $result = $userModel->add()) {
			//添加用户角色组
			if (FALSE !== M("auth_group_access")->data(array("uid" => $result, "group_id" => I("post.group_id")))->add()) {
				$this->success("添加用户成功", U("User/index"),1);
			} else {
				$this->error("添加用户失败");
			}
		} else {
			$this->error("添加用户失败");
		}
	}
	
	//查找用户
	public function find() {
		$this->user_list = M("User")->where("uname LIKE '%".I("post.keyword")."%' OR mickname LIKE '%".I("post.keyword")."%'")->select();
		$this->keyword = I("post.keyword");
		$this->display();
	}

}