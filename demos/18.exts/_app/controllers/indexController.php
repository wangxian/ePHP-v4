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
class indexController
{
	function __construct()
	{
		$this->view = new view();
	}

	function indexAction()
	{
		$this->view->render();
	}

	public function testAction()
	{
		$abc = new abc();
		echo $abc->test();

		//exts 分目录测试，可以自定义类分组
		$dd = new Util_Test();
		echo $dd->boo();
	}

	/* 使用自定义helper */
	function test2Action()
	{
		//加载helper，当然，一个文件中可以写多个函数
		Loader::helper('mytest');
		mytest();
	}

}

/* End of file indexController.php */
/* Location: indexController.php */