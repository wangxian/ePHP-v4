<?php
/**
 * ------------------------------------------------------------------------------
 * test 控制器
 * ------------------------------------------------------------------------------
 * @version 3.0
 * @author  WangXian
 * @creation date 2010-8-12
 * @Modified date 2010-12-30
 * ------------------------------------------------------------------------------
 */

class dbController extends controller
{
	function __construct()
	{

	}

	/** 测试跨model的mysql资源语柄共享 */
	public function db1Action()
	{
		//C('dbdriver','main','mysql');
		$t1 = new t1Model();
		dump($t1->getOne());

		$t2 = new t2Model();
		dump($t2->getOne());
	}
	
	public function insertAction()
	{
		$t1 = new t1Model();
		dump($t1->add_data('WangXian！@#￥%……&*\'";.,/\''));
		echo $t1->getLastSql();
	}
	
	public function db2Action()
	{
		$this->model_t1->getOne();
		$this->model_t1->getOne();
	}
}

/* End of file dbController.php */
/* Location: ./_app/controllers/dbController.php */