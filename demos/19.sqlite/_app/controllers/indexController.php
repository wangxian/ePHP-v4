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
	public function indexAction()
	{
		echo '<h1>控制器文件</h1><hr />';
		highlight_file(__FILE__);

		echo '<h1>配置文件</h1><hr />';
		highlight_file(APP_PATH.'/conf/db.config.php');
	}

	public function testAction()
	{
		//sqlite的使用方法和mysql是一样的，设置好db.config.php就ok

		//查询
		dump( $this->model->table('test')->limit(1,3)->orderby('id asc')->cache(10)->findPage() );
		//dump( $this->model->table('test')->findObjs() );
		echo $this->model->getLastSql();

		#update
		$data['name'] = 'wx1111'.time();
		$r = $this->model->set($data)->table('test')->where('id=25')->update();
//		dumpdie($r);

		#create
		$data['name'] = time();
		$this->model->set($data, array('name'))->table('test')->insert();

		$ret = $this->model->where('id<35')->table('test')->limit(3)->findObjs();
		dump($ret);
		echo $this->model->getLastSql();
	}

}
/* End of file indexController.php */
/* Location: ./_app/controllers/indexController.php */