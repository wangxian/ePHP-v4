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
class indexController extends controller
{
	function __construct()
	{
		Session::init();
	}

	function indexAction()
	{
		$this->view->render();
		highlight_file(__FILE__);
	}

	function imgVerifyCodeAction()
	{
		/**
		  * 验证码
		  * 图片尺寸,50x24
		  *
		  * @param integer $length :验证码长度
		  * @param integer $mode  : 0大小写字母，1数字，2大写字母，3小写字母,5大小写+数字
		  * @param string $type :图片类型
		  * @param boolean $hasborder :图片边框有否
		  * @return binary
		  */
		Image::imgVerify(4,3,'png',true);
	}
}

/* End of file indexController.php */
/* Location: indexController.php */