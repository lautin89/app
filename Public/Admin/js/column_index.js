/* 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-22 20:03:44
 * @Version 1.0
 */
$(function () {
	$("a[name='addChild']").click(function () {
		$(this).parent().parent().next().toggle(2000);
	});
	$("a[opt='del']").click(function () {
		var result = confirm("确认删除该条记录？这可能同步删除它的子类");
		if (result)	location.href = "delete/cid/" + $(this).attr("cid");
	});
})

