<?php
 /**
 +------------------------------------------------------------------------------
 * 目录操作类
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @package  libraries
 * @email wo#wangxian.me
 * @creation_date 2011-1-1 下午05:59:48
 * @last_modified 2011-06-04 22:21:03
 +------------------------------------------------------------------------------
 */

class Dir
{
	/**
	 * 遍历目录
	 * 默认获取相对于index.php目录下的目录和文件
	 * @param string  $source_dir 相对于index.php的目录
	 * @param boolean $subdir 递归子目录,true包含，false不包含
	 * @return mixed
	 */
	public static function map($source_dir, $subdir = true)
	{
		if ( true == ($fp = opendir($source_dir)) )
		{
			$source_dir = rtrim($source_dir, '/').'/';
			$filedata = array();

			while (false !== ($file = readdir($fp)))
			{
				if ( $file == '.' OR $file == '..' ) continue;

				if ($subdir && is_dir($source_dir.$file))
				{
					$temp_array = array();
					$temp_array = self::map($source_dir.$file.'/', $subdir);
					$filedata[$file] = $temp_array;
				}
				else
				{
					$filedata[] = $file;
				}
			}

			closedir($fp);
			return $filedata;
		}
		else
		{
			return false;
		}
	}

	/**
	 * 判断目录是否为空
	 * @param string $dir
	 * @return boolean true为空，false不为空
	 */
	public static function isEmpty($dir)
	{
		$handle = opendir($dir);
		$i = 0;
		while( false !== ($file = readdir($handle)) ) $i++;
		closedir($handle);

		if($i >= 2) return false;
		else return true;
	}

	/**
	 * 删除目录以及子目录的内容
	 * @param string $dir
	 * @return boolean
	 */
	public static function deleteDir($dir)
	{
		$d = dir($dir);
		while( false !== ($entry = $d->read()) )
		{
			if($entry == '.' || $entry == '..') continue;
			$currele = $d->path.'/'.$entry;
			if(is_dir($currele))
			{
				if(self::isEmpty($currele)) rmdir($currele);
				else self::deleteDir($currele);
			}
			else unlink($currele);
		}
		$d->close();

		rmdir($dir);
		return true;
	}
}
/* End of file Dir.class.php */
/* Location: ./ePHP/libraries/Dir.class.php */