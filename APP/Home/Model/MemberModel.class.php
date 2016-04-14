<?php

/* 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-4-5 22:49:50
 * @Version 1.0
 */
namespace Home\Model;
class MemberModel extends \Think\Model {
	public $tableName = "member";
	public $_validate = array(
		array("email", "require", "邮箱未填写", self::EXISTS_VALIDATE),
		array("tel", "require", "手机号未填写", self::EXISTS_VALIDATE),
	);
}
