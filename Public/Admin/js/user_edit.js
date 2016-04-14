/* 
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-30 11:48:11
 * @Version 1.0
 */
$(function () {
	$("#avartar").uploadify({
		//Flash样式
		swf: '/Public/plugins/uploadify/uploadify.swf',
		//按钮显示样式
		buttonText : "选择文件",
		buttonImage : '/Public/plugins/uploadify/ImgBtn.png',
		width:50,
		height:23,
		//上传队列
		queueID : "queue",
		//上传限制
		fileTypeDesc: "选择图片",
		fileTypeExts:"*.jpg;*.jpeg;*.png;*.gif",
		fileSizeLimit:1*1024*1024,
		//表单和数据设置
		formData : {
			time : document.fm.timestamp.value,
			token : document.fm.token.value
		},
		uploader : "/Admin/upload/avartar2/rand/" + Math.random(),
		//上传完成时的执行动作
		onUploadSuccess: function () {
			alert(1);
		}
	});
})

