<?php
/**
 +------------------------------------------------------------------------------
 * 首页
 +------------------------------------------------------------------------------
 * @Version 3.3
 * @Author  ${$auth}
 * @FileName indexController.php
 * @Creation date ${datetime}
 * @Modified date ${datetime}
 +------------------------------------------------------------------------------
 */
class indexController extends controller
{
	public function indexAction()
	{
		$this->view->render();
		run_info();
	}
}