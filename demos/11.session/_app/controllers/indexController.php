<?php
/**
 +------------------------------------------------------------------------------
 * index
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<wo#wangxian.me>
 * @creation date 2011-07-31 02:04:00
 * @last modified 2011-07-31 02:04:05
 +------------------------------------------------------------------------------
 */
class indexController
{
	/** 测试session。 **/
	public function indexAction()
	{
		Session::init();//初始化
		Session::set('userinfo', array('name'=>'WangXian','age'=>22) );
		dump(Session::get());
		dump(Session::get('userinfo.age'));
		highlight_file(__FILE__);
	}

	/** 测试cookie。 **/
	public function cookieAction()
	{
		Cookie::set('yourname','王见');
		dump(Cookie::get());
	}
}

/* End of file indexController.php */
/* Location: indexController.php */