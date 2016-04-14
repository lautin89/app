<!DOCTYPE html>
<!--
Copyright(c)2015 All rights reserved.
@Licenced  http://www.w3.org
@Author  LiuTian<1538731090@qq.com> liutian_jiayi
@Create on 2016-4-3 2:40:05
@Version 1.0
-->
<html>
	<head>
		<title>用户登陆</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<a href="{:U('Index/index')}">首页</a>
		<form name="login" method="post" action="">
			<p>账号：<input type="text" name="login" value="请输入邮箱或手机号" /></p>
			<p>密码：<input type="password" name="password" value="" /></p>
			<p><input type="submit" value="登陆" /> <a href="__URL__/QCLogin"><img src="__PUBLIC__/Home/images/bt_white_76X24.png" align="top" border="0" /></a> </p> 
			没有账号?<a href="__URL__/register">注册</a>
		</form>
	</body>
</html>
