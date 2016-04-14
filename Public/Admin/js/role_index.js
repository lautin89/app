/* 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-20 14:02:04
 * @Version 1.0
 */
$(function () {
	$("input[groupid]:checkbox").click(function () {
		$.ajax({
			type : "get",
			url : "setAuthGroup/rule/" + $(this).val() + "/id/" + $(this).attr("groupid"),
			data : null,
			dataType : "json",
			success : function (result) {
				//提示用户操作是否成功
				alert(result.info);
				//重置按钮状态为原先
				if (result.status == 0) {
					location.reload();
				}
			}
		});
	})
	
	$("a[groupid]").mouseover(function () {
		var wb  = new Array();
		var groupid = $(this).attr("groupid");
		wb[groupid] = $(this).wBox({
			title : "编辑标题信息",
			requestType : "iframe",
			iframeWH : {
				width : 300,
				height:120,
			},
			target : "editTitle/id/" + groupid,
		})
	});
})

function del(id) {
	var result = confirm("确定要删除编号为" + id + "的记录吗？\n这将同步删除该分组下的所有用户！");
	if (result) {
		location.href = "delete/id/" + id;
	}
}