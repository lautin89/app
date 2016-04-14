<?php
/* 许可证 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-16 14:17:44
 * @Version 1.0
 */
//Index控制器
namespace Admin\Controller;
class IndexController extends BaseController {
	public function index() {
		$this->userData = session("userData");
		$this->timestamp = time();
		$this->token = md5('uniqueID' . $this->timestamp);
		$this->display();
	}
}