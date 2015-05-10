<?php
/**
 +------------------------------------------------------------------------------
 * 应用程序，主配置
 +------------------------------------------------------------------------------
 * @Version   1.2
 * @Author    WangXian
 * @E-mail     wo@wangxian.me
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

	'tpl_switch'		=> '',					#模板切换，如果为空，不使用多视图功能
//	'tpl_success'		=> 'success.tpl.php',	#show_success()的模板文件,请把该文件放在views/public/下。
//	'tpl_error'			=> 'error.tpl.php',		#show_error()的模板
//	'tpl_404'			=> '404.tpl.php'		#show_404()的模板

);


/* End of file ./conf/main.config.php */
/* Location: main.config.php */