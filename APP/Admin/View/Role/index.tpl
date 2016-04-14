<include file="./header" />
<link type="text/css" rel="stylesheet" href="__PUBLIC__/Admin/css/role_index.css" />
<table class="bordered">
	<tr><th width='10%'>#</th><th width='20%'>标题</th><th width='70%'>相应权限</th></tr>
	<foreach name="group_list" key="key" item="item">
		<tr>
			<td valign="top"><a href="javascript:del({$item['id']});" class="remove"></a><br />{$key + 1}</td>
			<td valign="top"> <a href="javascript:void 0;" groupid="{$item['id']}" class="edit"></a><br /><span>{$item['title']}</span> </td>
			<td>
				<foreach name="rule_list" key="idx" item="tmp">
					<in name="tmp['id']" value="$item['rules']">
						<input type="checkbox"   groupid="{$item['id']}"  value="{$tmp['id']}" checked />{$tmp['title']}
					<else />
						<input type="checkbox"    groupid="{$item['id']}"  value="{$tmp['id']}" />{$tmp['title']}
					</in>
					<if condition="$idx % 5 == 4"><br /></if>
				</foreach></td>
		</tr>
	</foreach>
</table>
<script src='__PUBLIC__/Admin/js/role_index.js'></script>
<include file="./footer" />