<?php
namespace Install\Controller;
use Think\Controller;
class IndexController extends Controller {

	public function index() {
		$this->display();
	}

	//安装进程
	public function one() {
		echo "正在安装......";
		//提取出变量和对应的值
		extract($_POST);
//		var_dump($_POST);exit;//debug
		 
		if (!$conn = mysqli_connect($host, $user, $password)) {
			echo "数据库连接失败，请检查数据库配置，<a href='Install/Index/index'>返回</a>";
			exit;
		}
		if (!mysqli_select_db($conn, $dbname)) {
			echo "填写的数据库名有误！<a href='Install/Index/index'>返回</a>";
			exit;
		}
		mysqli_set_charset($conn, "utf8");

		//打开文件
		$fp = fopen(APP_PATH . "/Install/Common/sh38.sql", 'r');
		while (!feof($fp)) {
			//读取一行
			$line = rtrim(fgets($fp, 1024));
			//结束时的执行
			if (preg_match("#;$#", $line)) {
				$query .= $line . "\n";
				//替换表前缀
				$rs = mysqli_query($conn, $query);
				//
				$query = '';
				//组装要执行的SQL
			} else if (!preg_match("#^(\/\/|--)#", $line)) {//连接非空白行 不以 / // /| |--开头
				$query .= $line;
			}
		}
		fclose($fp);
		
		//生成配置文件
		$content = file_get_contents(APP_PATH."/Install/Common/common.config");
		$content = str_replace(array("%HOST%", "%USER%", "%PASSWORD%", "%DBNAME%"), $_POST, $content);
		file_put_contents(APP_PATH."/Admin/Conf/config.php", $content);
		
		//写入锁定文件
		file_put_contents(APP_PATH."/Install/Common/lock.txt", "OK!");
		//跳转至首页
		$this->redirect("Admin/Index/index");
	}

}
