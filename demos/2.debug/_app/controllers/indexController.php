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
class indexController
{
	public function indexAction()
	{
		echo '<div style="margin:5px;padding:1em;min-height:22px;background-color:#E6EFC2;color:#264409;border:2px #C6D880 solid;font-size:12px;">';

		echo '
		<h1>debug模式</h1>
		ePHP在debug模式下，错误级别是E_ALL | E_STRICT，这样会显示所有的PHP错误，保证你写的代码具有最好的兼容性。<br />
		说明：main.config.php中debug为true时，ePHP将下面的4项将强制设为true，不管原来是false或true，当你debug=false才会使用原来的。<br />

		<pre>
		/* 打印log相关配置 */
		"access_log" 		=> false,	#是否记录access_log日志
		"exception_log"		=> false,	#是否记录EXCEPTION日志
		"sql_log" 			=> false,	#是否记录SQL日志

		/* 显示系统错误 */
		"show_errors"		=> true,	#是否显示系统错误信息，true显示，false不显示。
		</pre>


		<h1>show_errors</h1>
		控制是否显示错误，如果设置为true，那么所有的错误都将会显示，并抛出错误异常。<br />
		false的时候，不显示系统错误，如果你发现程序无法运行了。请设置debug=true<br /><br />

		说明：设置show_errors，不管php.ini配置display_errors=On或Off，都成立。<br />

		<h1>关于系统log</h1>
		<p>ePHP的系统log包括三部分，访问日志：access_log, 异常错误日志：exception_log， 数据库SQL执行日志：sql_log。<br />
			log的位置在 _app/runtime/logs/ 下。每天一个文件。分别为：AccessLog-2009-12-13.log | ExceptionLog-2009-12-13.log | SQL-Log-2009-12-13.log<br /><br />
			这样你就可以在show_errors关闭的情况下，查询系统运行记录。<br />
			当然,一般情况下你不需要开启所有的系统log，那样会影响系统性能的。
		</p>
		<div style="color:red;">补充：在SAE平台上运行ePHP时，access_log,exception_log,sql_log设置将失去作用。不会记录log日志。 </div>

		<h1>错误演示：</h1>';
			echo '1、<a href="'. U('index/error1') .'">数组下标 不存在notice错误。</a><br />';
			echo '2、<a href="'. U('index/error2') .'">错误异常，包括数组下标错，和常规的warning错误。</a><br />';
		echo '</div>';

	}

	public function error1Action()
	{
		$key = $_GET['key'];
	}

	public function error2Action()
	{
		100/0;
	}

}