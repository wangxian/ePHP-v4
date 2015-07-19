<?php
/**
 +------------------------------------------------------------------------------
 * modelMS for ePHP
 +------------------------------------------------------------------------------
 * @version 4.1
 * @author  WangXian
 * @package core
 * @creation_date 2011-9-23
 * @last_modified 2011-9-25
 +------------------------------------------------------------------------------
 */

class modelMS extends model
{
	/**
	 * 默认的使用的数据库
	 * @var string
	 */
	public  $db_config_name = 'master';

	/**
	 * 连接数据库
	 * @access protected
	 * @param string $db_config_name 使用那个数据库连接
	 */
	protected function conn($db_config_name='')
	{
		$db_config_name = $db_config_name ? $db_config_name : $this->db_config_name;
		if(! isset(self::$_db_handle[$db_config_name]) )
		{
			if( true == C('sql_log') ) wlog('SQL-Log', '#'.$db_config_name);
			$dbdriver = 'db_'.C('dbdriver');
			include_once FW_PATH.'/dbdrivers/'. $dbdriver .'.class.php';
			self::$_db_handle[$db_config_name] = $this->db = new $dbdriver($db_config_name);
		}
		else $this->db = self::$_db_handle[$db_config_name];
		return $this->db;
	}

	/**
	 * 写入数据库的内容(for insert|update)
	 * @param array $data 要写入数据库的内容。
	 * @param array $noquote data中不加引号的字段列表。如array('updated','create_time');必须是数组
	 * @return object $this
	 */
	public function set($data,$noquote=array())
	{
		if(is_array($data))
		{
			foreach ($data as $k=>$v)
			{
				if(empty($noquote) || ! in_array($k,$noquote) )
				{
					$v = $this->escape_string($v, 'master');
					$data[$k] = "'{$v}'";
				}
			}
		}
		else throw new ephpException('参数$data,$noquote都必须是数组。');

		$this->data = $data;
		return $this;
	}

	/**
	 * SQL中的where条件
	 * @param  string||array $where 可以是一个字符串或数组。
	 * @param  array $noquote 指定那些字段不加引号引号。如array('updated','create_time');
	 * @return object $this
	 */
	public function where($where,$noquote=array())
	{
		if(is_string($where))
		{
			$this->where = $where;
			return $this;
		}
		else if(is_array($where))
		{
			$tmp = array();
			foreach ($where as $k=>$v)
			{
				if(empty($noquote) && ! in_array($k,$noquote) )
				{
					$v = $this->escape_string($v, 'slave');//默认从数据库，这种情况不能确定主从,存在小问题
					$tmp[] = $k."='".$v."'";
				}
				else $tmp[] = $k."=".$v; //不加引号。
			}
			$this->where = implode(' AND ', $tmp);
		}
		return $this;
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////
// CURD操作
////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * 调用数据库db::query方法，如果是SELECT\show可以后后续操作
	 * @param  string $sql 要查询的SQL或执行commit的SQL等。
	 * @return mixed
	 */
	public function query($sql)
	{
		#鉴定是执行查询还是commit提交操作。如果是select、show，可以有后续操作。
		$_key = strtolower(substr($sql,0,4));
		if($_key == 'sele' || $_key == 'show')
		{
			$this->query_sql = $sql;
			return $this;
		}
		else return $this->conn('master')->query($sql);
	}

	/**
	 * 查询
	 * @param string $type 查询类型,fetch_array fetch_arrays...
	 */
	protected function _find($type)
	{
		$sql = $this->_read_sql();
		if($this->expire < 0) return $this->conn('slave')->$type($sql);
		else
		{
			$cache = Cache::init();
			$cachename = 'db/'.$type.'_'.md5($sql);
			if(false == ($data=$cache->get($cachename)))
			{
				$data = $this->conn('slave')->$type($sql);
				$cache->set($cachename,$data,$this->expire);
				$this->expire = -1;
			}
			return $data;
		}
	}

	/**
	 * 和findAll()差不多
	 * 返回的数据结构：array('data'=>array(....), 'data_count'=>总数据数)
	 *
	 * @return array $data 结构：array('data'=>array(....), 'data_count'=>10)
	 */
	public function findPage()
	{
		$dbdriver = C('dbdriver');
		if($dbdriver == 'mysqli' || $dbdriver == 'mysql')
		{// mysql
			$this->field = 'SQL_CALC_FOUND_ROWS '. $this->field;

			$this->sql = $this->_read_sql();
			if($this->expire < 0)
			{
				$data['data'] = $this->conn('slave')->fetch_arrays($this->sql);

				$_count = $this->db->fetch_array('SELECT FOUND_ROWS()');
				$data['data_count'] = $_count['FOUND_ROWS()'];
			}
			else
			{
				$cache = Cache::init();
				$cachename = 'db/findPage_'.md5($this->sql);
				if(false == ($data=$cache->get($cachename)))
				{
					$data['data'] = $this->conn('slave')->fetch_arrays($this->sql);

					$_count = $this->db->fetch_array('SELECT FOUND_ROWS()');
					$data['data_count'] = $_count['FOUND_ROWS()'];

					$cache->set($cachename,$data,$this->expire);
					$this->expire = -1;
				}
			}
			return $data;
		}
		else
		{//非mysql
			$this->sql = $this->_read_sql();
			if($this->expire < 0)
			{
				$_table_name = $this->_get_table_name();
				$_where = ($this->where != '') ? ' WHERE '. $this->where : '';
				$sql_cout = 'SELECT count(*) AS count FROM '.$_table_name.$this->join.$_where;

				$data['data'] = $this->conn('slave')->fetch_arrays($this->sql);
				$data['data_count'] = $this->db->fetch_object( $sql_cout )->count;
			}
			else
			{
				$cache = Cache::init();
				$cachename = 'db/findPage_'.md5($this->sql);
				if(false == ($data=$cache->get($cachename)))
				{
					$_table_name = $this->_get_table_name();
					$_where = ($this->where != '') ? ' WHERE '. $this->where : '';
					$sql_cout = 'SELECT count(*) AS count FROM '.$_table_name.$this->join.$_where;

					$data['data'] = $this->conn('slave')->fetch_arrays($this->sql);
					$data['data_count'] = $this->db->fetch_object( $sql_cout )->count;

					$cache->set($cachename,$data,$this->expire);
					$this->expire = -1;
				}
			}
			return $data;
		}
	}

	/**
	 * 统计数据条数
	 * 示例:$m->table('test')->select('id')->where('id<12')->count();
	 * @return integer $count
	 */
	public function count()
	{
		$_table_name = $this->_get_table_name();
		$_where = ($this->where != '') ? ' WHERE '. $this->where : '';
		$_field = $this->field;
		$_join  = $this->join;

		//清理使用过的变量
		$this->where = '';
		$this->field = '*';
		$this->join = '';

		$this->conn('slave');//连接从数据库
		$this->sql = 'SELECT count('. $_field .') AS count FROM '.$_table_name.$_join.$_where;
		return $this->db->fetch_object( $this->sql )->count;
	}

#------------------------------------------------------------------------------insert update delete操作

	/**
	 * 删除一行或多行，如果希望删除所有行,使用delete(true)
	 * @param boolean $f
	 * @return boolean
	 */
	public function delete($f=false)
	{
		$_where = '';
		$_table_name = $this->_get_table_name();

		if( $this->where ) $_where = ' WHERE '.$this->where;
		else if($this->where == '' && $f == false) throw new ephpException('警告：您似乎漏掉了where条件，确认不使用where条件，请使用delete(true)');

		//清理使用过的变量
		$this->where = '';

		$this->sql = 'DELETE FROM '.$_table_name.$_where;
		return $this->conn('master')->query( $this->sql );
	}

	/**
	 * 更新一行或多行，如果更新所有数据,使用update(true)
	 * @param boolean $f
	 * @return boolean
	 */
	public function update($f=false)
	{
		$_where = '';
		$_table_name = $this->_get_table_name();

		$_set_string = ' SET ';
		$tmp = array();
		foreach ($this->data as $k=>$v) $tmp[] = $k.'='.$v;
		$_set_string .= implode(',', $tmp);

		if( $this->where ) $_where = ' WHERE '.$this->where;
		else if($this->where == '' && $f == false) throw new ephpException('警告：您似乎漏掉了where条件，确认不使用where条件，请使用update(true)');

		//清理使用过的变量
		$this->data = array();
		$this->where = '';

		$this->sql='UPDATE '.$_table_name.$_set_string.$_where;
		return $this->conn('master')->query($this->sql);
	}

	/**
	 * 插入方式，ignore，replace，duplicate update
	 * @param string $type 类型
	 * @param string $update_string 更新字段
	 */
	protected function _insert($type,$update_string='')
	{
		$_table_name = $this->_get_table_name();
		$_fields = implode(',', array_keys($this->data));
		$_values = implode(',', array_values($this->data));

		//清理使用过的变量
		$this->data=array();
		$this->conn('master');

		//插入类型
		if($type=='IGNORE') $this->sql='INSERT IGNORE INTO '. $_table_name ." ({$_fields}) VALUES ({$_values})";
		elseif($type=='REPLACE') $this->sql='REPLACE INTO '. $_table_name ." ({$_fields}) VALUES ({$_values})";
		elseif($type=='UPDATE') $this->sql='INSERT INTO '. $_table_name ." ({$_fields}) VALUES ({$_values}) ON DUPLICATE KEY UPDATE ".$update_string;
		else $this->sql='INSERT INTO '. $_table_name ." ({$_fields}) VALUES ({$_values})";

		$this->db->query( $this->sql );
		return $this->db->insert_id();
	}

	#------------------------------------------------------------------------------事务

	/**
	 * 开始事务
	 * @return boolean
	 */
	public function trans_start()
	{
		return $this->conn('master')->autocommit(FALSE);
	}

	/**
	 * 事务提交
	 * @return boolean
	 */
	public function trans_commit()
	{
		$this->conn('master'); //connect server
		$this->db->commit();
		$this->db->autocommit(TRUE);
	}

	/**
	 * 事务回滚
	 * @return boolean
	 */
	public function trans_rollback()
	{
		$this->conn('master'); //connect server
		$this->db->rollback();
		$this->db->autocommit(TRUE);
	}

	/**
	 * 过滤SQL中的不安全字符
	 * @param string $str 要过滤的字符串
	 * @param string $db_config_name 使用那个数据库连接
	 */
	public function escape_string($str,$db_config_name='')
	{
		return $this->conn($db_config_name)->escape_string($str);
	}
}
