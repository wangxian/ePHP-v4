<?php
 /**
 +------------------------------------------------------------------------------
 * 分页导航 通用类 暂时提供了5中通用的分页方法；
 * 用法：$link = new Link('当第几页', '总数据量', '分页的url', '每页显示的数据数', '每次显示的页数');
 * 类初始化后：$link->show(3);
 * by 木頭
 * 2008.12.22
 +------------------------------------------------------------------------------
 * @version 2.5
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2008.12.22
 * @last_modified 2011-06-05
 +------------------------------------------------------------------------------
 */

class Link
{
	private $cpage=1; // 当前页码
	private $totaldata; // 总数据数
	private $url; // ?page=xx前面的部分
	private $pagenum=10; // 每页数据数
	private $opage; // 每次显示的页码数,有些分页样式无效。
	private $totalpage; // 总页数
	public function __construct($cpage, $totaldata, $url, $pagenum=10, $opage=9)
	{
		$this->cpage = $cpage;
		$this->totaldata = $totaldata;
		$this->url = $url;
		$this->totalpage = $totaldata ? ceil( $totaldata / $pagenum ) : 1;

		$this->opage = $opage;
	}

	/**
	 * 样式选择器
	 * 显示翻页
	 * -1 : 最简单的上一页 下一些
	 * -2 : 一次翻翻N页的 Link
	 * -3 : 滑动滚动
	 * -4 : wap2.0
	 * -5 : wap1.2
	 * @param integer $style 可选：1,2,3,4,5
	 */
	public function show($style)
	{
		switch ($style) {
			case 1 : //最简单的上一页 下一些
				return $this->f1();
				break;
			case 2 : //一次翻翻N页的 Link
				return $this->f2();
				break;
			case 3 : //滑动滚动
				return $this->f3();
				break;
			case 4 ://wap2.0
				return $this->f4();
				break;
			case 5 ://wap1.2
				return $this->f5();
				break;
			default:$this->f1();
		}
	}

	private function url($tpage) { return $this->url.'?page='.$tpage; }

	/** 普通的上一页，下一页方式 */
	private function f1()
	{
		$_linkstr = "\n<p class=\"links\">\n"; //begin
		if ($this->totalpage < 2) {
			$nextpage = $this->cpage + 1;
			$_linkstr .= "<span class=\"disabled\">首页</span>" . " \n";
			$_linkstr .= "<span class=\"disabled\">上一页</span> \n";
			$_linkstr .= "<span class=\"disabled\">下一页</span> \n";
			$_linkstr .= "<span class=\"disabled\">尾页</span> \n";
		} elseif ($this->cpage < 2) {
			//首页
			$nextpage = $this->cpage + 1;
			$_linkstr .= "<span class=\"disabled\">首页</span>" . " \n";
			$_linkstr .= "<span class=\"disabled\">上一页</span> \n";
			$_linkstr .= "<a href=\"" . $this->url ( $nextpage ) . "\">下一页</a> \n";
			$_linkstr .= "<a href=\"" . $this->url ( $this->totalpage ) . "\">尾页</a> \n";
		} elseif ($this->cpage >= $this->totalpage) {
			//＝尾页
			$prepage = $this->cpage - 1;

			$_linkstr .= "<a href=\"" . $this->url ( 1 ) . "\">首页</a>\n";
			$_linkstr .= "<a href=\"" . $this->url ( $prepage ) . "\">上一页</a>\n";
			$_linkstr .= "\n<span class=\"disabled\">下一页</span>\n";
			$_linkstr .= "<span class=\"disabled\">尾页</span>" . "\n";
		} else {
			//正常
			$prepage  = $this->cpage - 1;
			$nextpage = $this->cpage + 1;

			$_linkstr .= "<a href=\"" . $this->url ( 1 ) . "\">首页</a>\n";
			$_linkstr .= "<a href=\"" . $this->url ( $prepage ) . "\">上一页</a>\n";
			$_linkstr .= "\n<a href=\"" . $this->url ( $nextpage ) . "\">下一页</a>\n";
			$_linkstr .= "<a href=\"" . $this->url ( $this->totalpage ) . "\">尾页</a>\n";
		}
		$_linkstr .= "</p>\n"; //end div
		return $_linkstr;
	}

	/** 一次翻N页的 Link */
	private function f2()
	{
		$p1 = ceil ( ($this->cpage - $this->opage) / $this->opage );

		//计算开始页 结束页
		$beginpage = $p1 * ($this->opage) + 1;
		$endpage = ($p1 + 1) * ($this->opage);
		if ($endpage > $this->totalpage)
		{
			//最后一页 大于总页数
			$endpage = $this->totalpage;
		}

		//前后滚10页
		$preopage = ($beginpage - $this->opage > 0) ? $beginpage - $this->opage : ''; //上一个N页码
		$nextopage = ($beginpage + $this->opage < $this->totalpage) ? $beginpage + $this->opage : ''; //下一个N页码


		$_linkstr = "\n<p class=\"links\">\n"; //begin

		//分页
		$_linkstr .= "<span class=\"disabled\">分页:{$this->cpage}/{$this->totalpage}</span>\n";

		//前滚10页码
		if ($preopage)
			$_linkstr .= "<a href=\"" . $this->url ( $preopage ) . "\">上{$this->opage}页</a>\n";
		else
			$_linkstr .= "<span class=\"disabled\">上{$this->opage}页</span>\n";

		//主要的数字分页 页码
		for($i = $beginpage; $i <= $endpage; $i++)
		{
			if ($this->cpage != $i)
				$_linkstr .= "<a href=\"{$this->url($i)}\">" . $i . "</a>\n";
			else
				$_linkstr .= "<span class=\"current\">{$i}</span>\n";
		}

		//后滚10页码
		if ($nextopage)
			$_linkstr .= "<a href=\"{$this->url($nextopage)}\">下{$this->opage}页</a>\n";
		else
			$_linkstr .= "<span class=\"disabled\">下{$this->opage}页</span>\n";

		$_linkstr .= "</p>\n"; //end div
		return $_linkstr;
	}

	/** 中间滑动滚动 */
	private function f3()
	{
		//计算开始页 结束页
		if ($this->cpage > ceil ( ($this->opage) / 2 ))
		{
			$beginpage = $this->cpage - floor( ($this->opage) / 2 );
			$endpage = $this->cpage + floor( ($this->opage) / 2 );
		}
		else
		{
			$beginpage = 1;
			$endpage = $this->opage;
		}

		//限制末页
		if ($endpage > $this->totalpage) $endpage = $this->totalpage;

		$_linkstr = "\n<p class=\"links\">\n"; //begin

		//分页
		$_linkstr .= "<span class=\"disabled\">分页:{$this->cpage}/{$this->totalpage}</span>\n";

		//首页
		if ($this->cpage > 1)
		{
			$_linkstr .= "<a href=\"{$this->url(1)}\">首页</a> \n";
			$_linkstr .= "<a href=\"" . $this->url ( $this->cpage - 1 ) . "\">上一页</a> \n";
		}
		else
		{
			$_linkstr .= "<span class=\"disabled\">首页</span>" . " \n";
			$_linkstr .= "<span class=\"disabled\">上一页</span>" . " \n";
		}

		//main num. Link
		for($i = $beginpage; $i <= $endpage; $i++)
		{
			if ($this->cpage != $i)
				$_linkstr .= "<a href=\"{$this->url($i)}\">" . $i . "</a> \n";
			else
				$_linkstr .= "<span class=\"current\">{$i}</span> \n";
		}

		//尾页
		if ($this->cpage == $this->totalpage || $this->totalpage == 0)
		{
			$_linkstr .= "<span class=\"disabled\">下一页</span>" . " \n";
			$_linkstr .= "<span class=\"disabled\">尾页</span>" . " \n";
		}
		else
		{
			$_linkstr .= "<a href=\"" . $this->url ( $this->cpage + 1 ) . "\">下一页</a> \n";
			$_linkstr .= "<a href=\"" . $this->url ( $this->totalpage ) . "\">尾页</a> \n";
		}
		$_linkstr .= "</p>\n"; //end div
		return $_linkstr;
	}

	/** wap2.0分页 */
	private function f4()
	{
		if($this->cpage > $this->totalpage) $this->cpage = 1;
		$out = '<form method="post" action="'. $this->url( $this->cpage ) .'">';
		$out .= '<p class="links">';

	    // 上一页
		if ($this->cpage > 1) $out .= '<a href="'. $this->url($this->cpage - 1) .'">上页</a>&nbsp;';

		// 下一页
	    if ( $this->cpage < $this->totalpage ) $out .= '<a href="'. $this->url($this->cpage + 1).'">下页</a>&nbsp;'."\n";

		$out .= '&nbsp;&nbsp;<input type="text" name="page" size="2" value="'. $this->cpage .'" />';
		$out .= '<input type="submit" name="pagego" value="跳转" />';
		$out .= '&nbsp;&nbsp;'. $this->cpage .'/'. $this->totalpage .'页'."\n";

		$out .= '</p>';
		$out .= '</form>';

		return $out;
	}

	/** wap1.2分页 */
	private function f5()
	{
		$_linkstr = "\n<p class=\"links\">\n"; //begin

		//下一页 尾页
		if ($this->cpage == $this->totalpage || $this->totalpage == 0)
			$_linkstr .= "<span class=\"disabled\">下一页</span>" . " \n";
		else
			$_linkstr .= "<a href=\"" . $this->url ( $this->cpage + 1 ) . "\">下一页</a> \n";

		$_linkstr .=' / ';

		//首页
		if ($this->cpage > 1)
			$_linkstr .= "<a href=\"" . $this->url ( $this->cpage - 1 ) . "\">上一页</a>\n";
		else
			$_linkstr .= "<span class=\"disabled\">上一页</span>" . "\n";

		$_linkstr .='<br />';

		//数字分页
		if($this->totalpage<7)
		{
			for($i=1;$i<$this->totalpage+1;$i++)
			{
				if($this->cpage == $i)
					$_linkstr .=  "<span class=\"current\">$i</span>\n";
				else
					$_linkstr .= "<a href=\"{$this->url($i)}\">{$i}</a> \n";
			}
		}
		elseif($this->cpage < 4 && $this->totalpage>7)
		{
			for($i=1;$i<5;$i++)
			{
				if($this->cpage == $i)
					$_linkstr .=  "<span class=\"current\">$i</span>\n";
				else
					$_linkstr .= "<a href=\"{$this->url($i)}\">{$i}</a>\n";
			}
			$_linkstr .= " ... ";
			$_linkstr .= "<a href=\"{$this->url($this->totalpage)}\">{$this->totalpage}</a>\n";
		}
		elseif($this->cpage >= 4 && $this->totalpage > $this->cpage + 4)
		{
			$beginpage = $this->cpage - ceil ( ($this->opage) / 2 );
			for($i=$this->cpage - 2;$i<=$this->cpage+1;$i++)
			{
				if($this->cpage == $i)
					$_linkstr .=  "<span class=\"current\">$i</span>\n";
				else
					$_linkstr .= "<a href=\"{$this->url($i)}\">{$i}</a>\n";
			}
			$_linkstr .= " ... ";
			$_linkstr .= "<a href=\"{$this->url($this->totalpage)}\">{$this->totalpage}</a>\n";
		}
		elseif($this->totalpage <= $this->cpage + 4)
		{
			$beginpage = $this->cpage - ceil ( ($this->opage) / 2 );
			for($i=$this->totalpage-7;$i<=$this->totalpage;$i++)
			{
				if($this->cpage == $i)
					$_linkstr .=  "<span class=\"current\">$i</span>\n";
				else
					$_linkstr .= "<a href=\"{$this->url($i)}\">{$i}</a> \n";
			}
		}

		$_linkstr.='
			到<input name="goPageNo" format="*N" size="2" value="" maxlength="3" emptyok="true"/>页
			<anchor>
			<go href="'. $this->url('') .'" method="post" sendreferer="true">
				<postfield name="page" value="$goPageNo"/>
			</go>跳转
			</anchor>
		';
		$_linkstr .= "</p>\n"; //end div
		return $_linkstr;
	}
}
/* End of file Link.class.php */
/* Location: ./_framework/libraries/Link.class.php */