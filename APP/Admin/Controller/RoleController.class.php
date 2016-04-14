<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-20 12:58:38
 * @Version 1.0
 */

/**
 * 用户角色分组控制器
 */
namespace Admin\Controller;
class RoleController extends BaseController{
	//
	public function index() {
		//查询所有角色分组
		$this->group_list = M("auth_group")->select();
		//查询所有权限
		$this->rule_list = M("auth_rule")->select();
		//显示列表
		$this->display();
	}
	
	//往某个角色中添加一条权限
	public function setAuthGroup() {
		$rule_list = explode(",", M("auth_group")->getFieldById(I("get.id"), "rules"));
		//执行添加或者删除该权限的操作 先判断
		if (FALSE !== $key = array_search(I("get.rule"), $rule_list)) {
			unset($rule_list[$key]);
		} else {
			array_push($rule_list, I("get.rule"));
		}
		if (FALSE !== M("auth_group")->where(array("id" => I("get.id")))->data(array("rules" => implode(",", $rule_list)))->save()) {
			$this->ajaxReturn(array("status" => 1, "info" => "修改权限成功"));
		} else {
			$this->ajaxReturn(array("status" => 0, "info" => "修改权限失败"));
		}
	}
	
	//编辑分组显示名
	public function editTitle() {
		$this->group = M("auth_group")->where(array("id" => I("get.id")))->find();
		$this->display();
	}
	
	//修改分组显示名
	public function updateTitle() {
		if (FALSE !== $result = $this->group = M("auth_group")->where(array("id" => I("post.groupid")))->data(array("title" => I("post.title")))->save()) {
			$this->showMsg("修改分组名成功", U("Role/index"), 2, TRUE);
		} else {
			$this->error("修改分组名失败");
		}
	}
	
	//删除分组
	public function delete() {
		//删除分组  删除用户-分组  删除用户
		if (FALSE !== $grows = M("auth_group")->delete(I("get.id"))) {
			//获取该分组下的用户列表
			$result = M("auth_group_access")->where(array("group_id" => I("get.id")))->select();
			$uids = array();
			foreach ($result as $tmp) {
				array_push($uids, $tmp['uid']);
			}
			//删除用户分组
			if (FALSE !== M("auth_group_access")->where(array("group_id" => I("get.id")))->delete() ) {
				//删除用户
				$urows = M("User")->where("uid in (".join(",", $uids).")")->delete();
				$this->success("成功删除了{$grows}个分组，{$urows}个用户！", U("Role/index"),3);
			}
		} else {
			$this->error("删除失败！");
		}
	}
	
	//添加分组
	public function add() {
		//获取所有的权限
		$this->rule_list = M("auth_rule")->select();
		$this->display();
	}
	
	//插入分组
	public function insert() {
		$authGroupModel = D("authGroup");
		if (FALSE == $authGroupModel->create()) {
			$this->error($authGroupModel->getError());
		}
		//执行插入
		if (FALSE !== $result = $authGroupModel->add()) {
			$this->success("添加分组成功", U("Role/index"), 1);
		} else {
			$this->error("添加分组失败");
		}
	}
}
