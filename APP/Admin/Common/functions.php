<?php

/*
 * Copyright(c)2015 All rights reserved.
 * @Licenced  http://www.w3.org
 * @Author  LiuTian<1538731090@qq.com> liutian_jiayi
 * @Create on 2016-3-21 14:55:26
 * @Version 1.0
 */
/**
 * 文件下载操作
 * @param string $src_file	要下载的文件
 */
function downloadFile($src_file) {
	//读取文件信息
	$path_info = pathinfo($src_file);
	//发送头编码 告知文件类型
	header('Content-type: application/' . $path_info["extension"]);
	//以附件形式 不直接打开
	header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gbk", $path_info["basename"]));
	//读取保存缓冲区的文件 
	readfile($src_file);
}

/*
 * 递归删除非空目录
 */
function deleteFold($dirRoot) {
	//将UTF8文件编码成GBK 用于系统验证
	$dirRoot = iconv("utf-8", "gbk", $dirRoot);
	if (!is_readable($dirRoot))		return;
	//打开目录
	$handle = opendir($dirRoot);
	//读取文件
	while ($file = readdir($handle)) {
		//过滤快捷方式等
		if ($file == "." || $file == "..")  continue ;
		//组装文件
		$full_path = $dirRoot . "/" . $file; //纯GBK
		//如果是目录 递归执行删除
		if (is_dir($full_path)) {
			deleteFold(iconv("gbk", "utf-8", $full_path));
		//如果是文件 则直接删除之
		} elseif (is_file($full_path)) {
			unlink($full_path);
		}
	}
	//关闭目录
	closedir($handle);
	//删除最外层
	rmdir($dirRoot);
}

/**
 * 发送邮件的方法
 * /////////////////////////////////////////////////////
 * //使用前请取配置文件中设置 MAIL_LOGIN等用户账号信息//
 * /////////////////////////////////////////////////////
 * @param string $to		发送对象
 * @param string $subject	邮箱主题		在提醒时候的标题文件
 * @param string $body	正文主题 
 */
function sendMail($to, $subject = "", $body = "") {
	//$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
	date_default_timezone_set("Asia/Shanghai"); //设定时区东八区
	$mail = new Org\Mail\PHPMailer(); //new一个PHPMailer对象出来
	/**
	 * smtp 服务设置
	 */
	$mail->CharSet = "UTF-8"; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP(); // 设定使用SMTP服务
	$mail->SMTPDebug = 1;   // 启用SMTP调试功能
	// 1 = errors and messages
	// 2 = messages only
	$mail->SMTPAuth = true;   // 启用 SMTP 验证功能
	$mail->SMTPSecure = "ssl";  // 安全协议
	$mail->Host = "smtp.qq.com";   // SMTP 服务器

	$mail->Port = 465;   // SMTP服务器的端口号
	$mail->Username = C("MAIL_LOGIN");  // SMTP服务器用户名
	$mail->Password = C("MAIL_PWD");   // SMTP服务器密码
//	//发送方账号 
	$mail->SetFrom(C("MAIL_LOGIN"), C("MAIL_NICKNAME"));
//	//回复接收方
	$mail->AddReplyTo(C("MAIL_LOGIN"), C("MAIL_PWD"));
	$mail->Subject = $subject;
//	$mail->AltBody = "To view the message, please use an HTML compatible email viewer! - From www.jiucool.com"; // optional, comment out and test
//	$mail->MsgHTML($body);
	$mail->isHTML(TRUE);
	$mail->Body = $body;
	$mail->WordWrap = 100;
	$address = $to;
	$mail->AddAddress($address, "收件人名称");
	//$mail->AddAttachment("images/phpmailer.gif");      // attachment 
	//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
	ob_start();
	if (!$mail->Send()) {
		$result = array("status" => FALSE, "info" => $mail->ErrorInfo);
	} else {
		$result = array("stauts" => TRUE, "info" =>  "恭喜，邮件发送成功！");
	}
	ob_get_contents();
	ob_end_clean();
	return $result;
}