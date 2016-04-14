<include file='./header' />
<link type="text/css" rel="stylesheet" href="__PUBLIC__/Admin/css/user_add.css" />
<span class="back"></span><a href="__URL__/index">返回</a>
<hr />
<form method='post' action='__URL__/insert' class="addEdit" enctype="multipart/form-data">
	<p>账号：<input type='text' name='uname' value=''/></p>
	<p><span></span>昵称：<input type='text' name='nickname' value='' /></p>
	<p><span></span>密码：<input type='password' name='password' value='' />(*6-15位长度*)</p>
	<p><span></span>确认：<input type='password' name='repassword' value='' />(*和密码一致*)</p>
	<p><span></span>角色：<select name="group_id">
			<option value="">-请选择-</option>
			<foreach name="auth_group_list" key="key" item="tmp">
				<option value="{$tmp['id']}">{$tmp['title']}</option>
			</foreach>
		</select></p>
	<input type="submit" value="添加" />
</form>
<include file='./footer' />