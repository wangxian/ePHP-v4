<?php
/**
 +------------------------------------------------------------------------------
 * cookie类
 * 提供写cookie，删除cookie，删除所有的cookie
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2010-3-10
 * @last_modified 2011-8-3
 +------------------------------------------------------------------------------
 */

class Cookie
{
	/**
	 * 设置cookie
	 * @param string $name cookie名称
	 * @param mixed $value
	 * @param integer $expire 有效值
	 * @param string $path cookie作用路径
	 * @param string $domain 默认为当前域名
	 */
	public static function set($name, $value, $expire=604800, $path='/', $domain='')
	{
		if(empty($domain)) $domain = '.'.$_SERVER['HTTP_HOST'];
		setcookie($name,$value,$expire + time(),$path,$domain);

		//使cookie马上生效
		$_COOKIE[$name] = $value;
	}

	/** 删除cookie */
	public static function delete($name)
	{
		$domain = '.'.$_SERVER['HTTP_HOST'];
		setcookie($name, null, time()-3600, '/', $domain);
		unset($_COOKIE[$name]);
	}

	/** 删除所有的cookies */
	public static function deleteAll() { foreach ($_COOKIE as $k=>$v) self::delete($k); }

	/**
	 * 获取cookie
	 * @param string $name
	 * @return mixed
	 */
	public static function get($name='')
	{
		if( $name == '' ) return $_COOKIE;
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
	}
}
/* End of file Cookie.class.php */
/* Location: ./ePHP/libraries/Cookie.class.php */