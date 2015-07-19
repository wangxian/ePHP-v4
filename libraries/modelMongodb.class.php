<?php
/**
 +------------------------------------------------------------------------------
 * mongodb model for ePHP
 +------------------------------------------------------------------------------
 * @version 4.2
 * @author  WangXian
 * @package core
 * @creation_date 2011-12-14
 * @last_modified 2011-12-14
 +------------------------------------------------------------------------------
 */

class modelMongodb
{
	protected $table_name	= '';
	protected $sql			= array();

	protected $field		= array();
	protected $limit 		= '';
	protected $skip 		= '';
	protected $orderby 		= array();
	protected $where		= array();
	protected $data			= array();

	public  $db_config_name = 'default';

	protected $db = NULL;
	static protected $_db_handle;

	/**
	 * 清理使用过的变量
	 * @access protected
	 * @return void
	 */
	protected function _clear_var()
	{
		$this->field 	= array();
		$this->limit 	= '';
		$this->skip 	= '';
		$this->where 	= array();
		$this->orderby 	= array();
		$this->data		= array();
	}

	protected function conn()
	{
		if(! isset(self::$_db_handle[$this->db_config_name]) )
		{
			if(false == ( $iconfig = C($this->db_config_name, 'db') ) ) show_error('数据库配制文件db.config.php中 '. $this->db_config_name .'  未设置。');

			$DSN = 'mongodb://'; // exp: mongodb://192.168.1.222
			if($iconfig['user']) $DSN .= $iconfig['user'];
			if($iconfig['password']) $DSN .= ':'.$iconfig['password'];

			if($DSN != 'mongodb://') $DSN .= '@';
			if($iconfig['host']) $DSN .= $iconfig['host'];

			if( !empty($iconfig['port']) ) $DSN .= ':'.$iconfig['port'];

			$mongoDB = new Mongo($DSN);
			self::$_db_handle[$this->db_config_name] = $this->db = $mongoDB->selectDB($iconfig['dbname']);
		}
		else $this->db = self::$_db_handle[$this->db_config_name];
		return $this->db;
	}

	/**
	 * 查询的表名
	 * @param  string $table_name 表名
	 * @return string $this
	 */
	public function table($table_name)
	{
		$this->table_name = $table_name;
		return $this;
	}

	/**
	 * model::table()方法的别名，查询的表名
	 * @param string $table_name
	 * @return $this
	 */
	public function from($table_name)
	{ return $this->table($table_name); }

	/**
	 * 指定使用db.config.php哪个数据库配制帐号，例如default、primary
	 * @param string $db_config_name
	 * @return object $this
	 */
	public function dbconfig($db_config_name)
	{
		$this->db_config_name = $db_config_name;
		return $this;
	}

	/**
	 * 指定数据缓存时间
	 * @param integer $expire 缓存有效期，0，永久缓存
	 */
	public function cache($expire)
	{
		$this->expire = $expire;
		return $this;
	}

	/**
	 * 要查询的字段
	 * @param  string $field 要查询的字段列表
	 * @return object $this
	 */
	public function select($field)
	{
		$this->field = $field;
		return $this;
	}

	/**
	 * select()的别名
	 * @param string $field 要查询的字段列表
	 * @return object $this
	 */
	public function field($field)
	{ return $this->select($field); }

	/**
	 * 查询限制
	 * @param intger $limit
	 * @param integer $skip
	 * @return object $this
	 */
	public function limit($skip,$limit)
	{
		$this->limit = $limit;
		$this->skip = $skip;
		return $this;
	}


	/**
	 * 写入数据库的内容(for insert|update)
	 * @param array $data
	 * @return object $this
	 */
	public function set($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * model::set()方法的别名
	 * @param array $data
	 * @return object $this
	 */
	public function data($data,$noquote=array())
	{ return $this->set($data,$noquote); }

	/**
	 * where条件
	 * @param  array $where
	 * @return object $this
	 */
	public function where($where,$noquote=array())
	{
		$this->where = $where;
		return $this;
	}

	/**
	 * 对查询结果排序
	 * @param  array $orderby
	 * @return object $this
	 */
	public function orderby($orderby)
	{
		$this->orderby = $orderby;
		return $this;
	}

	/**
	 * mongodb 分组查询 detail http://us.php.net/manual/en/mongocollection.group.php
	 * @param minxed $keys Fields to group by.
	 * @param array $initial Initial value of the aggregation counter object.
	 * @param string MongoCode $reduce A function that takes two arguments
	 * @param array $options Optional parameters to the group command. Valid options include:
	 * @return modelMongodb
	 */
	public function group($keys, $initial, $reduce, $options = array())
	{
		$ret = $this->conn()->selectCollection($this->table_name)->group($keys, $initial, $reduce, $options);
		$this->sql = array('table'=> $this->table_name, 'keys'=>$keys, 'reduce'=> $reduce, 'options'=> $options);
		$this->_clear_var();
		return $ret;
	}

	/**
	 * 最后执行的sql
	 * @return string $sql
	 */
	public function getLastSql()
	{ return json_encode($this->sql); }


	/**
	 * 查询一条，find one data
	 * @return array $data
	 */
	public function find()
	{
		$ret = $this->conn()->selectCollection($this->table_name)->findOne($this->where, $this->field);
		$this->sql = array(
					 'table'=> $this->table_name,
					 'query'=>$this->where,
					 'field'=> $this->field
				   );
		$this->_clear_var();
		return $ret;
	}

	/**
	 * 查询多条数据
	 * @return array $data
	 */
	public function findAll()
	{
		$ret = $this->conn()->selectCollection($this->table_name)->find($this->where, $this->field);
		if($this->limit) $ret->limit($this->limit)->skip($this->skip);
		if($this->orderby) $ret->sort($this->orderby);

		$this->sql = array(
					 'table'=> $this->table_name,
					 'query'=>$this->where,
					 'field'=> $this->field,
					 'limit'=> $this->limit,
					 'skip'=> $this->skip,
				   );
		$this->_clear_var();
		return $ret;
	}

	public function print_data($data)
	{
		$tmp = array();
		foreach ($data as $k1=>$v1)
		{
			$dtype = gettype($v1);
			if($dtype == 'array' || $dtype == 'object')
			{
				foreach ($v1 as $k2=>$v2) $tmp[$k1][$k2] = $v2;
			}
			else
			{
				$tmp[$k1] = $v1;
			}
		}
		dump($tmp);
	}

	/**
	 * 和findAll()差不多
	 * 返回的数据结构：array('data'=>array(....), 'data_count'=>总数据数)
	 *
	 * @return array $data 结构：array('data'=>array(....), 'data_count'=>10)
	 */
	public function findPage()
	{
		$data['data'] = $this->findAll();
		$data['data_count'] = $this->conn()->selectCollection($this->table_name)->count();

		return $data;
	}

	/**
	 * 统计数据条数
	 * 示例:$m->table('test')->select('id')->where('id<12')->count();
	 * @return integer $count
	 */
	public function count()
	{
		$ret = $this->conn()->selectCollection($this->table_name)->count($this->where);
		$this->sql = array('table'=> $this->table_name,'where'=>$this->where);

		$this->_clear_var();
		return $ret;
	}

	/**
	 * 删除
	 * @return mixed
	 */
	public function delete()
	{
		$ret = $this->conn()->selectCollection($this->table_name)->remove($this->where);
		$this->sql = array('table'=> $this->table_name,'where'=>$this->where);

		$this->_clear_var();
		return $ret;
	}

	/**
	 * 更新, see http://us.php.net/manual/en/mongocollection.update.php
	 * @param array $options
	 * @return boolean
	 */
	public function update($options=array())
	{
		$ret = $this->conn()->selectCollection($this->table_name)->update($this->where, $this->data, $options);
		$this->sql = array('table'=> $this->table_name,'where'=>$this->where, 'update_data'=> $this->data);

		$this->_clear_var();
		return $ret;
	}

	/**
	 * 写入数据。
	 * @return mixed
	 */
	public function insert()
	{
		$data = $this->data;
		$ret = $this->conn()->selectCollection($this->table_name)->insert($data);
		$this->sql = array('table'=> $this->table_name,'insert_data'=> $this->data);

		$this->_clear_var();
		if($ret) return $data['_id'];
		else return false;
	}
}