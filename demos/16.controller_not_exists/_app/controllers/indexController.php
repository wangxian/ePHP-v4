<?php
 /**
 +------------------------------------------------------------------------------
 * 测试类名写错的情况下的异常捕获
 +------------------------------------------------------------------------------
 * @Version  2.2
 * @Author   WangXian
 * @E-mail    admin@loopx.cn
 * @FileName  indexController.php
 * @Creation  date 2010-11-16 上午11:50:55
 * @Modified  date 2010-11-16 上午11:50:55
 +------------------------------------------------------------------------------
 */

class indexController extends controller
{
	public function indexAction()
	{
		$view = new View();
		$view->render();
	}
	
	function errorAction()
	{
		$this->show_success();
	}
	
	function sucessAction()
	{
		$this->show_error('error!');
	}
	
	
//	/**
//	 * 操作失败
//	 * @param string  $message 错误消息
//	 * @param string  $url 自动回跳的url
//	 * @param integer $wait 自动回跳等待时间，默认6s
//	 */
//	function show_error($message, $url='', $wait=6)
//	{
//		#header('HTTP/1.1 500 Internal Server Error');
//		if( $url == '' && !empty($_SERVER['HTTP_REFERER']) ) $url = $_SERVER['HTTP_REFERER'];
//
//		include APP_PATH.'/views/public/error.tpl.html';
//		exit;
//	}
//
//	/**
//	 * 操作成功
//	 * @param string  $message 提示信息
//	 * @param string  $url     自动回跳的url
//	 * @param integer $wait    自动回跳等待时间，默认6s
//	 */
//	function show_success($message, $url='', $wait=6)
//	{
//		if( $url == '' && !empty($_SERVER['HTTP_REFERER']) ) $url = $_SERVER['HTTP_REFERER'];
//
//		include APP_PATH.'/views/public/success.tpl.html';
//		exit;
//	}
}
