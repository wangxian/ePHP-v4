<?php
/**
 +------------------------------------------------------------------------------
 * 应用程序，主配置
 +------------------------------------------------------------------------------
 * @Version   1.2
 * @Author    WangXian
 * @E-mail     wo#wangxian.me
 * @package  framework
 * @FileName main.config.php
 * @Creation date 2010-10-12
 * @Modified date 2011-6-3 15:39:18
 +------------------------------------------------------------------------------
 */

return array
(
	'debug'				=> false,	#调试模式，默认开启

	/* 打印log相关配置 */
	'access_log' 		=> false,	#是否记录access_log日志
	'exception_log'		=> false,	#是否记录EXCEPTION日志
	'sql_log' 			=> false,	#是否记录SQL日志

	/* 系统相关配置  */
	'show_errors'		=> true,		#是否显示系统错误信息，true显示，false不显示。
	'dbdriver'			=> 'mysqli',	#选择db驱动，mysql|mysqli|sqlite 默认mysqli
	'cache_type'        => 'FileCache',	#可选,FileCache 文件缓存| MemCache MemCache缓存
										#SAEMC(新浪SAE Memcache)


	/* URL相关 */
	'html_url_suffix'	=> '.html',	 	#伪静态后缀设置
	'url_router' 		=> false,	 	#是否启用url路由功能
	'url_type'			=> 'PATH_INFO',	#url类型PATH_INFO|GET|SEO(无index.php)|NODIR(如book-read.html)；

	/* 其他配置。 */
	'assets_dir'		=> '',			#资源存放的目录，如/assets，最后不带 ‘/’

//	'tpl_switch'		=> '',					#模板切换

//	'tpl_success'		=> 'success.tpl.php',	#自定义show_success的模板,位于{APP_PATH}/views/public/,下同
//	'tpl_error'			=> 'error.tpl.php',
//	'tpl_404'			=> '404.tpl.php',
//	'tpl_exception'		=> 'exception.tpl.php'

);


/* End of file ./conf/main.config.php */
/* Location: main.config.php */