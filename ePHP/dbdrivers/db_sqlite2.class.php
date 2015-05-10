<?php
/**
 +------------------------------------------------------------------------------
 * sqlite2 driver for ePHP
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author  WangXian
 * @package  dbdrivers
 * @email	<wo#wangxian.me>
 * @creation date 2011-2-22 下午05:09:34
 * @last modified 2011-6-11
 +------------------------------------------------------------------------------
 */
class db_sqlite2
{
	public $db = false;

	/**
	 * 使用db.config.php配置中的那个数据库
	 * @param string $db_config
	 */
	function __construct($db_config='default')
	{
		if(false == ( $iconfig = C($db_config, 'db') ) ) show_error('数据库配制文件db.config.php中 '. $db_config .'  未设置。');

		$error_msg = '';
		$this->db = sqlite_open( $iconfig['host'], 0666, $error_msg );
		if( empty($this->db) ) show_error( $error_msg );
	}

	/**
	 * 执行mysql query()操作
	 * @param string $sql
	 * @return mixed
	 */
	public function query($sql)
	{
		// 是否记录 SQL log
		if( true == C('sql_log') ) wlog('SQL-Log', $sql);

		$error_msg = '';

		$_key = strtolower(substr($sql,0,6));
		if($_key=='select') $rs = sqlite_query($this->db, $sql, SQLITE_BOTH, $error_msg);
		else $rs = sqlite_exec($this->db, $sql, $error_msg);

		if(!empty($rs))
		{
			$GLOBALS['run_dbquery_count']++;
			return $rs;
		}
		else if( C('show_errors') ) show_error('执行sqlite_query()出现错误: '. $error_msg .'<br />原SQL: '.$sql);
		else exit('db_sqlite2::query() error.'); //return false;
	}

	/**
	 * 最后执行插入的id。
	 * @return integer $insert_id
	 */
	public function insert_id()
	{
		return sqlite_last_insert_rowid($this->db);
	}

	/**
	 * 影响的数据总行数。
	 * @return integer $affected_rows
	 */
	public function affected_rows()
	{
		return sqlite_changes($this->db);
	}

	/**
	 * 查询一条数据，返回数据格式array
	 * @param string $sql
	 * @return array
	 */
	public function fetch_array($sql)
	{
		return sqlite_fetch_array( $this->query($sql), SQLITE_ASSOC );
	}

	/**
	 * 查询多条数据，返回数据格式array
	 * @param string $sql
	 * @return array
	 */
	public function fetch_arrays($sql)
	{
		return sqlite_fetch_all( $this->query($sql), SQLITE_ASSOC );
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
		return sqlite_escape_string($str);
	}

	function __destruct()
	{
		sqlite_close($this->db);
	}
}
/* End of file sqlite2.class.php */
/* Location: ./ePHP/dbdrivers/sqlite2.class.php */