<?php
 /**
 +------------------------------------------------------------------------------
 * 表单验证类
 * 使用示例
 * <code>
 * $data = array(
 * 	'name' => 'wx',
 * 	'password'  => '111',
 * 	'nickname' => '',
 * 	'age'  => 41
 * );
 *
 * // 关于message，如果规则验证失败，都显示一种错误，message为string，
 * // 如果要详细区分规则验证失败的原因，则message为array
 * $rules = array(
 * 	'name' => array('required' => true, 'max' => 16, 'min' => 4, 'message'=>array('max'=>'必须小于16位','min'=>'必须大于4位')),
 * 	'password'  => array('required' => true, 'type' => 'string', 'range' => array(6, 16)),
 * 	'nickname' => array('required' => true,'range' => array(5, 16)),
 * 	'age'  => array('type' => 'int', 'range' => array(10,40), 'message' => '年龄范围不符合。')
 * );
 *
 * dump($this->validate->check($data, $rules, true));
 * dump($this->validate->error());
 * </code>
 +------------------------------------------------------------------------------
 * @version 3.1
 * @author WangXian
 * @email wo#wangxian.me
 * @package  libraries
 * @creation_date 2011-1-16 下午02:13:06
 * @last_modified 2011-06-04 22:44:54
 +------------------------------------------------------------------------------
 */

class Validate
{
    private $_error=array();
    private $_message = array(
        'email'    => 'invalid email',
        'required' => 'is empty',
        'max'      => 'variable_above_max',
        'min'      => 'variable_below_min',
        'range'    => 'variable_not_in_rang',
        'ip'       => 'invalid_ip',
        'number'   => 'not_all_numbers',
        'int'      => 'not_int',
        'digit'    => 'not_digit',
        'string'   => 'not_string',
    	'password_confirm'=>'is not the same',
    );


    /**
     * 正则匹配
     *
     * @param string $value
     * @param string $regex
     * @return boolean
     */
    private function match($value, $regex)
    {
        return preg_match($regex, $value);
    }

    /**
     * 最大值
     *
     * @param mixed $value numbernic|string
     * @param number $max
     * @return boolean
     */
    private function max($value, $max)
    {
        if (is_string($value)) $value = strlen($value);
        return $value <= $max;
    }

    /**
     * 最小值
     *
     * @param mixed $value numbernic|string
     * @param number $min
     * @return boolean
     */
    private function min($value, $min)
    {
        if (is_string($value)) $value = strlen($value);
        return $value >= $min;
    }

    /**
     * 在x范围内
     *
     * @param mixed $value numbernic|string
     * @param array $range 范围
     * @return boolean
     */
    private function range($value, $range)
    {
        if (is_string($value)) $value = strlen($value);
        return $value >= $range[0] && $value <= $range[1];  // 如果是数字，则需要是一个数组,例array(5,22)
    }

    /**
     * 是否是数组
     *
     * @param mixed $value
     * @param array $list
     * @return boolean
     */
    private function in($value, $list)
    {
        return in_array($value, $list);
    }

    /**
     * email校验
     *
     * @param string $email
     * @return boolean
     */
    private function email($email)
    {
        return preg_match('/^[a-z0-9_\-]+(\.[_a-z0-9\-]+)*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$/', $email) ? true : false;
    }

    /**
     * Check if is url
     *
     * @param string $url
     * @return boolean
     */
    private function url($url)
    {
        return preg_match('/^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&amp;]*)?)?(#[a-z][a-z0-9_]*)?$/i', $url) ? true : false;
    }

    /**
     * Check if is ip
     *
     * @param string $ip
     * @return boolean
     */
    private function ip($ip)
    {
        return ((false === ip2long($ip)) || (long2ip(ip2long($ip)) !== $ip)) ? false : true;
    }

    /**
     * Check if is date
     *
     * @param string $date
     * @return boolean
     */
    private function date($date)
    {
        return preg_match('/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/', $date) ? true : false;
    }

    /**
     * Check if is numbers
     *
     * @param mixed $value
     * @return boolean
     */
    private function number($value)
    {
        return is_numeric($value);
    }

    /**
     * Check if is int
     *
     * @param mixed $value
     * @return boolean
     */
    private function int($value)
    {
        return is_int($value);
    }

    /**
     * Check if is digit
     *
     * @param mixed $value
     * @return boolean
     */
    private function digit($value)
    {
        return is_int($value) || ctype_digit($value);
    }

    /**
     * Check if is string
     *
     * @param mixed $value
     * @return boolean
     */
    private function string($value)
    {
        return is_string($value);
    }

    /**
     * Check
     *
     * $rules = array(
     *     'required' => true if required , false for not
     *     'password_confirm' confirm password
     *     'type'     => var type, should be in ('email', 'url', 'ip', 'date', 'number', 'int', 'string')
     *     'regex'    => regex code to match
     *     'func'     => validate function, use the var as arg
     *     'max'      => max number or max length
     *     'min'      => min number or min length
     *     'range'    => range number or range length
     *     'msg'      => error message,can be as an array
     * )
     *
     * @param array $data
     * @param array $rules
     * @param boolean $ignorNotExists 忽略不存在的项,默认不忽略
     * @return boolean
     */
    public function check($data, $rules,$ignorNotExists = false)
    {
        foreach ($rules as $key => $rule)
        {
        	// 设置规则默认值
        	$rule += array('required' => false, 'message' => $this->_message);

        	$message = $rule['message'];
            unset($rule['message']);

        	// 未设置时忽略验证
        	if (!isset($data[$key]) || empty($data[$key]))
        	{
                if (!$ignorNotExists && $rule['required'])
                	$this->_error[$key] = $this->_msg($message,'required');
                continue;
            }

            #循环验证
            foreach ($rule as $rule_type=>$rule_value)
            {
            	//密码验证
            	if($rule_type == 'password_confirm')
            	{
            		if($data[$key] != $data[$rule_value])
            			$this->_error[$key] = $this->_msg($message, $rule_type);;
            		break;
            	}

            	if(! $this->_check($data[$key], $rule_type, $rule_value))
            	{
            		$this->_error[$key] = $this->_msg($message, $rule_type);
            		break; //一个key只要有一个失败则停止。
            	}
            }
        }

        #验证成功or失败
        if ( empty($this->_error) ) return true;
        else return false;
    }

    /**
     * Check value
     *
     * @param mixed $value
     * @param array $rule_type
     * @param mixed $rule_value 规则的值
     * @return mixed string as error, true for OK
     */
    private function _check($value, $rule_type, $rule_value)
    {
    	switch ($rule_type)
    	{
    		case 'required':
    			return !empty($value);break;
    		case 'func':
    			return call_user_func($rule_value, $value);break;
    		case 'regex':
    			return $this->match($value, $rule_value);break;
    		case 'type':
    			return $this->$rule_value($value);break;
    		case 'max':
    		case 'min':
    		case 'range':
    		case 'in':
    			return $this->$rule_type($value,$rule_value);break;
			default:
    			return true;
    	}
    }

    /**
     * Set error message
     *
     * @param array $rule
     * @param string $name
     * @return string
     */
    private function _msg($message, $rule_type)
    {
	    if( is_string($message) ) return $message;
	    else if( isset($message[$rule_type]) ) return $message[$rule_type];
    	else return 'INVALID';
    }

   /**
    * Get error message
    * @return string
    */
    public function error()
    {
    	return $this->_error;
    }
}