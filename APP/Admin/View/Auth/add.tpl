<include file='./header' />
<span class="back"></span><a href="__URL__/index">返回</a>
<hr />
<form action="__URL__/insert" method="post" class="addEdit">
	<p>权限名称：<input type="text" name="name" value="" /> (如：Post/index)</p>
	<p>权限标题：<input type="text" name="title" value="" /> (如：查看日志)</p>
	<p>状态：<input type="text" name="status" value="0" size="5" readonly /> 禁用
	<p>注：<em>初始状态未避免访问受限 只允许设为禁用 <br />
	&nbsp;&nbsp请先 获取权限 再设为有效  
		</em></p>
	</p>
	<input type="submit" value="提交" />
<form>
<include file='./footer' />
