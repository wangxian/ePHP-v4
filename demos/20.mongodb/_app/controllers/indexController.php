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
		$test = new modelMongodb;

		// 查询, 返回结果是一个记录集的游标。 用foreach，可以显示数据了。
		$data = $test->table('wx')->limit(0,20)->orderby(array('tt'=>1))->findAll();

		// 用dump不能直接打印。可用 $test->print_data() 打印。
		$test->print_data( $data );

		// 查询条件
		echo $test->getLastSql();
		echo '<hr />';


		// 查询一条
		$data = $test->table('wx')->find();
		echo $data['_id'].'<br />';
		echo $data['name'].'<br />';
		echo '<hr />';

		// 分页查询, 注意$data['data'] 也是一个记录集游标
		$data = $test->table('wx')->findPage();
		//$test->print_data($data);
		echo '<hr />';

		// 查询分组。太复杂了。
		$reduce = "function (obj, prev) { prev.items.push(obj.name); }";
		$data = $test->table('wx')->group(array('tt'=>1), array("items" => array()), $reduce);
		$test->print_data($data);
		
		echo "<br />". $test->getLastSql();
		echo '<hr />';

		// 写入
//		$ret = $test->table('wx')->set(array('name'=>'wx'.date('Hi')))->insert();
//		dump($ret);
//		echo '<hr />';

		// 删除
//		$ret = $test->table('wx')->where( array('_id'=> new MongoId('4ee866ab8decc7a41700000c')) )->delete();
//		$ret = $test->table('wx')->where( array('name'=>"wx1703") )->delete();
//		dump($ret);
//		echo '<hr />';

		// 更新所有找到的数据
//		$ret = $test->table('wx')->where( array('name'=>"wx") )
//					->set( array('$set' => array("name" =>'wangxian')) )
//					->update( array('upsert'=>true) );

		// 更新所有找到的数据
		$ret = $test->table('wx')->where( array('name'=>"wangxian") )
					->set( array('$set' => array("name" =>'wx')) )
					->update( array('multiple'=>true) );

//		dump($ret);
//		echo '<hr />';

	}
}