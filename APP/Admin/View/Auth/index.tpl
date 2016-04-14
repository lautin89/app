<include file='./header' />
<form action="__URL__/opts" method="post">
	<p>
		<input type="submit" name="submit" value="选中有效" />
		<input type="submit" name="submit" value="选中禁用" />
		<input type="submit" name="submit" value="选中删除" />
	</p>
	<table class='zebra'>
		<tr>
			<th>#</th><th>操作</th><th>标题</th><th>状态</th><th>操作</th>
		</tr>
		<foreach name='auth_list' key='key' item='tmp'>
			<tr>
				<td><input type="checkbox" name="ids[]"  value="{$tmp['id']}" /> {$tmp['id']}</td>
				<td>{$tmp['name']}</td>
				<td>{$tmp['title']}</td>
				<td>
				<if condition="$tmp['status'] eq 1"> 
					有效
					<else /> 
					<font color="red">禁用</font> 
				</if>
			</td>
			<td><input type="button" aid="{$tmp['id']}" value="编辑" /></td>
			</tr>
		</foreach>
	</table>
<form>
	<script src="__PUBLIC__/Admin/js/auth_index.js"></script>
<include file='./footer' />