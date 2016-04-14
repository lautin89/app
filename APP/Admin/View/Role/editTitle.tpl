<!DOCTYPE html>
<!--
Copyright(c)2015 All rights reserved.
@Licenced  http://www.w3.org
@Author  LiuTian<1538731090@qq.com> liutian_jiayi
@Create on 2016-3-20 19:34:05
@Version 1.0
-->
<html>
	<head>
		<title>TODO supply a title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			body {
				font:14px/30px Arial,宋体,微软雅黑;
			}
		</style>
	</head>
	<body>
		<form method="post" action="__URL__/updateTitle" name="updT">
			<input type="hidden" name="groupid" value="{$group['id']}" />
			<p>原有分组名：<strong>{$group['title']}</strong></p>
			<p>新的分组名：<input type="text" name="title" value="" /> </p>
			<p align='right'><input type="submit" name="todo" value="确定" /> </p>
		</form>
	<literal>
		<script>
			document.updT.onsubmit = function () {
				var groupid = this.groupid.value;
				var title = this.title.value;
				if (title.match(/^\s*$/) != null) {
					alert("标题不能为空");
					return false;
				}
				return true;
			}
		</script>
	</literal>
	</body>
</html>
