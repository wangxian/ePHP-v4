<?php
/**
 +------------------------------------------------------------------------------
 * 首页
 +------------------------------------------------------------------------------
 * @Version 4.0
 * @Author  WangXian
 * @FileName indexController.php
 * @Creation date 2010-3-10
 * @Modified date 2014-06-29 16:33:48
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

    function infoAction()
    {
        echo "/index/info";
    }

}
