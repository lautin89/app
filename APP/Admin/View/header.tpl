<!DOCTYPE html>
<!--
Copyright(c)2015 All rights reserved.
@Licenced  http://www.w3.org
@Author  LiuTian<1538731090@qq.com> liutian_jiayi
@Create on 2016-3-16 14:23:17
@Version 1.0
-->
<html>
	<head>
		<title>LAMP兄弟连后台管理系统</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link type="text/css" rel="stylesheet" href="__PUBLIC__/Admin/css/common.css" />
		<script src="__PUBLIC__/Admin/js/jquery-1.8.3.min.js"></script>
		<link type="text/css" rel="stylesheet" href="__PUBLIC__/plugins/wbox/wbox/wbox.css" />
		<script src="__PUBLIC__/plugins/wbox/mapapi.js"></script>
		<script src="__PUBLIC__/plugins/wbox/wbox.js"></script>
	</head>
	<body>
		<div id="header" class="w100pc">
			<div class="w1000px">
				<a href="__MODULE__/Index">首页</a>
				你好，{$Think.session.userData.nickname}！<a href="__MODULE__/Login/logout">退出</a>
			</div>
		</div>
		<div id="main" class="w1000px">
			<div class="mainLeft fl">
				<ul>
					<foreach name="col_list" key="idx" item="tmp">
						<if condition="$tmp.parentid eq 0">
							<li class="menu">{$tmp['name']}</li>
						<else />
							<li class="submenu"><a href="__MODULE__/{$tmp['url']}">{$tmp['name']}</a></li>
						</if>
					</foreach>
				</ul>
			</div>
			<div class="mainRight fl">