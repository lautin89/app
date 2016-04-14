<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-21 16:41:51
 * @Version 1.0
 */
namespace Admin\Model;
class AuthGroupModel extends \Think\Model{
	//
	public $tableName = "auth_group";
	public $_validate = array(
		array("title", "require", "分组标题不能为空"),
		array("rules", "require", "分组权限未选择"),
	);
	public $_auto = array(
		array("rules", "join", "function", self::MODEL_INSERT, array(",")),
	);
}
