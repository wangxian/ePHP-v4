<?php
/**
 +------------------------------------------------------------------------------
 * 缓存类
 * 可在main.config.php中配置使用FileCache,Memcache,SAEMC驱动。
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2011-1-10
 * @last_modified 2011-8-3
 +------------------------------------------------------------------------------
 */

class Cache
{
	private static $instance;
	public $cache,$expire=0; //0,长期有效

	/**
	 * cache初始化
	 * 获取缓存示例，$cache = Cache::init();
	 * @return object
	 */
	public static function init()
	{
		//!self::$_instance instanceof self
        if (!isset(self::$instance))
        {
        	self::$instance = new self();

        	// 使用哪种方式的cache
        	$cache_driver = C('cache_type') ? C('cache_type').'X' : 'FileCacheX';
        	self::$instance->cache = new $cache_driver;
        }
        return self::$instance;
	}

	/** @ignore */
	public function __get($key) { return $this->get($key);}

	/** @ignore */
	public function __set($key,$value) { return $this->set($key,$value); }

	/**
	 * 获取缓存
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key) { return $this->cache->get($key); }

	/**
	 * 设置缓存
	 * @param string $key
	 * @param mixed $value
	 * @param integer $expire 有效期，0,长期有效。
	 * @return integer 写入数据大小
	 */
	public function set($key, $value, $expire=0)
	{
		//为了兼容$cache->name = $value的方式，接收$Cache::init()->expire = 900设置有效期。
		if( $this->expire ) $expire=$this->expire;
		return $this->cache->set($key,$value,$expire);
	}

	/**
	 * 删除缓存
	 * @param string $key
	 * @return boolean 成功true,失败false
	 */
	public function delete($key)
	{
		return $this->cache->delete($key);
	}

	/**
	 * 删除所有缓存
	 * @return boolean 成功true,失败false
	 */
	public function flush()
	{
		return $this->cache->flush();
	}
}

/**
 +------------------------------------------------------------------------------
 * FileCache 类封装
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2011-8-3
 * @last_modified 2011-8-3
 * @ignore
 +------------------------------------------------------------------------------
 */
class FileCacheX
{
	/**
	 * 获取缓存
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		$filename = $this->_filename($key);
		if( ! file_exists($filename) ) return false;

		$tmp_value = file_get_contents( $filename );
		$expire = (int)substr($tmp_value,13,24);

//		echo time()."<br />\n";
//		echo $expire."<br />\n";
//		echo substr($tmp_value,23);exit;

		if($expire != 0 && time() < $expire)
		{
			return unserialize( substr($tmp_value,23) );
		}
		else return false;
	}

	/**
	 * 设置缓存
	 * @param string $key
	 * @param mixed $value
	 * @param integer $expire 有效期，0,长期有效。
	 * @return integer
	 */
	public function set($key, $value, $expire=0)
	{
		if( $expire != 0) $expire = time() + $expire;
		else $expire = time() * 2; //如果expire为0时，设为长期有效。

		$value = '<?php exit;?>'. $expire . serialize($value);

		// 检查目录可写否
		$cachedir = C("cache_dir");
		if(! is_writeable( $cachedir ) ) show_error('ERROR: '. $cache_dir .' is not writeable!');

		return file_put_contents($this->_filename($key), $value);
	}

	/**
	 * 删除缓存
	 * @param string $key
	 * @return boolean
	 */
	public function delete($key)
	{
		return unlink( $this->_filename($key) );
	}

	/**
	 * 清理所有的缓存
	 * @param string $dir 删除指定目录的缓存
	 * @return void
	 */
	public function flush($dir='')
	{
		$dir = C("cache_dir");
		Dir::deleteDir($dir);
		mkdir($dir,0777);
	}

	/**
	 * 计算缓存名称
	 * @param string $key
	 * @return string
	 * @access private
	 */
	private function _filename($key)
	{
		if(true == ( $dir_pos = strrpos($key ,'/') ) )
		{
			//有子目录，也可能有多层子目录。
			$cache_name = substr($key,$dir_pos+1);

			//缓存目录
			$cache_dir = C('cache_dir') .'/'.substr($key, 0, $dir_pos) . '/';

			// 递归创建文件夹
			if( ! is_dir($cache_dir)) mkdir($cache_dir, 0777, TRUE);
		}
		else
		{
			//无子目录
			$cache_name = $key;
			$cache_dir = C('cache_dir') .'/';
		}

		// 缓存文件名
		return $cache_dir . trim($cache_name) .'^'. md5($cache_name) .'.php';
	}
}

/**
 +------------------------------------------------------------------------------
 * MemCache类
 * <code>
 * 如果选择了，memcache缓存驱动，则需要在APP_PATH.'/conf/memcache.config.php'中配置memcache server信息。
 * 配置格式如：
 * _app/conf/memcache.config.php
 * return array(
 *	array('host'=>'192.168.0.102','port'=>11211,'weight'=>3),
 *	array('host'=>'192.168.0.103','port'=>11211,'weight'=>3),
 *	array('host'=>'192.168.0.106','port'=>11211,'weight'=>4),
 * );
 * </code>
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2011-8-3
 * @last_modified 2011-8-3
 * @ignore
 +------------------------------------------------------------------------------
 */
class MemCacheX
{

	/**

	 */
	private $connection;
	function __construct()
	{
		$this->connection = new MemCache;
		$config = include APP_PATH.'/conf/memcache.config.php';
		foreach ($config as $v)
		{
			$this->addServer($v['host'],$v['port'],$v['weight']);
		}
	}

	/**
	 * 写缓存
	 * @param $key 缓存名称
	 * @param $data 缓存内容
	 * @param $expire 缓存有效期，0,长期有效。
	 * @return integer
	 */
	function set($key,$data,$expire=0)
	{
		return $this->connection->set($key,$data,MEMCACHE_COMPRESSED,$expire);
	}

	/**
	 * 取缓存
	 * @param string $key 缓存名称
	 * @return mixed
	 */
	function get($key)
	{
		return $this->connection->get($key);
	}

	/**
	 * 删除缓存
	 * @param string $key 缓存名称
	 * @return boolean
	 */
	function delete($key)
	{
		return $this->connection->delete($key);
	}

	/**
	 * 添加memcache server
	 * @param string $host 主机名成
	 * @param integer $port 端口
	 * @param integer $weight 权重
	 * @return boolean
	 */
	function addServer($host, $port=11211, $weight=10)
	{
		return $this->connection->addServer($host,$port,true,$weight);
	}

	/**
	 * 刷新memcache的缓存，所有的项目
	 * @return booean
	 */
	public function flush()
	{
		return $this->connection->flush();
	}

	function __destruct()
	{
		$this->connection->close();
	}
}

/**
 +------------------------------------------------------------------------------
 * SAE MemCache类(SAEMC)
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2011-8-3
 * @last_modified 2011-8-3
 * @ignore
 +------------------------------------------------------------------------------
 */
class SAEMCX
{
	private $connection;
	function __construct()
	{
		$this->connection = memcache_init();
	}

	/**
	 * 写缓存
	 * @param $key 缓存名称
	 * @param $data 缓存内容
	 * @param $expire 缓存有效期，0,长期有效
	 * @return integer
	 */
	function set($key,$data,$expire=0)
	{
		return memcache_set($this->connection,$key,$data,MEMCACHE_COMPRESSED,$expire);
	}

	/**
	 * 取缓存
	 * @param string $key 缓存名称
	 * @return mixed
	 */
	function get($key)
	{
		return memcache_get($this->connection,$key);
	}

	/**
	 * 删除缓存
	 * @param string $key 缓存名称
	 * @return boolean
	 */
	function delete($key)
	{
		return memcache_delete($this->connection,$key);
	}

	/**
	 * 添加memcache server,SAE MEMCACHE不支持添加服务器
	 * @param string $host 主机名成
	 * @param int $port 端口
	 * @param int $weight 权重
	 * @return boolean
	 */
	function addServer($host, $port=11211, $weight=10)
	{
		return false;
	}

	/**
	 * 刷新memcache的缓存，所有的项目
	 * @return boolean
	 */
	public function flush()
	{
		return memcache_flush($this->connection);
	}

	function __destruct()
	{
		memcache_close($this->connection);
	}
}

/* End of file Cache.class.php */
/* Location: ./_framework/libraries/Cache.class.php */