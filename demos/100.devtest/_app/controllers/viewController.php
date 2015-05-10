<?php
 /**
 +------------------------------------------------------------------------------
 * test view
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author  WangXian
 * @email	<wo@wangxian.me>
 * @creation date 2011-3-5 下午11:20:55
 * @last modified 2011-3-5 下午11:20:55
 +------------------------------------------------------------------------------
 */

class viewController extends controller
{
	public function __construct()
	{
		//多视图类
		$this->view = new MultiView;
	}

	/** view缓存演示 。*/
	public function indexAction()
	{
		$this->view->myname='WangXian';
		if(! $this->view->is_cached('view/index') )
		{
			//查询数据库、大的内容块，复杂的逻辑等进行缓存。
			$this->view->content = file_get_contents('http://www.baidu.com');
		}
		$this->view->render('view/index',0);
	}

	public function tplsAction()
	{
		//使用默认视图
//		$this->view->render();

		//使用myskin的视图
		C('tpl_switch','main','myskin');
		$this->view->render();
	}

	public function errorAction()
	{
//		show_error('测试多视图情况下的错误。');
		show_404();
	}

}
/* End of file viewController.php */
/* Location: ./_app/controllers/viewController.php */