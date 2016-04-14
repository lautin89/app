<include file='./header' />
<script src='__PUBLIC__/plugins/uploadify/jquery.uploadify.min.js'></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/plugins/uploadify/uploadify.css">
<p><span class="back"></span><a href="__URL__/index">上级</a></p>
<hr />
<form method='post' action='__URL__/Update' class="addEdit fl" style='width:50%;border:1px solid red;'>
	<input type="hidden" name="uid" value="{$user_rec['uid']}" />
	<p>账号：<input type='text' name='uname' value='{$user_rec["uname"]}' disabled /></p>
	<p>昵称：<input type='text' name='nickname' value='{$user_rec["nickname"]}' /></p>
	<p>密码：<input type='password' name='password' value='' /></p>
	<p>确认：<input type='password' name='repassword' value='' /></p>
	<p>角色：<select name="group_id"><foreach name="auth_group_list" key="key" item="tmp">
				<if condition="$user_rec['AuthGroupAccess']['group_id'] eq $tmp['id']">
					<option value="{$tmp['id']}" selected>{$tmp['title']}</option>
					<else />
					<option value="{$tmp['id']}">{$tmp['title']}</option>
				</if>

			</foreach></select></p>
	<p>上次登陆：<input type='text' name='logined' value='{$user_rec["logined"]}'disabled /></p>
	<p>本次登陆：<input type='text' name='login' value='{$user_rec["createtime"]}' disabled /></p>
	<p>登陆次数：<input type='text' name='times' value='{$user_rec["times"]}' disabled /></p>
	<input type="submit" value="修改" />
</form>
<form class='fl' name='fm' style='width:40%;border:1px solid red;'>
	<img src='__PUBLIC__/{$user_rec['avartar']}' width='200' avartar='1' />
	<p><input type='file' id='avartar' /></p>
	<p><input type='hidden' name='timestamp' value='{$timestamp}' /></p>
	<p><input type='hidden' name='token' value='{$token}' /></p>
	<div id="queue"></div>
</form>
<script src='__PUBLIC__/Admin/js/user_edit.js'></script>
<include file='./footer' />