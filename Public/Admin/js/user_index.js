/* 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-18 13:23:16
 * @Version 1.0
 */
$(function () {
	$("table.bordered select").change(function () {
		var result = confirm("确定要修改权限？");
		if (!result) {
			location.reload();
			return;
		} 
		$.ajax({
			type : "get",
			url : "setAuthGroupAccess/group_id/" + $(this).val() + "/uid/" + $(this).attr("uid"),
			data : null,
			dataType : "json",
			success : function (result) {
				alert(result.info);
				if (result.status == 0)		location.reload();
			}
		});
	});
	
	$("a[uid]").click(function () {
		var result = confirm("确定删除该用户？");
		if (result) {
			location.href = "delete/uid/" + $(this).attr("uid");
		}
	})
	
	//给输入框绑定鼠标获取焦点事件
	$("input[name='keyword']").focus(function () {
		if ($(this).val() == "请输入用户名或昵称") {
			$(this).css("color", "#333");
		}
	})
	
	//给输入框绑定键盘事件
	$("input[name='keyword']").keydown(function () {
		if ($(this).val() == "请输入用户名或昵称") {
			$(this).val("");
		}
	})
})

