/* 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-21 23:37:15
 * @Version 1.0
 */
$(function () {
	$("input[value='编辑']").mouseover(function () {
		$(this).wBox({
			title : "编辑权限",
			target : "edit/id/" + $(this).attr("aid"),
			requestType:"iframe",
			iframeWH : {
				width:400,
				height:200
			}
		})
	});
})

