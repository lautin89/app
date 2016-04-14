<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-23 16:14:32
 * @Version 1.0
 */

/**
 * describe of ColumnModel
 */
namespace Admin\Model;
class ColumnModel extends \Think\Model{
	//
	public $tableName = "column";
	public $_validate = array(
		array("name","require","栏目名称未填写",self::MUST_VALIDATE, "", self::MODEL_BOTH),
		array("url", "require", "栏目链接未填写",self::MUST_VALIDATE, "", self::MODEL_BOTH),
	);
}
