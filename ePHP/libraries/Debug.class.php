<?php
 /**
 +------------------------------------------------------------------------------
 * debug调试类
 +------------------------------------------------------------------------------
 * @version 3.1
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2011-1-23 下午02:57:25
 * @last_modified 2011-05-03
 +------------------------------------------------------------------------------
 */

class Debug
{
	/** 跟踪程序的执行路径，主要用于程序调试 */
	public static function dumpTrace()
    {
        $debug = debug_backtrace();
        $lines = '';
        $index = 0;
        for ($i = 0; $i < count($debug); $i ++)
        {
            if ($i == 0)
            {
                continue;
            }
            $file = $debug[$i];
            if (! isset($file['file']))
            {
                $file['file'] = 'eval';
            }
            if (! isset($file['line']))
            {
                $file['line'] = null;
            }
            $line = "#{$index} {$file['file']}({$file['line']}): ";
            if (isset($file['class']))
            {
                $line .= "{$file['class']}{$file['type']}";
            }
            $line .= "{$file['function']}(";
            if (isset($file['args']) && count($file['args']))
            {
                foreach ($file['args'] as $arg)
                {
                    $line .= gettype($arg) . ', ';
                }
                $line = substr($line, 0, - 2);
            }
            $line .= ')';
            $lines .= $line . "\n";
            $index ++;
        } // for

        $lines .= "#{$index} {main}\n";

        if (ini_get('html_errors'))
        {
            echo nl2br(str_replace(' ', '&nbsp;', $lines));
        }
        else
        {
            echo $lines;
        }
    }

	/**
	 * 格式化输出
	 * <pre>
	 * 1.浏览器友好的变量输出，var支持任何变量，echo表示是否需要输出，如果为否，则返回要显示的字符串。
	 * 2.Strict表示是否输出详细信息，如果为否，使用print_r输出，如果为是，使用var_dump输出。
	 * 3.Dump函数还支持xdebug扩展
	 * </pre>
	 * @param string  $var
	 * @param boolean $echo
	 * @param string  $label
	 * @param boolean $strict
	 * @return void
	 */
	public static function dump($var, $label=null, $strict=true, $echo=true)
	{
		dump($var, $label, $strict, $echo);
	}
}
/* End of file Debug.class.php */
/* Location: ./_framework/libraries/Debug.class.php */