<?php
 /**
 +------------------------------------------------------------------------------
 * title
 +------------------------------------------------------------------------------
 * @Version  3.0
 * @Author   WangXian
 * @E-mail    wo@wangxian.me
 * @FileName  indexController.php
 * @Creation  date 2010-12-6 下午04:52:16
 * @Modified  date 2010-12-6 下午04:52:16
 +------------------------------------------------------------------------------
 */
class indexController extends controller
{
	function indexAction()
	{
		$this->view->render();
		run_info();
	}

	public function readAction()
	{//getp()演示
		//测试url：/index.php/index/read/120.html
		dump(getp(1)); //index
		dump(getp(2)); //read
		dump(getp(3)); //120
	}

	public function suffixAction()
	{
		dump(getv());
	}
}



/* End of file indexController.php */
/* Location: indexController.php */