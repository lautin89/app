<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="__PUBLIC__/Admin/css/common.css" type="text/css" rel="stylesheet" />
		<link href="__PUBLIC__/Admin/css/logForm.css" type="text/css" rel="stylesheet" />
		<script src="__PUBLIC__/Admin/js/jquery-1.8.3.min.js"></script>
		<link type="text/css" rel="stylesheet" href="__PUBLIC__/plugins/wbox/wbox/wbox.css" />
		<script src="__PUBLIC__/plugins/wbox/mapapi.js"></script>
		<script src="__PUBLIC__/plugins/wbox/wbox.js"></script>
		<title>网站管理系统-CMS</title>
	</head>
	<body>
		<div class="w100pc wrap">
			<div class="w1000px main">
				<div class="area1 fl"></div>
				<div class="area2 fl"></div>
				<div class="area3 fl"> </div>
				<div class="area4 fl"> 
					<form method="post" name="login" action="__URL__/logTodo">
						<table>
							<tr>
								<td>用户名：</td>
								<td><input type="text" name="uname"  value="" size=30 /></td>
							</tr>
							<tr>
								<td>密 码：</td>
								<td><input type="password" name="password" value="" size=30 /></td>
							</tr>
							<tr>
								<td>验证码：</td>
								<td><input type="text" name="code" size=10 maxlength=5 /> <img src="__URL__/verifyCode" align="middle" onclick="this.src = this.src + '/rand/' + Math.random();" /></td>
							</tr>
							<tr>
								<td colspan=2 class="last" align="right">
									<!--									<input type="image" src="__PUBLIC__/Admin/image/Login3_07.png" />-->
									<input type="button" value=" 登 陆 " />
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		<div id="footer" class="w100pc">
			<div class="w1000px">&copy;2016 LAMP兄弟连 SH38 版权所有</div>
		</div>
		<script src="__PUBLIC__/Admin/js/logForm.js"></script>
	</body>
</html>

