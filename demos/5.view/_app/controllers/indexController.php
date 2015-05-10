<?php
/**
 +------------------------------------------------------------------------------
 * index
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<wo@wangxian.me>
 * @creation date 2011-07-31 02:04:00
 * @last modified 2011-07-31 02:04:05
 +------------------------------------------------------------------------------
 */
class indexController extends controller
{
	public function indexAction()
	{
		// 在程序运行过程中，开启debug模式，C()函数参数，C('配置名称','配置文件名称','配置名称对应的值')
		C('debug','main',true);
//		print_r(Debug::dumpTrace());

		//如果继承了controller,则不用new view()了
		//$this->view = new view();

		//用对象传值
		$this->view->data = '这是对象传值！';

		#传值到view中
		$this->view->assign('data', '这里是assign传值！');

		#渲染视图
		$this->view->render('index/index.tpl.php'); //参数可以省略 或 写成$this->view->render('index/index');
		//$this->view->display(); //和render作用一样






		echo '<h1>控制器源代码：</h1><hr />';
		highlight_file('indexController.php');

		echo '<h1>视图源代码：</h1><hr />';
		highlight_file(APP_PATH.'/views/index/index.tpl.php');
	}

	function layoutAction()
	{
		$this->view->assign('name', 'wx');
		$this->view->name = 123;
		$this->view->layout();
	}

}