<?php

return array(
//***********************************附加配置**************************************
    'SHOW_PAGE_TRACE'    => true,
    'LOAD_EXT_CONFIG'    => 'db', // 加载网站设置文件
    'TAGLIB_BUILD_IN'    =>'Cx,Common\Tag\Mytag', //加载自定义标签
	'DEFAULT_MODULE'     => isMobile()?'App':'Admin', //默认模块
    'DEFAULT_CONTROLLER' => isMobile()?'Index':'Login', // 默认控制器名称
    'DEFAULT_ACTION'     => isMobile()?'index':'index', // 默认操作名称
    'DEFAULT_CHARSET'    => 'utf-8', // 默认输出编码
    'DEFAULT_TIMEZONE'   => 'PRC', // 默认时区
    'DEFAULT_FILTER'     => 'htmlspecialchars', // 默认参数过滤方法 用于I函数...
    'UPLOAD_PATH'        => './Public/Uploads/',
    'UPLOAD_PATH_ROOT'   => '/Public/Uploads/',
//***********************************表单验证设置***********************************
    'AUTH_KEY'           => '&*!^#&!@*#(@!SYNCL.A76T^&!*~@*_(!)J@KL!:JH!)SA*(HDSAHD&*(*(E^!EKJH',
    'TOKEN_ON'           => true,
    'TOKEN_NAME'         => '__hash__',
    'TOKEN_TYPE'         => 'md5',
    'TOKEN_RESET'        =>    true,
//***********************************URL设置**************************************
    'MODULE_ALLOW_LIST'  => array('Common','Admin','App','Doc','Api'),
    'URL_HTML_SUFFIX'    => '',
    'URL_MODEL'          => '2', //PATHINFO模式
    'URL_CASE_INSENSITIVE'  =>  true,  // URL区分大小写
//***********************************页面设置**************************************
    'TMPL_ACTION_ERROR'  => '../../Common/View/error',//默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'=> '../../Common/View/success',//默认成功跳转对应的模板文件
	// 'TMPL_EXCEPTION_FILE' => './404.html',
    // 'ERROR_PAGE'      => './404.html',//错误页面 
//***********************************分页设置**************************************
    'PAGE_LISTROWS'      => 15,
    'VAR_PAGE'           => 'p',
//***********************************权限设置**************************************    
    'AUTH_CONFIG'        => array(
		'AUTH_ON'        => true, //认证开关
		'AUTH_TYPE'      => 1, // 认证方式，1为时时认证；2为登录认证。
		'AUTH_GROUP'     => 'box_auth_group', //用户组数据表名
		'AUTH_GROUP_ACCESS' => 'box_auth_group_access', //用户组明细表
		'AUTH_RULE'      => 'box_auth_rule', //权限规则表
		'AUTH_USER'      => 'box_users'//用户信息表
	),
    'ADMINISTRATOR'      => array('1'), //超级管理员id,拥有全部权限
//***********************************Cookie设置************************************    
    'COOKIE_EXPIRE'      => 86400*365*2, // Cookie有效期
    'COOKIE_DOMAIN'      => '', // Cookie有效域名
    'COOKIE_PATH'        => '/', // Cookie路径
    'COOKIE_PREFIX'      => '', // Cookie前缀 避免冲突
    'COOKIE_HTTPONLY'    => 1, // Cookie httponly设置
//***********************************Session设置***********************************
    'SESSION_OPTIONS'    =>  array('expire'=>86400),
    // 'SESSION_AUTO_START'    =>  true,   // 是否自动开启Session
    // 'SESSION_TYPE'          =>  'Redis',    //session类型
    // 'SESSION_PERSISTENT'    =>  1,      //是否长连接(对于php来说0和1都一样)
    // 'SESSION_CACHE_TIME'    =>  1,      //连接超时时间(秒)
    // 'SESSION_EXPIRE'        =>  3600,      //session有效期(单位:秒) 0表示永久缓存
    // 'SESSION_PREFIX'        =>  'sess_',        //session前缀
    // 'SESSION_REDIS_HOST'    =>  '139.129.196.52', //分布式Redis,默认第一个为主服务器
    // 'SESSION_REDIS_PORT'    =>  '6379',        //端口,如果相同只填一个,用英文逗号分隔
    // 'SESSION_REDIS_AUTH'    =>  'bf663a09792143f89b361836bc828c8d',    //Redis auth认证(密钥中不能有逗号),如果相同只填一个,用英文逗号分隔
    // 'SESSION_REDIS_DB'      =>  '1',
//***********************************日志设置**************************************
    'LOG_RECORD'            =>  true,  // 进行日志记录
    'LOG_EXCEPTION_RECORD'  =>  true,    // 是否记录异常信息日志
    'LOG_LEVEL'             =>  'EMERG,ALERT,DEBUG',  // 允许记录的日志级别
    'DB_FIELDS_CACHE'       =>  false, // 字段缓存信息
    'DB_SQL_LOG'            =>  true, // 记录SQL信息
    'TMPL_CACHE_ON'         =>  false,        // 是否开启模板编译缓存,设为false则每次都会重新编译
    'TMPL_STRIP_SPACE'      =>  false,       // 是expire否去除模板文件里面的html空格与换行
    'SHOW_ERROR_MSG'        =>  true,    // 显示错误信息
//***********************************语言包设置*************************************  
    'LANG_SWITCH_ON'   => true,      // 开启语言包功能
    'LANG_AUTO_DETECT' => true,    // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'        => 'zh-cn,en-us',         // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l',          // 默认语言切换变量，注意到上面发的链接了么，l=zh-cn，就是在这里定义l这个变量
//***********************************邮件服务器*************************************
    'MAIL_FROM_EMAIL'  => 'adoceans1688@163.com',
    'MAIL_FROM_NAME'   => '管理员',
    'MAIL_HOST_ADDRESS' => 'smtp.163.com',
    'MAIL_PASSWORD'    => 'adoceans16',
    'MAIL_USERNAME'    => 'adoceans1688@163.com',
//***********************************基本信息***************************************
    'HOST_MAIN'        =>  'http://crane.u-xuan.com',//主机地址
    'SYSTEM_TITLE'     =>  '后台管理系统',
//***********************************七牛******************************************
    'QINIU_ACCESSKEY'  =>  '', //accesskey
    'QINIU_SECRETKEY'  =>  '', //secretkey
    'QINIU_SPACENAME'  =>  '',  //空间名称

	'COMPANY_TYPE'	=> array(
		'1'=>'制造公司',
		'2'=>'施工公司',
		'3'=>'租赁公司',
		'4'=>'安监站',
		'5'=>'平台',
		'6'=>'安监单位',
		'7'=>'建设单位',
		'8'=>'承建单位',
	),

	'ENGINEERING_STATUS' => array(

		'1'=>'已查看',
		'2'=>'未通过',
		'3'=>'修改后再次审核',
		'4'=>'通过',
		'5'=>'待审核'
	),

//	用户认证
	'USER_CHECK' => array(

		'0'=>'已认证',
		'1'=>'未认证',

	),

//	用户激活
	'USER_ACTIVE' => array(

		'0'=>'未激活',
		'1'=>'已激活'
	),



    'URL_ROUTER_ON' =>  true,
    'URL_ROUTE_RULES' => array( //定义路由规则 
        'static'    => 'App/Index/themeStatic'
    ),
    
    
);
