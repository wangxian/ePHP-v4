<?php
/**
 +------------------------------------------------------------------------------
 * 视图类
 * 扩展view 使其支持多视图
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email admin@loopx.cn
 * @creation_date 2011-1-10
 * @last_modified 2011-9-19
 +------------------------------------------------------------------------------
 */

class MultiView extends view
{
	/**
	 * 引用视图 或 视图片段，多视图支持
	 * @param type $file 变量名
	 * @param type $layout_block 是否渲染布局模版
	 */
	public function _include($file, $layout_block=false)
    {
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



        if( is_array($this->vars) ) extract($this->vars);
		if($layout_block)
		{
			ob_start();
			include APP_PATH . '/views/'. $file;
			$content = ob_get_clean();
			if($this->_layout)
			{
				$this->_layout = array_reverse($this->_layout);//反转数组
				foreach ($this->_layout as $k=>$v)
					$content = str_replace ("<!--{layout_block_{$k}}-->", $v,$content);
			}
			echo $content;
		}
		else include APP_PATH . '/views/'. $file;
    }
}