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
	'default'=>
	 array
	 (
		'host'		=> '192.168.1.222',	#服务器地址
		'user'		=> '',
		'password'	=> '',
		'dbname'	=> 'test',
//		'port'		=> '27017' //如果是27017，可省略
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