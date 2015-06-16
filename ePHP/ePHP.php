<?php
/**
 * framework 入口文件
 *
 * @version 4.0
 * @author WangXian
 * @email wo#wangxian.me
 * @package core
 * @creation_date 2010-3-10 23:15:26
 * @last_modified 2015-5-10
 */

// sys init time
$run_start_time    = microtime(1);
// db query cout
$run_dbquery_count = 0;

/** @ignore */
function error_handler($errno, $errstr, $errfile, $errline)
{
    if (!C('show_errors')) { return true; }
    throw new ephpException($errstr, $errno, array('errfile' => $errfile, 'errline' => $errline));
}

function run_info($output = true)
{
    $opstring = 'Total time:' . (microtime(1) - $GLOBALS['run_start_time']) * 1000 . 'ms DB Query:' . $GLOBALS['run_dbquery_count'];if ($output)
    {
        echo $opstring;
    }
    else
    {
        return $opstring;
    }
}

/**
 * 格式化输出，并停止
 *
 * @param $vars
 * @return void
 */
function dumpdie($vars) { dump($vars);exit; }

/**
 * 格式化print_r输出，并停止
 *
 * @param $vars
 * @return void
 */
function printdie($vars) { dump($vars, null, 0);exit; }

/**
 * 格式化输出
 * <code>
 * 1.浏览器友好的变量输出，$vars支持任何变量，echo表示是否需要输出，如果为否，则返回要显示的字符串。
 * 2.$vardump表示是否输出详细信息，如果为否，使用print_r输出，如果为是，使用var_dump输出。
 * 3.dump函数还支持xdebug扩展
 * </code>
 * @param string  $vars 要打印都数据
 * @param string  $label 标签
 * @param boolean $vardump 表示是否输出详细信息
 * @return void
 */
function dump($vars, $label = null, $vardump = true)
{
    $label = !$label ? '' : "<h3>{$label} :</h3><hr />";
    if ($vardump)
    {
        ob_start();
        var_dump($vars);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug'))
        {
            $output = preg_replace('/\]\=\>\n(\s+)/m', "] => ", $output);
            $output = $label . '<pre>' . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
        else
        {
            $output = $label . $output;
        }

    }
    else
    {
        $output = print_r($vars, true);
        $output = "{$label}<pre>" . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
    }
    echo $output;
}

/**
 * 读取 or 设置配置文件的值
 * @param string $name 获取配置名称, 缺省返回所有配置，支持用'.'读取或设置二维数组
 * @param string $config_name 从哪个配置文件中从获取，默认main
 * @param mixed  $value 要设置的value
 */
function C($name = '', $config_name = 'main', $value = null)
{
    static $_config = array();
    if ($value === null)
    {
        // 获取值
        // 加载其他配制文件
        if ($config_name != 'main' && !isset($_config[$config_name]))
        {
            $filename = APP_PATH . '/conf/' . $config_name . '.config.php';
            if (file_exists($filename))
            {
                $_config[$config_name] = include $filename;
            }
            else
            {
                show_error("配置文件：{$filename} 不存在！");
            }

        }

        // 返回需要value
        if ($name == '')
        {
            return $_config[$config_name];
        }
        else if (array_key_exists($name, $_config[$config_name]))
        {
            return $_config[$config_name][$name];
        }
        else if (strpos($name, '.'))
        {
            $array = explode('.', $name);
            return isset($_config[$config_name][$array[0]][$array[1]]) ? $_config[$config_name][$array[0]][$array[1]] : false;
        }
        else
        {
            return false;
        }

    }
    else if (is_array($value))
    {
        // 初始化设置，批量导入
        $_config[$config_name] = $value;
        return true;
    }
    else
    {
        // 单独改变一个配置的值
        if (!strpos($name, '.'))
        {
            $_config[$config_name][$name] = $value;
        }
        else
        {
            // 支持二维数组
            $array                                       = explode('.', $name);
            $_config[$config_name][$array[0]][$array[1]] = $value;
        }
        return true;
    }
}

/** @ignore */
function __autoload($classname)
{
    // echo $classname.'<hr />';
    // 加载控制器
    if (substr($classname, -10) == 'Controller')
    {
        if (file_exists(APP_PATH . '/controllers/' . $classname . '.php'))
        {
            include APP_PATH . '/controllers/' . $classname . '.php';
        }
        else if (file_exists($filename = APP_PATH . '/views/' . $_GET['controller'] . '/' . $_GET['action'] . '.tpl.php'))
        {
            include $filename;exit;
        }
        else if (!C('debug'))
        {
            show_404();
        }
        else
        {
            show_error($classname . '没有定义，可能原因controllers/' . $classname . '.php不存在！');
        }

    }
    // 加载用户模型
    elseif (substr($classname, -5) == 'Model')
    {
        if (file_exists(APP_PATH . '/models/' . $classname . '.php'))
        {
            include APP_PATH . '/models/' . $classname . '.php';
        }
        else
        {
            show_error('模型：' . APP_PATH . '/models/' . $classname . '.php 文件不存在!');
        }

    }
    else
    {
        // 加载第三方库，位置在exts/下
        $system_class = array(
            'model', 'modelMS', 'Cookie', 'Session', 'Cache', 'ephpException', 'modelMongodb', 'Request', 'Email', 'Loader', 'Widget', 'MultiView',
            'Http', 'Pinyin', 'Html', 'Validate', 'Regexp', 'Debug', 'Link', 'Xml', 'Date', 'Socket',
            'Image', 'Uploadfile', 'Dir', 'Encrypt', 'Func',
        );
        if (in_array($classname, $system_class))
        {
            include FW_PATH . '/libraries/' . $classname . '.class.php';
        }
        else
        {
            $classname = str_replace('_', '/', $classname);
            if (file_exists(APP_PATH . '/exts/' . $classname . '.class.php'))
            {
                include APP_PATH . '/exts/' . $classname . '.class.php';
            }
            else
            {
                show_error('扩展类：' . APP_PATH . '/exts/' . $classname . '.class.php 文件不存在!');
            }

        }
    }
}

/**
 * 创建model模型
 * 相当于 new xxModel()
 *
 * @param string $model_name 模型名
 * @param string $db_config_name 要连接的数据库配制名，默认为空
 * @return object
 */
function M($model_name, $db_config_name = '')
{
    $model_name = $model_name . 'Model';
    if (empty($GLOBALS['ePHP']['M_QM'][$model_name]))
    {
        $GLOBALS['ePHP']['M_QM'][$model_name] = $obj = new $model_name();
        if ($db_config_name != '')
        {
            $obj->dbconfig($db_config_name);
        }

    }
    else
    {
        $obj = $GLOBALS['ePHP']['M_QM'][$model_name];
    }

    return $obj;
}

/**
 * 快速实例化模型对象 (不需要创建model文件)
 *
 * @param string $model_name 模型名
 * @param string $db_config 要连接的数据库配制，默认default
 * @return object
 */
function QM($model_name, $db_config_name = 'default')
{
    if (empty($GLOBALS['ePHP']['M_QM'][$model_name . 'Model']))
    {
        $GLOBALS['ePHP']['M_QM'][$model_name . 'Model'] = $obj = new model;
        if ($db_config_name != 'default')
        {
            $obj->dbconfig($db_config_name);
        }

        $obj->table(C($db_config_name . '.tb_prefix', 'db') . $model_name);
    }
    else
    {
        $obj = $GLOBALS['ePHP']['M_QM'][$model_name . 'Model'];
    }

    return $obj;
}

/**
 * write日志
 *
 * @ignore
 * @param string $name 自动加上{2010-09-22.log}的日期后缀
 * @param string $value
 */
function wlog($name, $value)
{
    // 在SAE平台下，不写文件日志
    if (defined('SAE_ACCESSKEY'))
    {
        return 0;
    }

    $logdir = C('log_dir') . '/';
    if (!is_writeable($logdir))
    {
        exit('ERROR: Log directory {' . $logdir . '} is not writeable, check the directory permissions!');
    }

    error_log('[' . date('H:i:s') . ']' . $value . "\n", 3, $logdir . $name . date('Y-m-d') . '.log');
}

/**
 * url生成器，支持PATH_INFO\GET\SEO\NODIR类型的url
 * 例子:U('index/help', array('id'=>25)) 或 U('index/help/id/25');
 * 那么可能生成：http://host/project/index.php/index/help/id/25.html
 *
 * @param string $base 控制器和方法
 * @param array  $param_arr url其他参数,接受参数array或string
 * @return string url 生成后的url字符串
 */
function U($base, $param_arr = array())
{
    // if( function_exists('MY_U') ) return MY_U($base,$others_url);// 重载系统的U方法
    $urlx     = '';
    $url_type = C('url_type');
    if ($url_type == 'SEO' || $url_type == 'PATH_INFO')
    {
        foreach ($param_arr as $k => $v)
        {
            if ($v !== '')
            {
                $urlx .= '/' . $k . '/' . $v;
            }
        }
        return URL . '/' . $base . $urlx . C('html_url_suffix');
    }
    else if ($url_type == 'NODIR')
    {
        $base = str_replace('/', '-', $base);
        foreach ($param_arr as $k => $v)
        {
            if ($v !== '')
            {
                $urlx .= '-' . $k . '-' . $v;
            }
        }
        return URL . '/' . $base . $urlx . C('html_url_suffix');
    }
    else
    {
        // GET方式的url
        $tarr = explode('/', $base);

        // 第一个参数，出控制器和action外，可能包含其他的参数。
        foreach ($tarr as $k => $v)
        {
            if ($k == 0) {$urlx .= '?controller=' . $v; }
            elseif ($k == 1) {$urlx .= '&action=' . $v; }
            elseif ($k % 2 == 0) {$urlx .= "&{$v}="; }
            elseif ($k % 2 == 1) {$urlx .= $v; }
        }

        // 第二个额外参数
        if (!empty($param_arr)) {$urlx .= '&' . http_build_query($param_arr); }
        return URL . $urlx;
    }
}

// 显示404页面
function show_404()
{
    // header('HTTP/1.1 404 Not Found');
    $tpl = C('tpl_404');
    if (!$tpl)
    {
        include FW_PATH . '/tpl/404.tpl.php';
    }
    else
    {
        include APP_PATH . '/views/public/' . $tpl;
    }

    exit;
}

/**
 * 操作失败
 *
 * @param string  $message 错误消息
 * @param string  $url     自动回跳的url
 * @param integer $wait    自动回跳等待时间，默认6s
 */
function show_error($message, $url = '', $wait = 6)
{
    // header('HTTP/1.1 500 Internal Server Error');
    if ($url === '' && isset($_SERVER['HTTP_REFERER']))
    {
        $url = $_SERVER['HTTP_REFERER'];
    }

    if (C('exception_log'))
    {
        wlog('ExceptionLog', $message);
    }

    $tpl = C('tpl_error');
    if (!$tpl)
    {
        include FW_PATH . '/tpl/error.tpl.php';
    }
    else
    {
        include APP_PATH . '/views/public/' . $tpl;
    }

    exit;
}

/**
 * 操作成功
 *
 * @param string  $message 提示信息
 * @param string  $url     自动回跳的url
 * @param integer $wait    自动回跳等待时间，默认6s
 */
function show_success($message, $url = '', $wait = 6)
{
    if ($url === '' && isset($_SERVER['HTTP_REFERER']))
    {
        $url = $_SERVER['HTTP_REFERER'];
    }

    $tpl = C('tpl_success');
    if (!$tpl)
    {
        include FW_PATH . '/tpl/success.tpl.php';
    }
    else
    {
        include APP_PATH . '/views/public/' . $tpl;
    }

    exit;
}

/**
 * 永久性质的跳转
 *
 * @param string  $url     要跳转的url
 * @param integer $wait    跳转等待时间，默认0s
 * @param string  $message 提示信息
 */
function R($url, $wait = 0, $message = '')
{
    // header("HTTP/1.1 301 Moved Permanently");
    if (empty($message))
    {
        $message = "系统将在{$wait}秒之后自动跳转到{$url}！";
    }

    if (!headers_sent() && (0 === $wait))
    {
        // redirect
        header("Content-Type:text/html; charset=UTF-8");
        header("Location: {$url}");
        exit;
    }
    else
    {
        // html refresh
        // header("refresh:{$wait};url={$url}"); // 直接发送header头。
        include FW_PATH . '/tpl/redirect.tpl.php';
        exit;
    }
}

/**
 * 获取$_GET中的值
 * 如果不存在返回$default的值,无参数返回$_GET
 *
 * @param string $key
 * @param string $default
 * @param string $callback 回调函数，比如 intval, floatval
 * @return mixed
 */
function getv($key=0, $default='', $callback='')
{
    if(! $key) return $_GET;
    return isset($_GET[$key]) ?  (empty($callback) ? trim($_GET[$key]) : call_user_func($callback, trim($_GET[$key]))) : $default;
}

/**
 * 获取url中的片段
 * 如 url: /user/info/12.html,getp(3)的值为12
 *
 * @param integer $pos 获取url片段的位置($pos>=1)
 * @param string $default
 * @param string $callback 回调函数，比如 intval, floatval
 * @return mixed
 */
function getp($pos, $default='', $callback='')
{
    static $url_part = array();
    if( empty($url_part) )
    {
        // only first time
        $posi = strpos($_SERVER['REQUEST_URI'], '?');
        $url = $posi ? substr($_SERVER['REQUEST_URI'], 1, $posi) : substr($_SERVER['REQUEST_URI'], 1);
        if(!empty($url))
        {
            $url_part = explode('/', $url);
        }
        else $url_part = array('index','index');
    }
    $pos = $pos - 1;
    return isset($url_part[$pos]) ? (empty($callback) ? trim($url_part[$pos]) : call_user_func($callback, trim($url_part[$pos])) ) : $default;
}

/**
 * 获取$_POST中的值
 * 如果不存在返回$default的值,无参数返回$_POST
 *
 * @param string $key
 * @param string $default
 * @param string $callback 回调函数，比如 intval, floatval
 * @return mixed
 */
function postv($key=0, $default='', $callback='')
{
    if(! $key) return $_POST;
    return isset($_POST[$key]) ? (empty($callback) ? trim($_POST[$key]) : call_user_func($callback, trim($_POST[$key])) )  : $default;
}

/**
 * 获取$_REQUEST中的值
 * 如果不存在返回$default的值,无参数返回$_REQUEST
 *
 * @param string $key
 * @param string $default
 * @param string $callback 回调函数，比如 intval, floatval
 * @return mixed
 */
function requestv($key=0, $default='', $callback='')
{
    if(! $key) return $_REQUEST;
    return isset($_REQUEST[$key]) ? ( empty($callback) ? trim($_REQUEST[$key]) : call_user_func($callback, trim($_REQUEST[$key]))) : $default;
}

/**
 * 调度类
 * @author WangXian
 * @package core
 * @version 4.0
 */
class app
{
    public function __construct()
    {
        $path_info = $this->_path_info();
        if (!empty($path_info))
        {
            $splits = explode('/', trim($path_info, '/'));
        }
        else
        {
            $splits = '';
        }

        $_GET['controller'] = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        $_GET['action']     = isset($_GET['action']) ? $_GET['action'] : 'index';

        if (!empty($splits[0]))
        {
            // 在保证安全的前提下，进行兼容PATH_INFO和GET方式，如果是url混合方式，则以path_info为主
            $_GET['controller'] = $splits[0];
            $_GET['action']     = isset($splits[1]) ? $splits[1] : 'index';
        }

        $ucount = count($splits);
        for ($i = 2; $i < $ucount; $i += 2)
        {
            if (isset($splits[$i]) && isset($splits[$i + 1]))
            {
                $_GET[$splits[$i]] = $splits[$i + 1];
            }

        }

        if (is_array($_GET))
        {
            $_REQUEST = array_merge($_GET, $_REQUEST);
        }

    }

    // run application
    public function run()
    {
        try
        {
            $controller_name = $_GET['controller'] . 'Controller';
            $action_name     = $_GET['action'] . 'Action';

            if (method_exists($controller_name, $action_name))
            {
                $c_init = new $controller_name;
                call_user_func(array($c_init, $action_name));
            }
            else if (!C('show_errors'))
            {
                show_404();
            }
            else
            {
                show_error("在控制器 <b>{$controller_name}</b> 中 <b>{$action_name}()</b> 未定义！ ");
            }

        }
        catch (ephpException $e)
        {
            echo $e;
        }
    }

    // 获取PAHT_INFO，没有则返回空字符串
    private function _path_info()
    {
        $path_info = '';
        if (!empty($_SERVER['PATH_INFO'])) // 避免触发E_NOTICE错误；
        {
            $path_info = $_SERVER['PATH_INFO'];

            //  无目录的user-info-15.html
            $nodir = C('url_type');
            if ($nodir == 'NODIR')
            {
                $path_info = str_replace('-', '/', $path_info);
            }

            //  是否开启了路由
            if (C('url_router'))
            {
                //  获取url上的第一个参数，用于对象router中的路由规则；
                $first_param = substr($path_info, 1, strpos($path_info, '/', 1) - 1);

                //  请确认router.config.php存在
                $config = include APP_PATH . '/conf/router.config.php';

                if (isset($config[$first_param])) // 避免触发E_NOTICE错误；
                {
                    foreach ($config[$first_param] as $v)
                    {
                        $count = 0; // 记录成功替换的个数

                        //  如果是NODIR方式的URL，正则要替换
                        if ($nodir == 'NODIR')
                        {
                            $v[0] = str_replace('-', '/', $v[0]);
                        }

                        $path_info = preg_replace($v[0], $v[1], $path_info, -1, $count);

                        //  只要匹配上一个，则停止匹配，故在router.config.php从上到下有优先权。
                        if ($count > 0)
                        {
                            break;
                        }

                    }
                }
            }

            // 去掉扩展名
            $html_url_subffix = C('html_url_suffix');
            if ($html_url_subffix && TRUE == ($url_suffix_pos = strrpos($path_info, $html_url_subffix)))
            {
                $path_info = substr($path_info, 0, $url_suffix_pos);
            }

        }
        return $path_info;
    }
}

/**
 * 父控制器
 * <pre>
 * - 普通控制器不一定要集成controller
 * - controller主要是为了在需要的时候，实例化一些类，包括：view\request\model\cache
 * </pre>
 *
 * @author WangXian
 * @package core
 * @version 4.0
 */
class controller
{
    /**
     * @ignore
     *
     * @param string $key
     */
    public function __get($key)
    {
        // echo $key.'<hr />';
        switch ($key)
        {
            case 'view':return $this->view = new view;
                break;
            case 'request':
                include FW_PATH . '/libraries/Request.class.php';
                return $this->request = new Request;
                break;
            case substr($key, 0, 5) == 'model':
                if ($key == 'model')
                {
                    return $this->model = new model;
                }
                else
                {
                    $model_name = substr($key, 6) . 'Model';

                    // import current model
                    include APP_PATH . "/models/{$model_name}.php";
                    return $this->$key = new $model_name;
                }
                break;
            case 'cache':
                include FW_PATH . '/libraries/Cache.class.php';
                return $this->cache = Cache::init();
            default:show_error("Undefined property {$key}");

        }
    }
}

/**
 * 视图类
 *
 * @author WangXian
 * @package core
 * @version 4.0
 */
class view
{
    protected $vars;
    protected $_current = array(); //block current stack
    protected $_layout  = array();
    protected $_instack = array();

    /**
     * 补全视图名
     *
     * @param string $file
     * @return string $filename
     */
    protected function __filename($file)
    {
        if (empty($file))
        {
            $file = $_GET['controller'] . '/' . $_GET['action'] . '.tpl.php';
        }
        else if (!strpos($file, '.php'))
        {
            $file = $file . '.tpl.php';
        }

        return $file;
    }

    /**
     * 视图渲染
     * @param string $file '控制器名/操作名.tpl.php',你可以省略‘.tpl.php’
     * @param integer $expire 视图有效期，单位秒,默认-1，当$expire>0缓存，=0长期缓存，<0不缓存
     * @package boolean $layout_block 使用布局模版否
     */
    public function render($file = '', $expire = -1, $layout_block = false)
    {
        if ($expire < 0) { $this->_include($file, null, $layout_block, false); }
        else
        {
            $cache = Cache::init();
            if (false == ($content = $cache->get('html/' . $file)))
            {
                $content = str_replace(array('<!--{', '}-->'), array('<?php ', ' ?>'), $this->_include($file, null, $layout_block, true));
                $cache->set('html/' . $file, $content, $expire);
            }
            echo eval('?>' . $content . '<?');
        }
    }

    /**
     * 判断视图是否已缓存
     *
     * @param string $file 视图名
     * @return boolean
     */
    public function is_cached($file = '')
    {
        if (Cache::init()->get('html/' . $file)) { return true; }
        else { return false; }
    }

    /**
     * 渲染视图, render() 别名
     *
     * @param string $file
     * @param integer $expire
     */
    public function display($file = '', $expire = -1)
    {
        $this->render($file, $expire);
    }

    /**
     * 模板变量赋值
     * @param string $name 变量名称
     * @param mixed  $value
     */
    public function assign($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * 布局模版
     *
     * @param string $file 视图名
     * @param integer $expire 有效期
     */
    public function layout($file = '', $expire = -1)
    {
        $this->render($file, $expire, true);
    }

    /**
     * 视图继承
     * @param string $file
     */
    protected function _extends($file)
    {
        $this->_include($file);
    }

    /**
     * 开始定义一个新区块
     *
     * @param string $tpl_name
     */
    protected function _block($block_name)
    {
        $this->_current[] = $block_name;
        ob_start();
    }

    /**
     * 区块结束
     */
    protected function _endblock()
    {
        $content  = ob_get_clean();
        $_current = array_pop($this->_current);

        if (!isset($this->_layout[$_current]))
        {
            echo "<!--{layout_block_{$_current}}-->";
        }

        $this->_instack[$_current] = $content;
        if (empty($this->_current))
        {
            // 延时反转得到正序的栈结构
            if (count($this->_instack) > 1)
            {
                $this->_instack = array_reverse($this->_instack);
            }

            $this->_layout  = array_merge($this->_layout, $this->_instack);
            $this->_instack = array();
        }
    }

    /**
     * 引用视图 或 视图片段
     *
     * @param string $file 变量名
     * @param string $layout_block 是否渲染布局模版
     * @param boolean $layout_block 使用布局模版否
     * @param boolean $return 返回模版内容 or 直接输出
     */
    public function _include($file, $__vars = null, $layout_block = false, $return = false)
    {
        if (is_array($this->vars))
        {
            extract($this->vars);
        }

        if (is_array($__vars))
        {
            extract($__vars);
        }

        if ($layout_block)
        {
            ob_start();
            include APP_PATH . '/views/' . $this->__filename($file);
            $content = ob_get_clean();
            //echo $content;print_r($this->_layout);exit;

            if ($this->_layout)
            {
                foreach ($this->_layout as $k => $v)
                {
                    $content = str_replace("<!--{layout_block_{$k}}-->", $v, $content);
                }

            }

            // 是否返回
            if ($return) { return $content; }
            else { echo $content; }

        }
        else if ($return)
        {
            ob_start();
            include APP_PATH . '/views/' . $this->__filename($file);
            return ob_get_clean();
        }
        else
        {
            include APP_PATH . '/views/' . $this->__filename($file);
        }

    }
}

///////////////////////////////////////////////////////////////////////////////////
// 运行环境初始化
///////////////////////////////////////////////////////////////////////////////////
// 设置error异常处理函数
set_error_handler("error_handler");

// 默认系统配置
$config = array
(
    'debug'           => false,
    'access_log'      => false,
    'exception_log'   => false,
    'sql_log'         => false,
    'show_errors'     => true,
    'html_url_suffix' => '',
    'url_router'      => false,
    'url_type'        => 'PATH_INFO',
    'dbdriver'        => 'mysqli',
    'static_dir'      => '',
    'cache_type'      => 'FileCache',
);

// 导入app配置
if (file_exists(APP_PATH . '/conf/main.config.php'))
{
    $config_main = include APP_PATH . '/conf/main.config.php';
    $config      = $config_main + $config;

    // 自定义缓存和日志目录
    if (empty($config['log_dir']))
        {
        $config['log_dir'] = APP_PATH . '/runtime/logs';
    }

    if (empty($config['cache_dir']))
        {
        $config['cache_dir'] = APP_PATH . '/runtime/cache';
    }

    // 如果debug为true，则下面四项强制为true
    if ($config['debug'])
        {
        $config['access_log']    = true;
        $config['exception_log'] = true;
        $config['sql_log']       = true;
        $config['show_errors']   = true;
    }
}
C('', 'main', $config);

$base_url = (($sdir = dirname($_SERVER['SCRIPT_NAME'])) == '/' || $sdir == '\\') ? '' : $sdir;

// 设置资源目录的位置
// 如果没有配置static_dir，则采用当前目下的assets/作为资源目录
if ($config['static_dir'] == '')
{
    $config['static_dir'] = $base_url . '/assets';
}

define('STATIC_DIR', $config['static_dir']);

if ($config['url_type'] == 'GET' || $config['url_type'] == 'PATH_INFO')
{
    // 定义url常量
    define("URL", $_SERVER['SCRIPT_NAME']);
}
else
{
    // uri带index.php
    define("URL", $base_url);
}
// uri不带index.php

// 显示系统错误
if ($config['show_errors'])
{
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}
else
{
    ini_set('display_errors', 'Off');
    error_reporting(0);
}

// 记录系统访问日志
if ($config['access_log'])
    {
    $str = "\nREQUEST_URI:http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n";
    $str .= 'REMOTE_ADDR:' . $_SERVER['REMOTE_ADDR'] . "\n";
    $str .= isset($_SERVER['HTTP_USER_AGENT']) ? 'HTTP_USER_AGENT:' . $_SERVER['HTTP_USER_AGENT'] . "\n" : '';
    $str .= '------------------------------';
    wlog('AccessLog', $str);
}
