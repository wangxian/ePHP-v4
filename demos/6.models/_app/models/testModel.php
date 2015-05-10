<?php
/*
 * 查看如何操作SAE MySQL，http://yiguozhou.sinaapp.com/archives/ephp-sae-model-mysql.html
 */
class testModel extends model
{
	function update_name()
	{//更新数据id=6的数据
		return $this->table('t_test')->data( array('name'=>'wangxian') )->where('id=6')->update();
	}

	function add_user()
	{//添加一条记录
		$data = array('name'=>'test');
		return $this->table('t_test')->set( $data )->insert();
	}

	function get_one()
	{//从从数据库查询一条数据
		#如果表名和model名称一致，则不用指定表名。如这里的表名为‘t_test’
		return $this->dbconfig('slave')->where("id>1 and name='wangxian'")->find();
	}

	public function get_more()
	{
		return $this->table('t_test')->limit('0,1')->orderby('id desc')->findAll();
	}

	public function query_sql($sql)
	{//用query sql 返回结果
		return $this->query('select * from t_test limit 1')->find();
	}

	/** 分页测试。 **/
	public function get_pages($page=1,$count=10)
	{//以分页查询。return array('data'=>array(),'data_count'=>array());
		return $this->table('t_test')->limit(($page-1)*$count,$count)->findPage();
	}

	public function test_having()
	{
		return $this->table('t_test')->groupby('name')->having('count(name) >= 2')->findAll();
	}

	/* 测试事务 */
	public function trans_test()
	{
		$this->trans_start();
		$this->table('t_innodb')->set(array('name'=>'wx','email'=>'wx'. rand(10,10000000) .'@wx.com'))->insert();

		$success = 1;
		if($success) $this->trans_commit();//提交
		else $this->trans_rollback();//回滚

		return $this->table('t_innodb')->orderby('id desc')->limit(1)->find();
	}

	/*
	 * 测试主键约束的情况
	 */
	public function test_duplicate()
	{
		//如果主键约束，插入会失败并会抛出异常
//		echo $this->table('t_innodb')->set(array('name'=>'wx'))->insert();

		//如果指定了insert_update()的更新内容，则会更新指定的内容到数据库，否则，忽略插入。
//		echo $this->table('t_innodb')->set(array('name'=>'wx','email'=>'wo#wangxian.me'))->insert_update();
//		echo $this->table('t_innodb')->set(array('name'=>'wx','email'=>'wo#wangxian.me'))->insert_update("updated_at ='".date('Y-m-d H:i:s')."'");



		echo $this->table('t_innodb')->set(array('name'=>'wx','email'=>'wo#wangxian.me'))->insert_replace();
		dump($this->table('t_innodb')->orderby('id desc')->limit(1)->find());
	}

	/**
	 * 查询缓存测试
	 */
	public function test_cache()
	{
//		dump($this->table('t_test')->orderby('id desc')->cache(600)->limit(1)->find());
//		dump($this->table('t_test')->orderby('id desc')->cache(100)->limit(1,2)->findObjs());
//		dump($this->table('t_test')->orderby('id desc')->cache(10)->limit(1,2)->findAll());
		dump($this->table('t_test')->orderby('id desc')->cache(5)->limit(1,2)->findPage());
		echo $this->getLastSql();
	}

	public function test_getBy()
	{
		dump($this->getBy('id=30'));
	}
}