<style>
	form {
		font:14px/30px Arial,宋体,微软雅黑;
	}
</style>
<form action="__URL__/update" method="post">
	<input type="hidden" name="id" value="{$auth_rec['id']}" />
	<p>权限名称：<input type="text" name="name" value="{$auth_rec['name']}" /> (如：Post/index)</p>
	<p>权限标题：<input type="text" name="title" value="{$auth_rec['title']}" /> (如：查看日志)</p>
	<p>状态：<input type="radio" name="status" value="1" <if condition="$auth_rec['status'] eq 1">checked</if> /> 有效、禁用<input type="radio" name="status" value="0" <if condition="$auth_rec['status'] eq 0">checked</if> /></p>
	<input type="submit" value="提交" />
<form>
