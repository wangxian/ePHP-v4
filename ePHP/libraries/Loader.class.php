<?php
 /**
 +------------------------------------------------------------------------------
 * Loader for ePHP
 +------------------------------------------------------------------------------
 * @version 3.2
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2011-06-04 23:15:26
 * @last_modified 2011-06-04 22:24:46
 +------------------------------------------------------------------------------
 */

class Loader
{
	/**
	 * 用户自定义函数装载器
	 * 说明：用户自定义函数放在{APP_PATH}/exts/helper/xx.php
	 * @param string $helper 自定义方法名，如mytest
	 */
	public static function helper($helper)
	{
		$helper = APP_PATH.'/exts/helper/'.$helper.'.php';
		try
		{
			include_once $helper;
		}
		catch (Exception $e)
		{
			throw new ephpException("加载helper失败，$helper 不存在。",110604);
		}
	}
}