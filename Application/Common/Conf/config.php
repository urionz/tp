<?php
return array(
	//'配置项'=>'配置值'
	//数据库配置信息
'DB_TYPE'   => 'mysql', // 数据库类型
'DB_HOST'   => 'localhost', // 服务器地址
'DB_NAME'   => 'xbdcms', // 数据库名
'DB_USER'   => 'root', // 用户名
'DB_PWD'    => '', // 密码
'DB_PORT'   => 3306, // 端口
'DB_PREFIX' => 'tp_', // 数据库表前缀 
'DB_CHARSET'=> 'utf8', // 字符集

'MODULE_ALLOW_LIST'     =>  array('Home'),    // 允许访问的模块列表
'DEFAULT_MODULE'        =>  'Home',  // 默认模块
'DEFAULT_CONTROLLER'    =>  'Login', // 默认控制器名称
'URL_MODEL'             =>  2,

'TMPL_FILE_DEPR'=>'_', //模板的目录层次

'TMPL_ACTION_ERROR' => 'public:message',//错误跳转对应的模版文件
'TMPL_ACTION_SUCCESS' => 'public:message',//成功跳转对应的模版文件

/***权限配置信息***/
'AUTH_ON' 			=> true,                      // 认证开关
'AUTH_TYPE'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
'AUTH_GROUP'        => 'auth_group',        // 用户组数据表名
'AUTH_GROUP_ACCESS' => 'auth_group_access', // 用户-用户组关系表
'AUTH_RULE'         => 'auth_rule',         // 权限规则表
'AUTH_USER'         => 'user',             // 用户信息表
'SHOW_PAGE_TRACE'=>true,
);
