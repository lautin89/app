<include file="./header" />
<span class="back"></span><a href="__URL__/index">返回</a>
<hr />
<form method="post" action="__URL__/update" class="addEdit">
	<input type='hidden' name='cid' value='{$col_rec["cid"]}' />
	<p>名称：<input type="text" name="name" value="{$col_rec['name']}" /></p>
	<p>链接：<input type="text" name="url" value="{$col_rec['url']}" /></p>
	<p>类别：<if condition="$col_rec['parentid'] eq 0">
		<input type="text" value="栏目" disabled size="5" />
		<else />
		<input type="text" value="菜单" disabled size="5" />
	</if></p>
<input type="submit" value="修改" />
</form>
<include file="./footer" />