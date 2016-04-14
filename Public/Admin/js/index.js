/* 
 * Copyright(c)2016 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-17 23:04:39
 * @Version 1.0
 */
/**
 * 使用uploadify文件上传
 * 取消按钮图片 路径设置不正确 某些版本中可以设置cancelImg属性设置 某些版本直接去CSS中修改样式
 * 选择按钮图片 buttonImg改为buttonImage属性 具体样式可以在CSS中设置
 */
$(function () {
	$("input#avartar").uploadify({
		//指定swf动态显示文件
		swf: '/Public/plugins/uploadify/uploadify.swf',
		//上传按钮样式
		buttonText: "点击上传", //图片显示按钮
		buttonImage:'/Public/plugins/uploadify/ImgBtn.png', //按钮图片
		width: 50, //按钮宽度
		height: 23, //按钮高度
		//显示队列
		queueID:"queue",
		//上传文件要求
		fileTypeDesc: '选择图片',
		fileTypeExts: '*.png;*.jpg;*.jpeg;*.gif;*.bmp',
		fileSizeLimit: 1 * 1024 * 1024,
		//表单携带参数
		formData: {
			'timestamp': document.fm.timestamp.value,
			'token': document.fm.token.value,
			'uid': document.fm.uid.value,
		},
		//提交时的处理
		uploader: '/Admin/Upload/avartar/rand/' + Math.random() + ".html", //提交地址
		//上传成功的处理
		onUploadSuccess: function (file, txt, response) {
			//返回提示信息
			var data = eval("(" + txt + ")");
			if (!data.status) {
				alert(data.info);
				return;
			}
			//替换当前图片
			$("img[avartar]").attr("src", "/Public/" + data.info);
		},
	});
});