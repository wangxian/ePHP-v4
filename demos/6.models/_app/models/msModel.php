<?php
/**
 *+------------------------------------------------------------------------------
 * 测试
 *+------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	wo#wangxian.me
 * @creation_date 2011-09-22
 * @last_modified 2011-09-24
 * +------------------------------------------------------------------------------
 */

class msModel extends modelMS
{
	/**
	 * 指定表名，如果模型和表名一致，不需要哦指定。或者在查询的时候$this->table()
	 * @var string $table_name
	 */
	public $table_name = 't_test';

	function test1()
	{
//		$ret = $this->orderby('id desc')->find();
//		$this->where(array('id'=>12))->find();
//
//		$this->set( array('name'=>'测试MS') )->insert();
//		echo $this->insert_id();

//		$ret = $this->findPage();
//		$this->count();

//		$this->where( array('id'=>12) )->delete();
//		$this->set( array('name'=>'测试MS') )->where('id=22')->update();

//		$this->trans_start();
		$this->query('select * from t_test')->find();
		$this->query('delete from t_test where id=22');
//		$this->trans_rollback();

		dump($this->db->db->thread_id);
	}
}