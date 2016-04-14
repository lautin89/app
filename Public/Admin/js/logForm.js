$("input:button").mouseover(function () {
	//获取验证信息
	var uname = $("input[name='uname']").val();
	var password = $("input[name='password']").val();
	var code = $("input[name='code']").val();
	var msg = "";
	if (uname.match(/^\s*$/)) {
		msg += "<p>登陆账号未填写</p>";
	}
	if (password.length < 6 || password.length > 15) {
		msg += "<p>密码长度应为6-15位</p>";
	}
	if (code.match(/^\s*$/)) {
		msg += "<p>验证码不能为空</p>";
	}
	//验证不通过  绑定wbox输出提示信息
	if (msg != "") {
		$(this).wBox({
			title: "登陆提示",
			html: "<div class='tips'>" + msg + "</div>",
		})
	} else {
		$(this).click(function () {
			//提交表单
			document.login.submit();
		});
	}
})

