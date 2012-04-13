<?php
 /**
 +------------------------------------------------------------------------------
 * 自动初始化项目
 +------------------------------------------------------------------------------
 * @Version  2.3
 * @Author   WangXian
 * @E-mail    admin@loopx.cn
 * @Creation  date 2011-7-24 下午12:39:57
 * @Modified  date 2011-7-24 下午12:39:57
 +------------------------------------------------------------------------------
 */
if(!is_file(APP_PATH.'/auto_init'))
{
	mkdir(APP_PATH.'/controllers',0755,true);
	copy(dirname(__FILE__).'/indexController.php', APP_PATH.'/controllers/indexController.php');

	mkdir(APP_PATH.'/models/',0755);

	mkdir(APP_PATH.'/conf/',0755);
	copy(dirname(__FILE__).'/db.config.php',APP_PATH.'/conf/db.config.php');
	copy(dirname(__FILE__).'/main.config.php',APP_PATH.'/conf/main.config.php');

	mkdir(APP_PATH.'/runtime/cache',0777,true);
	mkdir(APP_PATH.'/runtime/logs',0777);

	mkdir(APP_PATH.'/exts/helper',0755,true);
	copy(dirname(__FILE__).'/mytest.php',APP_PATH.'/exts/helper/mytest.php');
	copy(dirname(__FILE__).'/abc.class.php',APP_PATH.'/exts/abc.class.php');


	mkdir(APP_PATH.'/views/index/',0755,true);
	copy(dirname(__FILE__).'/index.tpl.php',APP_PATH.'/views/index/index.tpl.php');

	mkdir('assets/images',0755,true);
	mkdir('assets/css',0755);
	mkdir('assets/js',0755);

	file_put_contents(APP_PATH.'/auto_init','');//创建记录文件
}