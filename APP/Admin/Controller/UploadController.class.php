<?php
/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-29 11:44:42
 * @Version 1.0
 */
namespace Admin\Controller;
class UploadController extends \Think\Controller {
	private $saveRoot;			//保存文件根目录 默认为public目录
	private $savePath;			//保存路径
	private $maxSize;			//文件最大体积
	private $exts;				//允许后缀名
	private $error;				//上传错误信息
	//初始化参数
	public function __init($config = NULL) {
		$this->saveRoot = isset($config['saveRoot']) ? $config['saveRoot'] : $_SERVER['DOCUMENT_ROOT']."/Public" ;
		$this->savePath = isset($config['savePath']) ? $config['savePath'] : "" ;
		$this->maxSize = isset($config['maxSize']) ? $config['maxSize'] : 1*1024*1024;
		$this->exts = isset($config['exts']) ? $config['exts'] : array();
	}
	
	//上传启动文件
	public function upload($iptName) {
		$file = $_FILES[$iptName];
		//上传合法性验证
		if (!is_uploaded_file($file['tmp_name'])) {
			$this->error =  "上传不合法！";
			return FALSE;
		}
		if ($file['error'] != 0)	{
			$this->error =  "上传发生错误！";
			return FALSE;
		}
		//验证文件类型
		$fileParts = pathinfo($file['name']);
		if (!empty($this->exts) && !in_array(strtolower($fileParts['extension']), $this->exts)) {
			$this->error =  "文件类型不支持！";
			return FALSE;
		}
		//验证文件大小
		if ($file['size'] > $this->maxSize)	{
			$this->error = "文件体积超出要求！";
			return FALSE;
		}
		//转存文件
		$saveName = date("YmdHis").rand(1000,9999).".".$fileParts['extension'];
		//动态创建文件
		if (!is_readable($this->saveRoot.DIRECTORY_SEPARATOR.$this->savePath)) {
			@mkdir($this->saveRoot.DIRECTORY_SEPARATOR.$this->savePath. 0777, TRUE);//支持递归创建
		}
		$destination = $this->saveRoot.DIRECTORY_SEPARATOR.$this->savePath.DIRECTORY_SEPARATOR.$saveName;
		if (!move_uploaded_file($file['tmp_name'], $destination)) {
			$this->error = "上传失败";
			return FALSE;
		}
		//执行成功 返回保存的文件路径 除根目录
		return $this->savePath.DIRECTORY_SEPARATOR.$saveName;
	}
	
	//获取上传错误
	public function getError() {
		return $this->error;
	}
	
	//上传头像
	public function avartar() {
		//验证权限
		if (md5("uniqueID".I("post.timestamp")) != I("post.token")) {
			$this->ajaxReturn(array("status" => FALSE, "info" =>"密钥验证不通过！"));
		} 
		//初始化配置参数
		$this->__init(array("exts" => array("jpg", "jpeg", "bmp", "png", "gif"), "savePath" => "Uploads/avartar"));
		//执行文件上传
		if (!$result = $this->upload("Filedata")) {
			$this->ajaxReturn(array("status" => FALSE, "info" => $this->getError()));
		} else {
			M("User")->where(array("uid" => I("post.uid")))->data(array("avartar" => $result))->save();
			//返回提示信息
			$this->ajaxReturn(array("status" => TRUE, "info" => $result));
		}
	}
}
