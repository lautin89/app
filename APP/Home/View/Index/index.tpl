<!DOCTYPE html>
<html>
	<head>
		<title>TODO supply a title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
	<if condition="$Think.session.QC_userData neq ''">
		你好，{$Think.session.QC_USER.nickname} <img src="{$Think.session.QC_USER.figureurl_qq_1}" /> <a href="__MODULE__/Login/logout">退出</a>
	<else />
		<a href="__MODULE__/Login/login.html">登陆</a> 没有账号？<a href="Login/register.html">注册</a>
	</if>

</body>
</html>
