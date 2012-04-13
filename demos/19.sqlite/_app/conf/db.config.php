<?php
/**
 +------------------------------------------------------------------------------
 * 数据库配置
 +------------------------------------------------------------------------------
 * @version   1.9
 * @author    WangXian
 * @filename db.config.php
 * @creation date 2010-7-12 11:19:22
 * @modified date 2010-10-13 16:13:41
 +------------------------------------------------------------------------------
 */
return array
(
	/* 缺省配置default */
	'default'=>
	 array
	 (
		'host'		=> APP_PATH.'/data/db.sqlite2',	#服务器地址
		'user'		=> '',	#数据库用户名
		'password'	=> '',	#密码
		'dbname'	=> '',	#数据库
	 	'tb_prefix'	=> ''	#表前缀。只有在使用链式操作时有用
	 ),

	/* 主数据库master */
	'master'=>
	 array
	 (
		'host'		=> 'localhost',
		'user'		=> 'root',
		'password'	=> '',
		'dbname'	=> '',
		//'tb_prefix'	=> 't_'		#表前缀
	 ),

	/* 从数据库salve */
	'slave'=>
	 array
	 (
		'host'		=> 'localhost',
		'user'		=> 'root',
		'password'	=> '',
		'dbname'	=> '',
	 	'tb_prefix'	=> 't_'			#表前缀
	 )
);

/* End of file db.config.php */
/* Location: db.config.php */