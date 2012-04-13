<?php
/**
 +------------------------------------------------------------------------------
 * 首页
 +------------------------------------------------------------------------------
 * @Version 4.0
 * @Author  WangXian
 * @FileName indexController.php
 * @Creation date 2010-3-10
 * @Modified date 2011-07-31 00:46:38
 +------------------------------------------------------------------------------
 */
class indexController
{
	public function indexAction()
	{
		echo "<h1>Hello World!</h1><p>Welcome to ePHP.</p>";
		run_info();
		echo '<br />';
		highlight_file(__FILE__);
	}

}
