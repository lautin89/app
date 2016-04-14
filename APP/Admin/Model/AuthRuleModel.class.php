<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-21 21:52:16
 * @Version 1.0
 */
namespace Admin\Model;
class AuthRuleModel extends \Think\Model{
	//
	public $tableName = "auth_rule";
	public $_validate = array(
		array("name", "", "已有该权限名",self::MUST_VALIDATE, "unique", self::MODEL_BOTH),
		array("title", "require", "标题不能为空"),
	);
}
