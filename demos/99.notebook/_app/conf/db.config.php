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
if(!defined('SAE_ACCESSKEY')):
return array
(
	'default'=>
	 array
	 (
		'host'		=> 'localhost',	#服务器地址
		'user'		=> 'root',		#数据库用户名
		'password'	=> '111111',	#密码
		'dbname'	=> 'test',		#数据库
	 	'tb_prefix'	=> 't_'			#表前缀。只有在使用链式操作时有用
	 ),

	'master'=>
	 array
	 (
		'host'		=> 'localhost',
		'user'		=> 'root',
		'password'	=> '',
		'dbname'	=> '',
		//'tb_prefix'	=> 't_'		#表前缀
	 ),


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
else:
return array
(
	/* default */
	'default'=>
	 array
	 (
		'host'			=> SAE_MYSQL_HOST_M,#服务器地址
		'user'			=> SAE_MYSQL_USER,	#数据库用户名
		'password'		=> SAE_MYSQL_PASS,	#密码
		'dbname'		=> SAE_MYSQL_DB,		#数据库
		'port'			=> SAE_MYSQL_PORT,	#数据库
	 	'tb_prefix'		=> 't_'			#表前缀。只有在使用链式操作时有用
	 ),

	/* master */
	'master'=>
	 array
	 (
		'host'			=> SAE_MYSQL_HOST_M,#服务器地址
		'user'			=> SAE_MYSQL_USER,	#数据库用户名
		'password'		=> SAE_MYSQL_PASS,	#密码
		'dbname'		=> SAE_MYSQL_DB,		#数据库
		'port'			=> SAE_MYSQL_PORT,	#数据库
	 	'tb_prefix'		=> 't_'			#表前缀。只有在使用链式操作时有用
	 ),

	/* salve */
	'slave'=>
	 array
	 (
		'host'			=> SAE_MYSQL_HOST_S,#服务器地址
		'user'			=> SAE_MYSQL_USER,	#数据库用户名
		'password'		=> SAE_MYSQL_PASS,	#密码
		'dbname'		=> SAE_MYSQL_DB,		#数据库
		'port'			=> SAE_MYSQL_PORT,	#数据库
	 	'tb_prefix'		=> 't_'			#表前缀。只有在使用链式操作时有用
	 )
);
endif;


