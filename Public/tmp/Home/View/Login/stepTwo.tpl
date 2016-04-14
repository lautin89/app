<!DOCTYPE html>
<!--
Copyright(c)2015 All rights reserved.
@Licenced  http://www.w3.org
@Author  LiuTian<1538731090@qq.com> liutian_jiayi
@Create on 2016-4-5 22:42:38
@Version 1.0
-->
<html>
	<head>
		<title>TODO supply a title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<h4>初次登陆，完善个人信息</h4>
		<form method="post" action="__URL__/stepTwo">
			<input type="hidden" name="mid" value="{$mid}" />
			<p>邮箱：<input type="text" name="email" value="" />（*重要，找回密码时使用*）</p>
			<p>手机：<input type="text" name="tel" value="" />（*重要，各种验证时的首选*）</p>
			<input type="submit" name="submit" value="登陆" /> <a href='__URL__/stepThree/mid/{$mid}'>下次再说</a>
		</form>
	</body>
</html>
