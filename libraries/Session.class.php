<?php
 /**
 +------------------------------------------------------------------------------
 * session操作封装
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @email wo#wangxian.me
 * @package  libraries
 * @creation_date 2010-12-26 下午06:03:37
 * @last_modified 2010-12-26 下午06:03:37
 +------------------------------------------------------------------------------
 */

class Session
{
	/**
	 * 设置session,如果value为null时，这删除该name的session值
	 * @param string $name
	 * @param mixed $value
	 */
	public static function set($name,$value) { $_SESSION[$name] = $value; }

	/**
	 * delete session
	 * -
	 * @param $name
	 */
	public static function delete($name) { unset($_SESSION[$name]); }

	/**
	 * delete all session
	 */
	public static function deleteAll() { if(isset($_SESSION)) $_SESSION = array();}

	/**
	 * session 初始化
	 * 如果需要url上带上sessionid，那把$use_trans_sid设为1，一般wap网站
	 * <pre>
	 * 'use_cookies' #是否使用cookies在客户端保存会话sessionid，默认为采用 1
	 * 'use_only_cookies' #是否仅仅使用cookie在客户端保存会话sessionid,
	 *                   默认 0 (0，开启url明文专递session_id。1，禁用url传session_id) wap网站一般设置为0 ；
	 * 'use_trans_sid' #session_id通过url明文传输
	 * 'name' 'mysid',	#session name
	 * </pre>
	 * @param $use_trans_sid
	 * @param $name session名称
	 */
	public static function init($use_trans_sid=0, $name='sessionid')
	{
		if( $use_trans_sid )
		{
			#如果服务器设置auto_start = 1，则先注销当前session
			if( ini_get('session.auto_start') ) session_destroy();

			ini_set('session.name', $name);
			ini_set('session.use_cookies', 1);
			ini_set('session.use_only_cookies', 0);
			ini_set('session.use_trans_sid', 1);
			if( isset($_GET[ $name ])) session_id( $_GET[ $name ] );
			session_start();
		}
		else if(! isset($_SESSION) ) session_start();
	}

	/**
	 * 获取session，如果不指定name，则返回所有的session
	 * 该方法支持二维数组。(如Session::get('user.name'));
	 * @param mixed $name
	 * @return mixed
	 */
	public static function get($name='')
	{
		if($name == '') return $_SESSION;
		else if( array_key_exists($name, $_SESSION) ) return $_SESSION[$name];
	    else if( strpos($name,'.') )
	    {
	        $array = explode('.', $name );
	        return isset($_SESSION[ $array[0] ][ $array[1] ]) ? $_SESSION[ $array[0] ][ $array[1] ] : false;
	    }
	    else return false;
	}
}
/* End of file Session.class.php */
/* Location: ./ePHP/libraries/Session.class.php */