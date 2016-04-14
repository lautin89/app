<include file='./header' />
<span class="back"></span><a href='__URL__/index'>返回</a>
<hr />
<form name='addGroup' method="post" action='__URL__/insert' class="addEdit">
	<p>标题：<input type='text' name='title' value='' /></p>
	<p>权限： 
		<table border="1">
			<foreach name="rule_list" key="key" item="tmp">
				<if condition='$key % 5 == 0'><tr></if>
				<td><input type="checkbox" name="rules[]" value="{$tmp['id']}" /> {$tmp['title']}</td>
				<if condition='$key % 5 == 4'></tr></if>
			</foreach>
		</table>
	</p>
	<p>
		<input type='submit' value='提交' />
	</p>
</form>
<include file='./footer' />