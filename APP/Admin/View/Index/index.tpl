<include file='./header' />
<link type="text/css" rel="stylesheet" href="__PUBLIC__/Admin/css/index.css" />
<!--引入uplodify插件-->
<script src="__PUBLIC__/plugins/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/plugins/uploadify/uploadify.css">
<div class="fl">
	<img src="__PUBLIC__/{$userData.avartar}" avartar="1" width="150"/> 
</div>
<ul class="fl user">
	<li>用户账号：<span>{$userData.uname}</span></li>
	<li>显示昵称：<span>{$userData.nickname}</span> <a href="">></a></li>
	<li>最近登陆：{$userData.logined} </li>
	<li>本次登陆：{$userData.createtime}</li>
	<li>累计登陆：{$userData.times}次</li>
</ul>
<form name="fm" class="clear">
	<input type="hidden" name="timestamp"  value="{$timestamp}" />
	<input type="hidden" name="token"  value="{$token}" />
	<input type="hidden" name="uid" value="{$Think.session.userData.uid}" />
	<input type="file" id="avartar"/>
</form>
<div id="queue"></div>
<script src="__PUBLIC__/Admin/js/index.js"></script>
<include file='./footer' />