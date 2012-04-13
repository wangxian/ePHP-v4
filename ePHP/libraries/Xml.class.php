<?php
/**
 +------------------------------------------------------------------------------
 * XML类
 * 生成xml,解析xml
 +------------------------------------------------------------------------------
 * @version 4.1
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2010-10-15
 * @last_modified 2011-10-08
 +------------------------------------------------------------------------------
 */

class Xml
{
	/**
	 * array生成xml
	 * @param mixed $data
	 * @param string $encoding
	 */
	public static function toXml($data, $encoding='UTF-8')
	{
		header('Content-Type: text/xml');
	    $xml  = '<?xml version="1.0" encoding="'. $encoding ."\"?>\n";
		return $xml .= self::_to_xml_body($data);
	}

	/**
	 * @param mixed $data
	 * @param string $child_label
	 * @ignore
	 */
	private static function _to_xml_body($data,$child_label='')
	{
	    if(is_object($data)) $data = get_object_vars($data);
	    $xml = '';
	    foreach($data as $key=>$val)
	    {
	    	//echo $child_label.'=child_label<->'.$key."\n";
	        if($child_label && is_numeric($key)) $key = $child_label;
	        $xml .= "<{$key}>";
			if( is_object($val) ) $val=(array)$val;
	        if( is_array($val) )
	        {
	        	$child_label_next = substr($key, 0, -1);
				$xml .=  "\n".self::_to_xml_body($val,$child_label_next);
	        }
	        else $xml .= $val;
	        $xml .= "</{$key}>\n";
	    }
	    return $xml;
	}

	/**
	 * xml2array
	 * 只支持节点解析，不支持属性节点
	 * @param string xml内容
	 * @param boolean $file xml文件路径
	 */
	public static function toArray($xml, $file=false)
	{
		$data = $file ? simplexml_load_file($xml) : simplexml_load_string($xml);
		return self::_toArray($data);
	}

	/**
	 * SimpleXMLElement to array
	 * @ignore
	 */
	private static function _toArray($data, $recursion=false)
	{
		$tmp = array();
		$data = (array)$data;
		foreach($data as $k=>$v)
		{
			$v = (array)$v;
			if( isset($v[0]) && is_string($v[0]) ) $tmp[$k] = $v[0];
			else $tmp[$k] = self::_toArray($v, true);
		}
		return $tmp;
	}
}
