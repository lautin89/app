<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-22 19:37:11
 * @Version 1.0
 */

namespace Admin\Controller;

class ColumnController extends BaseController {

	//显示根栏目
	public function index() {
		//查询所有根栏目
		$this->columns = M("Column")->order("CONCAT_WS(',',path,cid)")->select();
		$this->display();
	}

	//添加栏目
	public function add() {
		$this->display();
	}

	//插入栏目
	public function insert() {
		$columnModel = D("column");
		/**
		 * 创建控制器文件
		 */
		$content = "<?php\n\r"
				. "namespace Admin\Controller;\n\r"
				. "class ".trim($_POST['url'])."Controller extends BaseController {\n\r"
				. "\n\r}";
		file_put_contents(APP_PATH . "/Admin/Controller/".trim($_POST['url'])."Controller.class.php", $content);
		/**
		 * 写入数据
		 */
		//创建数据对象
		if (FALSE == $columnModel->create()) {
			$this->error($columnModel->getError());
		}
		//添加一条记录
		if (FALSE !== $result = $columnModel->add()) {
			$this->success("成功插入一条记录，编号：" . $result, U("Column/index"), 1);
		} else {
			$this->error("操作失败");
		}
	}

	//插入子菜单
	public function insertChild() {
		//查找提交上的数据索引
		$idx = array_search("添加", $_POST);
		//从数组中提取值
		$data = $_POST[trim($idx, "'")];
		/**
		 * 创建控制器文件和模板文件
		 */
		@list($c, $a) = explode("/", $data["url"]);
		//读取控制器
		$content = file_get_contents(APP_PATH . "/Admin/Controller/{$c}Controller.class.php");
		//去除结尾  }
		$content = preg_replace("/}[\\r\\n\\t]*$/", "", $content);
		//追加方法
		$content .= "\tpublic function {$a}() {\n\r"
				. "\t\t\$this->display();\n\r"
				. "\t}\n\r"
				. "}";
		//写入文件
		file_put_contents(APP_PATH . "/Admin/Controller/{$c}Controller.class.php", $content);

		//创建模板
		if (!is_readable(APP_PATH . "Admin/View/" . $c)) {
			@mkdir(APP_PATH . "Admin/View/" . $c);
		}
		$handle = fopen(APP_PATH . "Admin/View/{$c}/{$a}.tpl", "a+");
		fputs($handle, "<include file='./header' />\n\r <!--put your code here--> \n\r<include file='./footer' />", 1024);
		fclose($handle);
		/**
		 * 将菜单写入数据库
		 */
		//创建数据对象
		$columnModel = D("Column");
		if (FALSE === $columnModel->create($data)) {
			$this->error($columnModel->getError());
		}
		//执行添加数据
		if (FALSE !== $columnModel->add()) {
			//跳转提示
			$this->success("添加菜单成功", U("Column/index"), 1);
		} else {
			$this->error("添加菜单失败");
		}
	}

	//删除栏目
	public function delete() {
		/**
		 * 删除相应的文件   
		 */
		//查找该栏目
		$column = M("Column")->where(array("cid" => I("get.cid")))->find();
		//如果为栏目 则删除控制器文件和模板文件夹
		if ($column['parentid'] == 0 && $column['path'] == 0) {
			@unlink(APP_PATH."/Admin/Controller/{$column['url']}Controller.class.php");
			deleteFold(APP_PATH."/Admin/View/{$column['url']}");
		} else {
			//菜单 则删除模板文件
			@unlink(APP_PATH . "/Admin/View/{$column['url']}.tpl");
		}
		/**
		 * 删除该栏目或菜单
		 */
		$result = M("Column")->where("cid = " . I("get.cid") . " or path like '%" . I("get.cid") . "%'")->delete();
		if ($result !== FALSE) {
			$this->success("删除成功，影响了{$result}条记录", U("Column/index"));
		} else {
			$this->error("删除失败");
		}
	}

	//编辑栏目
	public function edit() {
		//查询该栏目信息
		$col_rec = M("Column")->where(array("cid" => I("get.cid")))->find();
		if ($col_rec['parentid'] == 0 && $col_rec['path'] == 0) {
			//如果该类拥有子类 则不能修改
			$result = M("Column")->where("path like '%".I("get.cid")."%'")->find();
			!empty($result) && $this->error("该栏目含有菜单不能被编辑");	
		}
		$this->col_rec = $col_rec;
		//显示该栏目
		$this->display();
	}

	//修改栏目
	public function update() {
		//实例化表模型
		$columnModel = D("Column");
		//创建数据对象
		if (FALSE === $columnModel->create()) {
			$this->error($columnModel->getError());
		}
		//执行修改
		if (FALSE !== $columnModel->where(array("cid" => I("post.cid")))->save()) {
			$this->success("修改成功", U("Column/index"), 1);
		} else {
			$this->error("修改失败");
		}
	}

	public function about() {

		$this->display();

	}

}