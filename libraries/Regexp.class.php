<?php
 /**
 +------------------------------------------------------------------------------
 * 正则表达式应用工具
 * <code>
 *
 * [示例]
 * ------------------- 使用示例  --------
 * echo Regexp::check('email','aaa@aa.com') ? '邮箱地址正确' : '邮箱地址错误';
 * echo Regexp::check('/aaa/','aaabbb') ? '字符串aaa存在' : '不存在';
 *
 * [说明]
 * email    => 是否为有效的Email地址
 * numeric  => 是否为全是数字的字符串(可以是 "0" 开头的数字串)
 * qq       => 腾讯QQ号
 * idCard   => 身份证号码
 * china    => 是否为中文
 * zip      => 邮政编码
 * phone    => 固定电话(区号可有可无)
 * mobile   => 手机号码
 * mobilePhone => 手机和固定电话
 * <code>
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @email wo#wangxian.me
 * @package  libraries
 * @creation_date 2010-10-17
 * @last_modified 2010-12-25 19:18:47
 +------------------------------------------------------------------------------
 */

class Regexp{

    /**
     * 已定义正则或自定义正则检查字符串
     * 使用已有的规则，或自定义正则
     * 已有规则：email\numeric\zip\phone\mobile\mobilePhone\qq\china\qq\china\idcard
     * @param string $regExp :已有的正则类型 或 正则表达式
     * @param string $string :要检查的字符串
     * @return boolean
     */
    static public function check($regExp,$string)
    {
    	$regExpType = array(
	    'email'       => '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([_a-z0-9]+\.)+[a-z]{2,5}$/',
	    'numeric'     => '/^[0-9]+$/',
	    'zip'         => '/^[1-9]\d{5}$/',
	    'phone'       => '/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/',
	    'mobile'      => '/^1\d{10}$/',
	    'mobilePhone' => '/(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,12}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/',
	    'qq'          => '/^[1-9]*[1-9][0-9]*$/',
	    'china'       => '/[\u4e00-\u9fa5]/',
	    'idcard'      => '/\d{15}|\d{18}/',
	    );
        $regExpValue = array_key_exists($regExp,$regExpType) ? $regExpType[$regExp] : $regExp;

        if(substr($regExpValue,0,1) != '/')
        {
        	throw new ephpException('<font color="red">在默认库中 '. $regExp .' 的规则匹配失败，系统使用你的输入作为正则规则，但你输入的正则语法错误。</font> 合法的规则如： /^[0-9]+$/ 请检查后重试！', 1554);
        }
        //dump($regExpValue);
        return preg_match($regExpValue,$string);
    }
}
/* End of file Regexp.class.php */
/* Location: ./ePHP/libraries/Regexp.class.php */