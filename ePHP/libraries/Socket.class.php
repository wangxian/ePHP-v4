<?php
 /**
 +------------------------------------------------------------------------------
 * Socket 基本操作
 * <code>
 * <?php
 * $config = array(
 *		'host'			=> 'localhost',
 *		'protocol'		=> 'tcp',
 *		'port'			=> 80,
 *		'timeout'		=> 30,
 *		'persistent'	=> false,//持久
 *	);
 * $socket = new Socket($config);
 * $socket->read(1023);
 * </code>
 +------------------------------------------------------------------------------
 * @version 3.2
 * @author WangXian
 * @email admin@loopx.cn
 * @package  libraries
 * @creation_date 2010-10-17
 * @last_modified 2010-12-25 19:18:47
 +------------------------------------------------------------------------------
 */

class Socket
{
	protected $_config = array(
		'host'			=> 'localhost',
		'protocol'		=> 'tcp',
		'port'			=> 80,
		'timeout'		=> 30,
		'persistent'	=> false,//持久
	);

	private $config = array();
	private $connection = null;
	private $connected = false;
	private $error = array();

	public function __construct($config = array())
	{
		$this->config =	array_merge($this->_config,$config);
		if (!is_numeric($this->config['protocol'])) $this->config['protocol'] = getprotobyname($this->config['protocol']);
	}

	/**
	 * 连接
	 * @return object
	 */
	public function connect()
	{
		if ($this->connection != null) $this->disconnect();

		if ($this->config['persistent'] == true)
		{
			$tmp = null;
			$this->connection = @pfsockopen($this->config['host'], $this->config['port'], $errNum, $errStr, $this->config['timeout']);
		}
		else
		{
			$this->connection = fsockopen($this->config['host'], $this->config['port'], $errNum, $errStr, $this->config['timeout']);
		}

		if (!empty($errNum) || !empty($errStr))
		{
			$this->error = array('errorStr'=>$errStr,'errorNum'=>$errNum);
		}

		$this->connected = is_resource($this->connection);

		return $this->connected;
	}

	/**
	 * 错误信息
	 * @return string
	 */
	public function error()
	{
		return $this->error;
	}

	/**
	 * 写数据
	 * @param string $data
	 * @return boolean
	 */
	public function write($data)
	{
		if (!$this->connected)
		{
			if (!$this->connect()) return false;
		}
		return fwrite($this->connection, $data, strlen($data));
	}

	/**
	 * 读取数据
	 * @param integer $length
	 */
	public function read($length=1024)
	{
		if (!$this->connected)
		{
			if (!$this->connect()) return false;
		}

		if (!feof($this->connection)) return fread($this->connection, $length);
		else return false;
	}

	/**
	 * 断掉socket连接
	 * @return boolean
	 */
	public function disconnect()
	{
		if (!is_resource($this->connection))
		{
			$this->connected = false;
			return true;
		}
		$this->connected = !fclose($this->connection);

		if (!$this->connected)
		{
			$this->connection = null;
		}
		return !$this->connected;
	}

 	public function __destruct()
 	{
 		$this->disconnect();
 	}
}
/* End of file Socket.class.php */
/* Location: ./_framework/libraries/Socket.class.php */