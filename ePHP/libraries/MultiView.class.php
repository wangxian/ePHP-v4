<?php
/**
 +------------------------------------------------------------------------------
 * 视图类
 * 扩展view 使其支持多视图
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2011-1-10
 * @last_modified 2011-9-19
 +------------------------------------------------------------------------------
 */

class MultiView extends view
{
	/**
	 * 引用视图 或 视图片段
	 * @param string $file 变量名
	 * @param string $layout_block 是否渲染布局模版
	 * @param boolean $layout_block 使用布局模版否
	 * @param boolean $return 返回模版内容 or 直接输出
	 */
	public function _include($file, $__vars=null, $layout_block=false, $return=false)
    {
        if( is_array($this->vars) ) extract($this->vars);
		if( is_array($__vars) ) extract($__vars);

		/* support MultiView */
		$file = $this->__filename($file);
		$tpl = C('tpl_switch');

		if(! file_exists(APP_PATH.'/views/'. $tpl .'/'.$file) )
		{
			if($tpl !== 'default')
			{
				 if(file_exists(APP_PATH.'/views/default/'.$file)) $tpl = 'default';
				 else throw new ephpException("视图{$tpl}/{$file}不存在，公共视图default/{$file}也不存在,请保证其一存在!");
			}
			else throw new ephpException("主题视图{$tpl}/{$file}不存在。");;
		}

		$file=$tpl.'/'.$file;
		/* support MultiView */

		if($layout_block)
		{
			$tpl = C('tpl_switch');

			ob_start();
			include APP_PATH . '/views/'. $file;
			$content = ob_get_clean();
			//echo $content;print_r($this->_layout);exit;

			if($this->_layout)
			{
				foreach ($this->_layout as $k=>$v) $content = str_replace ("<!--{layout_block_{$k}}-->", $v, $content);
			}

			//是否返回
			if($return) return $content; else echo $content;
		}
		else if($return)
		{
			ob_start();include APP_PATH . '/views/'. $file;
			return ob_get_clean();
		}
		else include APP_PATH . '/views/'. $file;
    }
}