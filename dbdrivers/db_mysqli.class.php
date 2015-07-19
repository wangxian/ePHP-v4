<?php
/**
 +------------------------------------------------------------------------------
 * mysqli类
 * 使用mysqli驱动
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author  WangXian
 * @package dbdrivers
 * @creation date 2010-8-12
 * @Modified date 2011-6-11
 +------------------------------------------------------------------------------
 */
class db_mysqli
{
	public $db = false;

	/**
	 * 使用db.config.php配置中的那个数据库
	 * @param string $db_config
	 */
	function __construct($db_config='default')
	{
		if(false == ( $iconfig = C($db_config, 'db') ) ) show_error('数据库配制文件db.config.php中 '. $db_config .'  未设置。');

		if(empty($iconfig['port'])) $iconfig['port'] = 3306;
		$this->db = new mysqli($iconfig['host'], $iconfig['user'], $iconfig['password'], $iconfig['dbname'], $iconfig['port']);
		if(mysqli_connect_errno()) show_error('无法连接到数据库，错误信息: '. mysqli_connect_error());

		$this->db->set_charset("utf8");
	}

	/**
	 * MYSQL query
	 * @param  string $sql
	 * @return mixed
	 */
	function query($sql)
	{
		#是否记录 SQL log
		if( true == C('sql_log') ) wlog('SQL-Log', $sql);

		if(true == ( $rs = $this->db->query($sql) ) )
		{
			$GLOBALS['run_dbquery_count']++;
			return $rs;
		}
		else if( C('show_errors') ) throw new ephpException('执行mysqli::query()出现错误: '. $this->db->error .'<br />原SQL: '.$sql, 2045);
		else exit('db_mysqli::query() error.');
	}

	/**
	 * 获取单条记录,返回数据格式array
	 * @param string $sql
	 * @return array
	 */
	function fetch_array($sql)
	{
		$rs = $this->query($sql);
		$data = $rs->fetch_assoc();

		$rs->free();//释放内存
		return $data;
	}

	/**
	 * 获取多条记录，返回数据格式array
	 * @param string $sql
	 * @return array
	 */
	function fetch_arrays($sql)
	{
		$rs = $this->query($sql);
		$data = null;
		while(true == ($row = $rs->fetch_assoc()))
		{
			$data[] = $row;
		}
		$rs->free();
		return $data;
	}

	/**
	 * 获取一条记录,以object的方式返回数据
	 * @param string $sql
	 * @return object
	 */
	function fetch_object($sql)
	{
		$rs = $this->query($sql);
		$data = $rs->fetch_object();

		$rs->free();//释放内存
		return $data;
	}

	/**
	 * 查询多条记录，以objects的方式返回数据
	 * @param string $sql
	 * @return object
	 */
	function fetch_objects($sql)
	{
		$rs = $this->query($sql);
		$data = null;
		while(true == ($row = $rs->fetch_object()) )
		{
			$data[] = $row;
		}
		$rs->free();
		return $data;
	}

	/**
	 * return last insert id。
	 * @return integer insert_id
	 */
	public function insert_id()
	{
		return $this->db->insert_id;
	}

	/**
	 * 影响的行数。
	 * @return integer 操作影响的数据条数
	 */
	public function affected_rows()
	{
		return $this->db->affected_rows;
	}

	/**
	 * 过滤SQL中的不安全字符
	 * @param string $str
	 */
	public function escape_string($str)
	{
		return $this->db->real_escape_string($str);
	}

	/*
	 * 设置事务是否自动提交
	 * @param boolean $f
	 * @return boolean
	 */
	public function autocommit($f)
	{
		return $this->db->autocommit($f);
	}

	/*
	 * 提交事务
	 * @return boolean
	 */
	public function commit()
	{
		return $this->db->commit();
	}

	/*
	 * 回滚事务
	 * @return boolean
	 */
	public function rollback()
	{
		return $this->db->rollback();
	}

	function __destruct()
	{
		$this->db->close();
	}
}
/* End of file mysqli.class.php */
/* Location: ./ePHP/dbdrivers/mysqli.class.php */