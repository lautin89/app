<?php 
//引入wBox文件-->
require_once "./wBox.html";
require_once "./info.html";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>demo测试版</title>
<style>
body{font-family:仿宋;font-size:14px;}
</style>


<script>

//设置wBox参数
var wBox_set_obj={
	title:" 采购表单",
	target:"#info"
 };
var wBox=wBox_init(wBox_set_obj);
 


</script>

<input type="button" id="wbox1" value=" 显示box " onclick="wBox.showBox();"/>


