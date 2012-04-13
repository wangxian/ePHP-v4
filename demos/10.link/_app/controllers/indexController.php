<?php
/**
 +------------------------------------------------------------------------------
 * index
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<admin@loopx.cn>
 * @creation date 2011-07-31 02:04:00
 * @last modified 2011-07-31 02:04:05
 +------------------------------------------------------------------------------
 */
class indexController
{
	public function indexAction()
	{
		//用法：$link = new Link('当第几页', '总数据量', '分页的url', '每页显示的数据数'=10, '每次显示的页数'=8);
		//类初始化后：$link->show(3);
		//默认每页10条数据，分页导航每次显示8个。

		header("Content-type:text/html;charset=utf8");
		echo '

		<style>
		*{font-size:12px;}
		.links a{text-decoration:none;color:#0063e3;border:solid 1px #DDDDDD;margin-right:2px;padding:3px 6px;}
		.links a:visited{color: #5C0F01;}
		.links a:hover{border:solid 1px #999;color:red;}


		.links .current{padding:3px 6px;color:#FFFFFF;background-color:#036cb4;font-weight:bold;border:1px solid #DDDDDD;}
		.links .disabled{color:#999;padding:3px 4px;border:solid 1px #DDDDDD;}
		</style>

		';

		$link = new Link(getv('page',1), 1570, U('index/index'));

		echo '展示样式1 普通上下页 $link->show(1)：'.$link->show(1);

		echo "<br />";
		echo '展示样式2 批量翻页 $link->show(2)：'.$link->show(2);

		echo "<br />";
		echo '展示样式3 滑动滚动 $link->show(3)：'.$link->show(3);

		echo "<br />";
		echo 'wap2.0分页 $link->show(4)：'.$link->show(4);

		echo '<p>wap1.2分页：</p>';
		echo $link->show(5);

		highlight_file(__FILE__);
	}
}