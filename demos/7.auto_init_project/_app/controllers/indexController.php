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
		echo '<div style="margin:5px;padding:1em;min-height:22px;background-color:#E6EFC2;color:#264409;border:2px #C6D880 solid;font-size:12px;">';

		echo "<h1>自动创建项目</h1><hr />
在index.php的下面这行后面<br />
<div style='color:blue'>include FW_PATH . '/ePHP.php';	#加载框架入口</div><br />

加入下面这行,自动创建后请注释掉它。<br />
<div style='color:red'>include FW_PATH.'/tpl/init/create.php';</div>
";
		echo '</div>';
	}
}