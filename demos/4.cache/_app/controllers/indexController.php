<?php
/**
 +------------------------------------------------------------------------------
 * index
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<wo@wangxian.me>
 * @creation date 2011-07-31 02:04:00
 * @last modified 2011-07-31 02:04:05
 +------------------------------------------------------------------------------
 */
class indexController
{

	function indexAction()
	{
		echo '<a href="'. U('index/test') .'" style="font-size:18px;color:red;">测试一下</a>';
		echo '<h1>源代码</h1><hr />';
		highlight_file(__FILE__);
	}

	public function testAction()
	{
		// 默认采用文件缓存，支持memcache缓存，SAEMC 请在main.config.php中配置。
		//'cache_type'		=> 'FileCache', #可选,FileCache | MemCache 分别为文件缓存、MemCache缓存、SAEMC(新浪SAE Memcache)

/**
如果选择了，memcache缓存驱动，则需要在APP_PATH.'/conf/memcache.config.php'中配置memcache server信息。
配置格式如：
_app/conf/memcache.config.php
<?php
return array(
	array('host'=>'192.168.0.102','port'=>11211,'weight'=>3),
	array('host'=>'192.168.0.103','port'=>11211,'weight'=>3),
	array('host'=>'192.168.0.106','port'=>11211,'weight'=>4),
);
?>
如果选择了SAEMC，不用定义memcache.config.php

*/

		$cache = Cache::init();

		//set/get缓存,第一种方式,默认长久有效
		dump( $cache->set('info', array(1,2,3),10));
		dump( $cache->get('info') );

		//set/get缓存,第二种方式,默认长久有效
		$cache->name = 'My name is wx.';
		echo $cache->name;

		//删除一条缓存
		//dump($cache->delete('info'));

		//刷新缓存区，清空所有缓存。
		//Cache::init()->flush();exit;



	}

}