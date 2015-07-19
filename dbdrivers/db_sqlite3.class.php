<?php
/**
 +------------------------------------------------------------------------------
 * sqlite3 driver for ePHP
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author  WangXian
 * @package  dbdrivers
 * @email	<wo#wangxian.me>
 * @creation date 2011-2-22 18:16:52
 * @last modified 2011.6.11
 +------------------------------------------------------------------------------
 */
class db_sqlite3
{
	public $db = false;

	/**
	 * 使用db.config.php配置中的那个数据库
	 * @param string $db_config
	 */
	function __construct($db_config='default')
	{
		if(false == ( $iconfig = C($db_config, 'db') ) ) show_error('数据库配制文件db.config.php中 '. $db_config .'  未设置。');

		$this->db = new SQLite3( $iconfig['host'], SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $iconfig['password'] );
		if( empty($this->db) ) show_error( $this->db->lastErrorMsg() );
	}

	/**
	 * 执行mysql query()操作
	 * @param String $sql
	 * @return mixed
	 */
	public function query($sql)
	{
		// 是否记录 SQL log
		if( true == C('sql_log') ) wlog('SQL-Log', $sql);

		$_key = strtolower(substr($sql,0,6));
		if($_key=='select') $qt = 'query';
		else $qt = 'exec';

		if(true == ( $rs = $this->db->$qt($sql) ) )
		{
			$GLOBALS['run_dbquery_count']++;
			return $rs;
		}
		else if( C('show_errors') ) show_error('执行sqlite_query()出现错误: '. $this->db->lastErrorMsg() .'<br />原SQL: '.$sql);
		else exit('db_sqlite3::query() error.'); //return false;
	}

	/**
	 * 最后执行插入的id。
	 * @return integer $insert_id
	 */
	public function insert_id()
	{
		return $this->db->lastInsertRowID();
	}

	/**
	 * 影响的数据总行数。
	 * @return integer $affected_rows
	 */
	public function affected_rows()
	{
		return $this->db->changes();
	}

	/**
	 * 查询一条数据，返回数据格式array
	 * @param string $sql
	 * @return array
	 */
	public function fetch_array($sql)
	{
		$rs = $this->query($sql);
		$data = $rs->fetchArray(SQLITE3_ASSOC);

		$rs->finalize();
		return $data;
	}

	/**
	 * 查询多条数据，返回数据格式array
	 * @param string $sql
	 * @return array
	 */
	public function fetch_arrays($sql)
	{
		$result = $this->db->query($sql);
		$array = null;
		while(true == ($row = $result->fetchArray(SQLITE3_ASSOC)))
		{
			$array[] = $row;
		}
		$result->finalize();
		return $array;
	}

	/**
	 * 查询一条数据，返回数据格式Object
	 * @param string $sql
	 * @return object
	 */
	public function fetch_object($sql)
	{
		return (object)$this->fetch_array($sql);
	}

	/**
	 * 查询多条数据，返回数据格式Object
	 * @param string $sql
	 * @return object
	 */
	public function fetch_objects($sql)
	{
		$arr = $this->fetch_arrays($sql);
		if(!empty($arr)):
			foreach ($arr as $k=>$v)
				$arr[$k] = (object)$v;
		endif;
		return $arr;
	}

	/**
	 * 转义SQL中不安全的字符
	 * @return string $str
	 */
	public function escape_string($str)
	{
		return $this->db->escapeString($str);
	}

	function __destruct()
	{
		$this->db->close();
	}
}
/* End of file sqlite3.class.php */
/* Location: ./ePHP/dbdrivers/sqlite3.class.php */