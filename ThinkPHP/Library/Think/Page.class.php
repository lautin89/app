<?php
/**
 * Page分页 页码显示类
 */
namespace Think;
class Page {
	public $numRows; //总记录数
	public $size; //每页总记录数
	public $maxp; //最大页
	public $varp; //跳转参数
	public $nowPage; //当前页
	public $param; //携带参数
	public $confOpt = array(
		"FIRST" => "首页",
		"PREV" => "上一页",
		"NEXT" => "下一页",
		"LAST" => "末页"
	);

	//初始化分页配置信息
	public function __construct($numRows, $size, $param = NULL, $varp = "p") {
		$this->numRows = $numRows;
		$this->size = $size;
		//计算最大页
		$this->maxp = ceil($numRows / $size);
		$this->varp = $varp;
		//计算当前页
		$this->nowPage = isset($_GET[$this->varp]) ? intval($_GET[$this->varp]) : 1;
		//设置携带参数
		$this->param = !empty($param) ? $param . "&" : "";
	}

	//输出页码栏的方法
	public function show() {
		//设置分页显示的模板
		$theme = ":HEADER :FIRST :PREV :PAGES :NEXT :LAST";
		//分别获取各部分的值
		$default = array(
			"HEADER" => "共" . $this->numRows . "条记录 {$this->maxp}页 当前第" . $this->nowPage . "页",
			"FIRST" => $this->urlCombine("FIRST"),
			"PREV" => $this->urlCombine("PREV"),
			"PAGES" => $this->PL(),
			"NEXT" => $this->urlCombine("NEXT"),
			"LAST" => $this->urlCombine("LAST")
		);
		//替换模板中的值
		return str_replace(array(":HEADER", ":FIRST", ":PREV", ":PAGES", ":NEXT", ":LAST"), $default, $theme);
	}

	public function setConf($name, $value = NULL) {
		if (is_array($name)) {
			foreach ($name as $item => $val) {
				$this->setConf($item, $val);
			}
		} else {
			$this->confOpt[$name] = $value;
		}
	}

	/**
	 * <a href='{$url}'>{text}</a>
	 * @param type $opt
	 */
	public function urlCombine($opt) {
		switch ($opt) {
			case "FIRST" :
				$text = $this->confOpt["FIRST"];
				$url = "?{$this->param}{$this->varp}=1";
				break;
			case "PREV" :
				$text = $this->confOpt["PREV"];
				$url = "?{$this->param}{$this->varp}=" . $this->setPage($this->nowPage - 1);
				break;
			case "NEXT" :
				$text = $this->confOpt["NEXT"];
				$url = "?{$this->param}{$this->varp}=" . $this->setPage($this->nowPage + 1);
				break;
			case "LAST" :
				$text = $this->confOpt["LAST"];
				$url = "?{$this->param}{$this->varp}=" . $this->maxp;
				break;
		}
		//组装跳转连接
		return "<a href='{$url}'>{$text}</a>";
	}

	//验证页码的方法
	public function setPage($pid) {
		$pid < 1 && $pid = 1;
		$pid > $this->maxp && $pid = $this->maxp;
		return $pid;
	}

	//生成页码列表的方法
	public function PL() {
		$pages = ""; //存放结果的
		foreach (range(1, $this->maxp) as $page) {
			$pages.= " <a href='?{$this->param}{$this->varp}={$page}'>{$page}</a> ";
		}
		return $pages;
	}

}
