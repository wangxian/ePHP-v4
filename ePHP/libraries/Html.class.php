<?php
 /**
 +------------------------------------------------------------------------------
 * Html辅助类
 * html生成，生存表单元素等；
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @email wo@wangxian.me
 * @package  libraries
 * @creation_date 2010-10-17
 * @last_modified 2010-12-25 19:02:12
 +------------------------------------------------------------------------------
 */

class Html
{
	/**
	 * html select默认选中判断
	 * 判断str1 str1是否相同，相同返回selected 否则为空。
	 * @param string $str1
	 * @param string $str2
	 */
	public static function selected($str1,$str2)
	{return $str1 == $str2 ? 'selected="selected"':'';}

	/**
	 * html checkbox默认选中判断
	 * 判断str1 str1是否相同，相同返回selected 否则为空。
	 * @param string $str1
	 * @param string $str2
	 */
	public static function checked($str1,$str2)
	{return $str1 == $str2 ? 'checked="checked"':'';}

	/**
	 * 生成a链接，只能生成本站内的地址
	 * @param string $uri '控制器/action'
	 * @param string $text '链接文字'
	 * @return string
	 */
	public static function a($uri, $text='')
	{
		$text = ($text == '') ? $uri : $text;
		return '<a href="'. U($uri) .'" title="">'. $text .'</a>';
	}

	/**
	 * 生成img的图片显示
	 * @param string $pic 图片url
	 * @param string $alt 图片alt属性
	 * @return string
	 */
	public static function img($pic, $alt='')
	{
		return '<img src="'. $pic .'" alt="'. $alt .'" />';
	}

	/**
	 * 输出n个br换行
	 * @param integer $repeat
	 * @return string
	 */
	public static function br($repeat = 1)
	{
		return str_repeat("<br />\n", $repeat);
	}

	/**
	 * 输出n个html空格
	 * @param integer $repeat
	 * @return string
	 */
	public static function nbsp($repeat = 1)
	{
		return str_repeat("&nbsp;", $repeat);
	}

	/**
	 * 生成html外链资源link
	 * 链接资源、css、js、ico
	 * @param $source 列举资源类型
	 * @return string
	 */
	public static function link_tag($source)
	{
		$ext = strrchr($source, '.');
		if($ext == '.css')
			return "<link href=\"{$source}\" rel=\"stylesheet\" type=\"text/css\" />";
		else if($ext == '.js' )
			return '<script type="text/javascript" src="'. $source .'"></script>';
		else if($ext == '.ico' )
			return '<link href="'. $source .'" rel="shortcut icon" type="image/ico" />';
	}

	/**
	 * 生成ul格式的html数据
	 * @param array $data 支持多维数组
	 * @param array $attributes array('id'=>'', 'class'=>'')
	 * @return string
	 */
	public static function ul($data, $attributes=array())
	{
		if( ! is_array($data) ) return '';
		$attributes = $attributes + array('id'=>'', 'class'=>'');

		$str="<ul id=\"". $attributes['id'] ."\" class=\"". $attributes['class'] ."\">\n";
		foreach ($data as $k=>$v)
		{
			$str .= "\t<li>";
			$str .= is_array($v) ? $k.self::ul($v) : $v;
			$str .= "</li>\n";
		}
		$str .= "</ul>\n";
		return $str;
	}

	/**
	 * 生成ol格式的html数据
	 * @param array $data 数据，支持多维数组
	 * @param array $attributes array('id'=>'', 'class'=>'')
	 * @return string
	 */
	public static function ol($data, $attributes=array())
	{
		if( ! is_array($data) ) return '';
		$attributes = $attributes + array('id'=>'', 'class'=>'');

		$str="<ol id=\"". $attributes['id'] ."\" class=\"". $attributes['class'] ."\">\n";
		foreach ($data as $k=>$v)
		{
			$str .= "\t<li>";
			$str .= is_array($v) ? $k.self::ol($v) : $v;
			$str .= "</li>\n";
		}
		$str .= "</ol>\n";
		return $str;
	}

	/**
	 * 生成html的table结构
	 * @param array $data 必须是二维数组
	 * @param array $title table标题,一维数组
	 * @param array $attributes
	 * @return string
	 */
	public static function table($data,$title=array(),$attributes=array())
	{
		// 必须是二维数组
		if( is_string($data) ) return $data;
		else if( is_array($data) && ! is_array(reset($data)) ) return implode(' ', $data);

		$attributes = $attributes + array('id'=>'', 'class'=>'');

		$str="<table id=\"". $attributes['id'] ."\" class=\"". $attributes['class'] ."\">\n";

		//table th
		if(!empty($title))
		{
			$str .= "\t<tr>\n";
			foreach ($title as $v) $str .= "\t\t<th>{$v}</th>\n";
			$str .= "\t</tr>\n";
		}
		foreach ($data as $v1)
		{
			$str .= "\t<tr>\n";
			foreach ($v1 as $k2=>$v2)
			{
				//非数字主键作为td的id
				if(is_numeric($k2)) $str .= "\t\t<td>";
				else $str .= "\t\t<td id=\"tb_{$k2}\">";
				$str .= is_array($v2) ? self::table($v2) : $v2;
				$str .= "</td>\n";
			}
			$str .= "\t</tr>\n";
		}
		$str .= "</table>\n";
		return $str;
	}

	/**
	 * 生成form hidden内容
	 * -
	 * @param mixed $name hidden名称，如果想批量设置，此为数组
	 * @param string $value
	 */
	public static function form_hidden($name,$value='')
	{
		if(is_string($name))
			return '<input type="hidden" id="'. $name .'" name="'. $name .'" value="'. $value .'" />'."\n";
		elseif (is_array($name))
		{
			$hidden = '';
			foreach ($name as $k=>$v)
			{
				$hidden .= '<input type="hidden" id="'. $k .'" name="'. $k .'" value="'. $v .'" />'."\n";
			}
			return $hidden;
		}
		else return '';
	}

	/**
	 * 下拉框
	 * Html::form_select(select的name，option的名称和value，默认选中|可以是同时选中几个,额外参数如js等)
	 * @param string $name
	 * @param array $options
	 * @param mixed $selected
	 * @param string $extra
	 * @return string
	 */
	public static function form_select($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'" id="'.$name.'"'. $extra.$multiple .">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}

	/**
	 * 生成checkbox
	 * @param mixed $data
	 * @param mixed $value
	 * @param string $checked
	 * @param string $extra
	 * @return string
	 */
	public static function form_checkbox($data='', $value='', $checked=FALSE, $extra='')
	{
		$defaults = array('type' => 'checkbox', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		if (is_array($data) && array_key_exists('checked', $data))
		{
			$checked = $data['checked'];

			if ($checked == FALSE)
			{
				unset($data['checked']);
			}
			else
			{
				$data['checked'] = 'checked';
			}
		}

		if ($checked == TRUE)
		{
			$defaults['checked'] = 'checked';
		}
		else
		{
			unset($defaults['checked']);
		}

		return "<input ".self::_parse_form_attributes($data, $defaults).$extra." />\n";
	}

	/**
	 * 生成radio
	 * @param mixed $data
	 * @param mixed $value
	 * @param string $checked
	 * @param string $extra
	 * @return string
	 */
	public static function form_radio($data = '', $value = '', $checked = FALSE, $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'radio';
		return self::form_checkbox($data, $value, $checked, $extra);
	}

	/**
	 * Parse the form attributes
	 * @ignore
	 * @param mixed $attributes
	 * @param mixed $default
	 * @return string
	 */
	private static function _parse_form_attributes($attributes, $default)
	{
		if (is_array($attributes))
		{
			foreach ($default as $key => $val)
			{
				if (isset($attributes[$key]))
				{
					$default[$key] = $attributes[$key];
					unset($attributes[$key]);
				}
			}

			if (count($attributes) > 0)
			{
				$default = array_merge($default, $attributes);
			}
		}

		$att = '';

		foreach ($default as $key => $val)
		{
			if ($key == 'value')
			{
				$val = self::form_prep($val, $default['name']);
			}

			$att .= $key . '="' . $val . '" ';
		}

		return $att;
	}

	/**
	 * 安全表单内容
	 * 允许你放心地在表单元素中使用HTML字符(例如引号)，不必担心破坏表单。
	 * @param string $str
	 * @param string $field_name
	 * @return string
	 */
	public static function form_prep($str = '', $field_name = '')
	{
		static $prepped_fields = array();

		// if the field name is an array we do this recursively
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = self::form_prep($val);
			}

			return $str;
		}

		if ($str === '')
		{
			return '';
		}

		// we've already prepped a field with this name
		// @todo need to figure out a way to namespace this so
		// that we know the *exact* field and not just one with
		// the same name
		if (isset($prepped_fields[$field_name]))
		{
			return $str;
		}

		$str = htmlspecialchars($str);

		// In case htmlspecialchars misses these.
		$str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);

		if ($field_name != '')
		{
			$prepped_fields[$field_name] = $str;
		}

		return $str;
	}
}
/* End of file Html.class.php */
/* Location: ./ePHP/libraries/Html.class.php */