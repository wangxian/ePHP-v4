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
	function indexAction()
	{
		echo '<h1>数据库操作演示</h1>';
		highlight_file(APP_PATH.'/models/testModel.php');

		echo '<h1>控制器演示：</h1>';
		highlight_file(__FILE__);
	}

	function addAction()
	{
		//如果控制器继承了controller那么下面2种写法是相同的,但是还是推荐用new的，为什么呢，如果是new的话，zend studio等ide会有代码提示的哦。
		$test = new testModel();
		//$test = $this->model_test;

		dump($test->add_user());
		run_info();
	}

	function testAction()
	{
		$test = new testModel;

		//测试having
		dump($test->test_having());

		//测试leftjoin rightjoin
//		dump($test->table('t_test a')->leftjoin('t_notebook b on a.id=b.id')->limit(2)->find());
//		dump($test->table('t_test a')->dbconfig('master')->rightjoin('t_notebook b on a.id=b.id')->limit(1)->count());
//		dump($test->query("show table status like 't_test'")->findAll());
//		echo $test->getLastSql();

//		测试事务
//		dump($test->trans_test());

		//测试约束条件 重复
//		$test->test_duplicate();

		//测试数据缓存
		$test->test_cache();

		run_info();
	}

	/**
	 * 测试 自动 自从数据库支持
	 */
	public function MSAction()
	{
		//模型继承 modelMS类, 其他的操作和model方法完全一致。
		//如果仔细，你会发现，modelMS 继承至 model 类
		//MS 是 master slave的简写
		$m = new msModel();
		$m->test1();
	}

	/**
	 * 测试M() QM() 快速实例化模型
	 */
	public function MQMAction()
	{
		dump( QM('test')->find() );
		dump( QM('notebook')->limit(2)->findAll() );

		//已连接的数据库
		dump( $GLOBALS['ePHP'] );
	}

	public function getByAction()
	{
		$test = new testModel;
		$test->test_getBy();
	}
}

/* End of file indexController.php */
/* Location: ./_app/controllers/indexController.php */