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
		echo '<div style="margin:5px;padding:1em;min-height:22px;background-color:#E6EFC2;color:#264409;border:2px #C6D880 solid;font-size:12px;">';

		echo '<h1>run_info()</h1>在程序的任何地方,你都可以使用run_info()方法来测试系统的运行效率，将显示<span style="color:red;font-weight:bolder;">运行时间、查询数据库次数</span><br />真正意义上的运行时间，包括framework的加载调度耗时，一直到渲染页面结束。<br />';
		echo '<a href="'. U('index/run_info') .'" style="font-size:18px;color:red;">测试一下</a>';
		echo '</div>';
	}

	public function run_infoAction()
	{
		run_info();
		echo '<br /><a href="'. U('index/run_info') .'" style="font-size:18px;color:red;">测试一下</a>';
	}

}