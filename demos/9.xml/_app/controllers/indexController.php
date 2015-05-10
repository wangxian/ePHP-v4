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
	public function indexAction()
	{
		echo '<a href="'. U('index/xml') .'" style="font-size:18px;color:red;">测试一下</a><br />';
		highlight_file(__FILE__);
	}

	public function xmlAction()
	{
		header('Content-type: text/xml');

		$data = array('files'=>array(array('name'=>'wangxian1','info'=>'wx'), array('name'=>'wangxian2','info'=>'wx2'), 'child_label'=>'file'));
		echo Xml::toXml($data);
	}

	/** 测试解析indexAction生成的xml。 **/
	function testAction()
	{
		printdie( simplexml_load_file( 'http://svn.local/ePHP/examples/9.xml/index.php' ) );
	}

}