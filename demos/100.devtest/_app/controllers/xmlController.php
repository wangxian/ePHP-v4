<?php
/**
 * 测试xml
 */
class xmlController
{
	/**
	 * 一维xml
	 */
	function indexAction()
	{
		$data = array( 'userinfo'=> array('name'=>'wx','id'=>12) );
		echo Xml::toXml($data);
	}

	/**
	 * 复杂测试，多维数组
	 */
	function test2Action()
	{
		$data = array(
			'filmlists'=>array(
				array('film_id'=>10248,'film_name'=>'《施密特将军》', 'director'=>array('name'=>'borhish moon', 'birthday'=>'1978-09-22')),
				array('file_id'=>20123,'film_name'=>'《法雷伯特7》',  'director'=>array('name'=>'john list',    'birthday'=>'1845-05-11')),
			),
		);
		echo Xml::toXml($data);
	}

	function toArrayAction()
	{
		//dumpdie(simplexml_load_file('http://svn.local/ePHP/demos/100.devtest/index.php/xml/test2'));
		dump(Xml::toArray( 'http://svn.local/ePHP/demos/100.devtest/index.php/xml/index', true ));
	}

}