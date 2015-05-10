<?php
/**
 +------------------------------------------------------------------------------
 * 日期时间操作相关
 * <code>
 * //使用示例
 * echo Date::showtime(122121230); //返回 "22分钟前"
 * echo Date::getDate(); //返回当前的日期如 "2008-10-12"
 * echo Date::getDate(1229173896); //1229173896 是指定的时间戳
 * echo Date::getTime(); //返回当前的时间如 "2008-10-12 10:36:48"
 * echo Date::getTime(1229173896); //1229173896 是指定的时间戳
 * echo Date::compareTiem('2006-10-12','2006-10-11'); //比较两个时间
 * echo Date::dateAddDay("2005-10-20",6);// 2005-9-25"+6 = "2005-10-01"
 * echo Date::dateDecDay("2005-10-20",10); //"2005-10-20"-10 = "2005-10-10"
 * echo Date::dateDiff('2005-10-20','2005-10-10');//"2005-10-20"-"2005-10-10"=10
 * echo Date::timeDiff('2005-10-20 10:00:00','2005-10-20  08:00:00'); //2小时
 * </code>
 +------------------------------------------------------------------------------
 * @version 3.2
 * @author WangXian
 * @email wo#wangxian.me
 * @package libraries
 * @creation_date 2010-10-17
 * @last_modified 2011-06-04
 +------------------------------------------------------------------------------
 */

class Date
{
	/**
	 * 人性化地显示时间，新浪微博的实现
	 * @param int|string $time 自动判断是Unix时间戳，还是一个格式化后的时间字符串
	 * @return string
	 */
	public static function showtime($time)
	{
		if(! is_numeric($time) ) $time=strtotime($time);
		$timej = time() - $time;
		if($timej < 172800)
		{
			if($timej>86400)
			{
				return '昨天';
			}
			else if($timej > 3600)
			{
				return floor($timej/3600)."小时前";
			}
			else if($timej > 60)
			{
				return floor($timej/60)."分钟前";
			}
			else
			{
				return "刚刚";
			}
		}
		else
		{
			return date('m-d H:i', $time);
		}
	}

    /**
     * 得到当前日期
     * @param string $fmt :日期格式
     * @param int $time :时间，默认为当前时间
     * @return string
     */
    static public function getDate($time=null,$fmt='Y-m-d')
    {
        $times = $time?$time:time();
        return date($fmt,$times);
    }

    /**
     * 得到当前日期时间
     * @param string $fmt :日期格式
     * @param int $time :时间，默认为当前时间
     * @return string
     */
    static public function getTime($time=null,$fmt='Y-m-d H:i:s')
    {
        return self::getDate($time,$fmt);
    }

    /**
     * 计算日期天数差
     * 例子:"2005-10-20"-"2005-10-10"=10
     * @param string $Date1 :如 "2005-10-20"
     * @param string $Date2 :如 "2005-10-10"
     * @return int
     */
    static public function dateDiff($Date1,$Date2)
    {
    	$DateList1=explode("-",$Date1);
    	$DateList2=explode("-",$Date2);
    	$d1=mktime(0,0,0,$DateList1[1],$DateList1[2],$DateList1[0]);
    	$d2=mktime(0,0,0,$DateList2[1],$DateList2[2],$DateList2[0]);
    	$Days=round(($d1-$d2)/3600/24);
    	return $Days;
    }

    /**
     * 计算日期加天数后的日期
     * @param string $date :如 "2005-10-20"
     * @param int $day  :如 6
     * @return string
     * 例子:2005-9-25"+6 = "2005-10-01"
     */
    static public function dateAddDay($date,$day)
    {
    	$daystr = "+$day day";
    	$dateday = date("Y-m-d",strtotime($daystr,strtotime($date)));
    	return $dateday;
    }

    /**
     * 计算日期加天数后的日期
     * @param string $date :如 "2005-10-20"
     * @param int $day  :如 10
     * @return string
     * 例子:"2005-10-20"-10 = "2005-10-10'
     */
    static public function dateDecDay($date,$day)
    {
    	$daystr="-$day day";
    	$dateday=date("Y-m-d",strtotime($daystr,strtotime($date)));
    	return $dateday;
    }

    /**
     * 比较两个时间
     * @param string $timeA :格式如 "2006-10-12" 或 "2006-10-12 12:30" 或 "2006-10-12 12:30:50"
     * @param string $timeB :同上
     * @return int   0:$timeA = $timeB
     *              -1:$timeA < $timeB
     *               1:$timeA > $timeB
     */
    static public function compareTiem($timeA,$timeB)
    {
    	$a=strtotime($timeA);
    	$b=strtotime($timeB);
    	if($a > $b)        return 1;
    	else if($a == $b)  return 0;
    	else               return -1;
    }

    /**
     * 计算时间a减去时间b的差值
     * @param string $timeA :格式如 "2006-10-12" 或 "2006-10-12 12:30" 或 "2006-10-12 12:30:50"
     * @param string $timeB :同上
     * @return float 实数的小时,如"2.3333333333333"小时
     */
    static public function timeDiff($timeA,$timeB)
    {
    	$a=strtotime($timeA);
    	$b=strtotime($timeB);
    	$c=$a-$b;
    	$c=$c / 3600;
    	return $c;
    }

}
/* End of file Date.class.php */
/* Location: ./ePHP/libraries/Date.class.php */