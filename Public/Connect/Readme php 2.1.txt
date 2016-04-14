====================QQ登录SDK FOR PHP使用说明====================

====================注意事项========================
使用本SDK时，请保证您的服务器的short_open_tag 配置为on。

====================当前版本信息====================
当前版本：V2.1

发布日期：2013-12-26

文件大小：104 K 

版本支持：支持PHP 5及以上版本。


====================修改历史====================
V2.1 更新了以下内容
     1.提示开发者配置完成后删除intall目录
      
V2.0  更新了以下内容：
      1.重新架构、组织SDK
      2.封装url API调用，更易于开发者使用
      3.完善example示例接口

QQ Connect SDK For PHP 2.0 文档
升级说明
重新架构代码
封装url API调用，更易于开发者使用
完善example示例接口
使用说明
上传服务器，设置配置项
执行install/文件夹下的index.php设置配置项
引入文件
将API文件夹拷贝到您要使用的目录，在使用的文件中引入qqConnectAPI.php即可。如下
oauth.php
<?php
require_once("../API/qqConnectAPI.php");
?>
注意：由于API需要用到session，请确保session可以使用，并且，API会执行session_start();确保页面session_start()没有执行，并且qqConnectAPI.php引用在header输出之前
调用接口
调用接口前，请先定义一个QC实例，如下
<?php
require_once("../API/qqConnectAPI.php");
$qc = new QC();
$qc->qq_login();
?>
注意：
获得access_token，在callback页面中使用$qc->qq_callback()返回access_token,
$qc->get_openid()返回openid，之后可以将access_token和openid保存（三个月有效期），
之后调用接口时不需要重新授权，但需要将access_token和Openid传入QC的参数中，如下：
$qc = new QC($access_token, $openid);

接口说明
接口命名与官网url接口命名一致，所有接口为QC实例的方法，请实例对象后调用方法。
接口参数与官网对应API参数命名保持一致，请参考官网API参数命名
接口参数接受带键名数组传递，接口会过滤冗余参数
为了更宜于开发，请保持form表单相应的input与参数名一致，这样，只需提交$_POST数组即可
如下代码
调用官网add_topic接口



====================联系我们====================
QQ登录官网：http://connect.qq.com/
开发者在使用过程中有任何意见和建议，请发邮件至connect@qq.com 进行反馈。
此外，你也可以通过企业QQ（号码：800030681。直接在QQ的“查找联系人”中输入号码即可开始对话）咨询。

