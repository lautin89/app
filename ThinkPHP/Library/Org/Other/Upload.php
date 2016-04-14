<?php
/**
 * Description of Upload
 *
 * @author liutian
 */
class Upload {
	var $file;
	var $allowedSize;
	var $allowedType;   //@param array 允许上传的文件类型
	var $saveDir;
	var $error;
	var $extension;	 //文件的后缀名
	var $filename;
	var $res;		//最终结果

	function __construct($inputName, $allowedSize, $allowedType, $saveDir) {
		$this->file = $_FILES[$inputName];
		$this->allowedSize = $allowedSize;
		$this->allowedType = $allowedType;
		$this->saveDir = $saveDir;
	}

	function chkUpload() {
		/*
		 * 1、校验文件是否上传
		 * 2、校验文件是否合法上传
		 */
		if (empty($this->file) || $this->file['error'] == 4) {
			$this->error = 1;
			//$this->getMsg();
		} elseif (!is_uploaded_file($this->file['tmp_name'])) {
			$this->error = 2;
			//$this->getMsg();
		}
	}

	function chkSize() {
		/**
		 * 1、检验文件的大小是否超出表单的限制 post_max_filesize
		 * 2、文件大小是否超出单独的空间的大小 upload_max_filesize
		 * 3、文件大小是否超出用户自定义的大小
		 */
		if ($this->file['error'] == 2) {
			$this->error = 3;
			//$this->getMsg();
		} elseif ($this->file['error'] == 1) {
			$this->error = 4;
			//$this->getMsg();
		}

		if ($this->file['size'] > $this->allowedSize) {
			$this->error = 5;
			//$this->getMsg();
		}
	}

	function chkType() {
		//首先获得用户上传的文件类型 然后判断是否存在于该数组中 如果不存在则进行报错
		$this->extension = strtolower(array_pop(explode(".", $this->file['name'])));
		if (!in_array($this->extension, $this->allowedType)) {
			$this->error = 6;
			//$this->getMsg();
		}
	}

	function chkError() {
		if ($this->file['error'] == 3) {
			$this->error = 7;
			//$this->getMsg();
		}
	}

	function move() {
		/*
		 * 1、重命名文件
		 * 2、转移
		 * 3、返回新的文件名
		 */
		$filename = date("YmdHis") . rand(1000, 9999) . "." . $this->extension;
		$create_dir = iconv("utf-8", "gbk", $this->saveDir);	//转码 避免中文在文件中因为编码的问题而判断错误
		if (!file_exists($create_dir)) { //保存的路径不存在 则现场创建
			mkdir($create_dir, 0777, true);
		}
		$save_path = $this->saveDir . DIRECTORY_SEPARATOR . $filename;
		$res = move_uploaded_file($this->file['tmp_name'], $save_path);
		$this->filename = $filename;
		if (!$res) {
			$this->error = 8;
		} else {
			$this->error = 0;
		}
		return $this->getMsg();
	}

	function getMsg() {
		switch ($this->error) {
			case 0: return array("status" => true, "msg" => $this->filename);
			case 1: return array("status" => false, "msg" => "没有文件上传");
			case 2: return array("status" => false, "msg" => "文件上传不合法");
			case 3: return array("status" => false, "msg" => "文件太大无法提交");
			case 4: return array("status" => false, "msg" => "文件大小超出脚本限制");
			case 5: return array("status" => false, "msg" => "文件大小超出" . ($this->allowedSize / 1024 / 1024) . "M，请重新选择");
			case 6: return array("status" => false, "msg" => "文件类型" . $this->extension . "不合法");
			case 7: return array("status" => false, "msg" => "文件被中断，没有上传成功");
			case 8: return array("status" => false, "msg" => "文件上传失败");
			default:return;
		}
	}

	function setOn() {
		$this->chkUpload();
		if ($this->error != 0) {
			return $this->getMsg();
		}
		$this->chkSize();
		if ($this->error != 0) {
			return $this->getMsg();
		}
		$this->chkType();
		if ($this->error != 0) {
			return $this->getMsg();
		}
		$this->chkError();
		if ($this->error != 0) {
			return $this->getMsg();
		}
		return $this->move();
	}

}