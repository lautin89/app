<?php

return array(
//后台模块的配置
//M层的配置
	'DB_TYPE' => 'mysqli', // 数据库类型
	'DB_HOST' => '127.0.0.1', // 服务器地址
	'DB_NAME' => 'a0606200735', // 数据库名
	'DB_USER' => 'a0606200735', // 用户名
	'DB_PWD' => 'lt510751', // 密码
	'DB_PREFIX' => 'think_wechat_', // 数据库表前缀
//视图层配置
	'TMPL_ENGINE_TYPE' => 'Think', // 默认模板引擎 以下设置仅对使用Think模板引擎有效
	'TMPL_TEMPLATE_SUFFIX' => '.tpl', // 默认模板文件后缀
	'TMPL_CACHE_ON' => FALSE, // 是否开启模板编译缓存,设为false则每次都会重新编译
	'TMPL_L_DELIM' => '{', // 模板引擎普通标签开始标记
	'TMPL_R_DELIM' => '}', // 模板引擎普通标签结束标记
//控制层配置
	'DEFAULT_M_LAYER' => 'Model', // 默认的模型层名称
	'DEFAULT_C_LAYER' => 'Controller', // 默认的控制器层名称
	'DEFAULT_V_LAYER' => 'View', // 默认的视图层名称
	'DEFAULT_MODULE' => 'Home', // 默认模块
	'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
	'DEFAULT_ACTION' => 'index', // 默认操作名称
//系统配置
	'URL_CASE_INSENSITIVE' => true, // 默认false 表示URL区分大小写 true则表示不区分大小写
	'URL_MODEL' => 2, // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
	'URL_HTML_SUFFIX' => 'html', // URL伪静态后缀设置
//配置分页显示条数
	'PER_PAGE' => 15,
	//'配置项'=>'配置值'
	"WECHAT" => array(
		"TOKEN" => "h2o", //当前密钥
		"APPID" => "wx9b8c26a1321b7443", //应用ID
		"APPSECRET" => "390bf123c9b03a248287b3972389ad67", //应用密钥
		"EncodingAESKey" => "y3TnlLqoIAZmjmMQ3hsYut6sVUYtHPO3rO761emVN7v", //EncodingAESKey
	),
);