<?php
/**
 +------------------------------------------------------------------------------
 * ephpExeption异常处理
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @email wo@wangxian.me
 * @package  core
 * @creation_date 2010-10-17
 * @last_modified 2010-12-25 19:04:58
 +------------------------------------------------------------------------------
 */

class ephpException extends Exception
{
	/**
	 * @param string $message 错误消息
	 * @param integer $code 错误码
	 * @param object|array $previous
	 */
	public function __construct($message, $code=0, $previous=null)
	{
		//5.3.0  The previous parameter was added.
		//5.3.0 以后previous才新增的
		parent::__construct($message,$code);

		$this->ephpTraceString = $this->getTraceAsString();

		if(is_array($previous))
		{
			$this->file = $previous['errfile'];
			$this->line = $previous['errline'];
		}
		else if(is_object($previous))
		{
			$this->file = $previous->getFile();
			$this->line = $previous->getLine();
			$this->ephpTraceString = $previous->getTraceAsString();
		}
	}

	public function __toString()
	{
		if(C('exception_log'))
		{
			$str = "\n异常信息:{$this->getMessage()}\n错误文件:{$this->getFile()}\n错误行数:{$this->getLine()}\n异常代码:{$this->getCode()}\n------------------------------";
			wlog('ExceptionLog', $str);
		}

		//ob_start();
		$tpl = C('tpl_exception');
		if(! $tpl ) include FW_PATH . '/tpl/ephpException.tpl.php';
		else include APP_PATH.'/views/public/'.$tpl;

	    //return ob_get_clean();
		return '';
	}

}

/* End of file ephpException.class.php */
/* Location: ./_framework/libraries/ephpException.class.php */
