<include file="./header" />
<link type="text/css" rel="stylesheet" href="__PUBLIC__/Admin/css/column_index.css" />
<form method="post" action="__URL__/insertChild">
<table class='bordered'>
	<tr><th width="10%">#</th><th width="30%">名称</th><th width="10%">类别</th><th width='20%'>链接</th><th width="20%">操作</th></tr>
	<foreach name="columns" key="idx" item="tmp">
		<if condition="$tmp['parentid'] eq 0">
			<tr>
				<td>{$tmp['cid']}</td>
				<td>|<b>{$tmp['name']}</b></td>
				<td>栏目</td>
				<td><b>{$tmp['url']}</b></td>
				<td><a href='javascript:void 0;' opt='del' cid="{$tmp['cid']}">X</a> <a href='__URL__/edit/cid/{$tmp['cid']}'>编辑</a>  <a href='javascript:void 0;' name="addChild">添加菜单</a></td>
			</tr><tr class="hide">
					<td>#
						<input type="hidden" name="{$idx}[parentid]" value="{$tmp['cid']}" />
						<input type="hidden" name="{$idx}[path]" value="0,{$tmp['cid']}" />
					</td>
				<td>名称：<input type="text" name="{$idx}[name]" value="" /></td>
				<td colspan='2'>链接：<input type="text" name="{$idx}[url]" value="" /></td>
				<td><input type="submit" name="'{$idx}'" value="添加" /></td>
				</tr>
		<else />
			<tr>
				<td>{$tmp['cid']}</td>
				<td>|------{$tmp['name']}</td>
			<td>菜单</td>
			<td>{$tmp['url']}</td>
			<td><a href='javascript:void 0;' opt='del' cid="{$tmp['cid']}">X</a> <a href='__URL__/edit/cid/{$tmp['cid']}'>编辑</a></td>
			</tr>
		</if>
	</foreach>
</table>
</form>
<script src="__PUBLIC__/Admin/js/column_index.js"></script>
<include file="./footer" />