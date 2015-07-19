<?php
/**
 +------------------------------------------------------------------------------
 * 数据库配置
 +------------------------------------------------------------------------------
 * @version   1.9
 * @author    WangXian
 * @filename db.config.php
 * @creation date 2010-7-12 11:19:22
 * @modified date 2011-07-24 13:15:06
 +------------------------------------------------------------------------------
 */
return array
(
	/* default */
	'default'=>
	 array
	 (
		'host'		=> 'localhost',	#服务器地址
		'user'		=> 'root',			#数据库用户名
		'password'	=> '111111',		#密码
		'dbname'	=> 'test',			#数据库
	 	'tb_prefix'	=> 't_'		#表前缀。只有在使用链式操作时有用
	 ),

	/* master */
	'master'=>
	 array
	 (
		'host'		=> 'localhost',
		'user'		=> 'root',
		'password'	=> '',
		'dbname'	=> '',
		//'tb_prefix'	=> 't_'		#表前缀
	 ),

	/* salve */
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