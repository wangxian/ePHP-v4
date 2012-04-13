<?php
 /**
 +------------------------------------------------------------------------------
 * 挂件类
 * Widget for ePHP
 +------------------------------------------------------------------------------
 * @version 3.2
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2011-06-04 23:15:26
 * @last_modified 2011-06-04 22:24:46
 +------------------------------------------------------------------------------
 */
//abstract class Widget

class Widget
{
	private $tVar=array(); //模板变量assign
//	abstract public function run();
	public function __construct(){ $this->view = $this;} //不改变控制器中的使用习惯

	/**
	 * @param string $name widget name
	 * @param array $data default ''
	 */
	static public function show($name,$data='')
	{
		$classname = $name.'Widget';
		include APP_PATH.'/widgets/'.$name.'/'.$classname.'.php';
		$widget = new $classname;
		if(method_exists($widget,'run')) $widget->run($data);
		else throw new ephpException("{$classname} 中run()接口方法未定义.",110605);
	}

	/**
	 * widget视图渲染
	 * @param string $file
	 */
	protected function render($file='')
	{
		if (!$file) $file = substr(get_class($this),0,-6);
		$filename = APP_PATH.'/widgets/'.$file.'/'.$file.'.tpl.php';//视图全路径

		if(! file_exists($filename)) throw new ephpException("widget模版文件：{$filename} 不存在，请检查以确认。");
		if(! empty($this->tVar)) extract($this->tVar); //释放assign的变量
		include $filename;
	}

	protected function layout($file='',$expire=-1) { $this->render($file,$expire); }
    protected function assign($name,$value='') { $this->tVar[$name] = $value; }
}