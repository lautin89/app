<include file="./header" />
<link type="text/css" rel="stylesheet" href="__PUBLIC__/Admin/css/user_index.css" />
<form method="post" action="{$Think.server.REQUEST_URI}">
	<p><input type="text" name="keyword" value="{$keyword}"/> <input type="submit" value="查找" /></p>
</form>
<table class="bordered">
	<tr><th>#</th><th>用户名</th><th>头像</th><th>昵称</th><th>上次登陆</th><th>累计登陆</th><th>权限组</th><th>操作</th></tr>
	<foreach name="user_list" key="key" item="tmp">
		<tr>
			<td>{$tmp['uid']}</td>
			<td>{$tmp['uname']}</td>
			<td><img src='__PUBLIC__/{$tmp['avartar']}' width='30'/></td>
			<td>{$tmp['nickname']}</td>
			<td>{$tmp['logined']}</td>
			<td>{$tmp['times']} 次</td>
			<td>
				<select uid="{$tmp['uid']}">
					<foreach name="auth_group" key="key" item="item">
						<if condition="$tmp['AuthGroupAccess']['group_id'] eq $item['id']">
							<option value="{$item['id']}" selected>{$item['title']}</option>
						<else />
							<option value="{$item['id']}">{$item['title']}</option>
						</if>
					</foreach>
				</select>
			</td>
			<td><a href="__URL__/edit/uid/{$tmp['uid']}">编辑</a> <a href="javascript:void 0" uid="{$tmp['uid']}">删除</span></td>
	</tr>
	</foreach>
</table>
<p>{$page_show}</p>
<script src="__PUBLIC__/Admin/js/user_index.js"></script>
<include file="./footer" />
