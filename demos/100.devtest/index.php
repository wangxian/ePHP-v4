<?php
/**
 +------------------------------------------------------------------------------
 *
 * ephp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * ephp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with ephp.  If not, see <http://www.gnu.org/licenses/>.
 +------------------------------------------------------------------------------
 * @version 3.3
 * @author  WangXian
 * @package ephp
 * @link	 http://code.google.com/p/php-framework-ephp/
 * @E-mail   admin@loopx.cn
 * @creation date 2010-10-17 18:09:17
 * @modified date 2011-07-24 10:48:41
 +------------------------------------------------------------------------------
 */

header('Content-Type:text/html; charset=UTF-8');

#时区设置。 建议在php.ini设置，如果虚拟主机的时区设置不对，可取消注释。
// date_default_timezone_set("PRC");

define("APP_PATH", dirname(__FILE__).'/_app');	#项目路径
define('FW_PATH', '../../ePHP');			#framework路径
include FW_PATH . '/ePHP.php';	#加载框架入口


$app = new app();	#系统实例化及调度开始
$app->run();		#运行程序