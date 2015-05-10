<?php
/**
 +------------------------------------------------------------------------------
 * 网络请求
 * Request for controller,using $this->request->get();
 +------------------------------------------------------------------------------
 * @version 3.0
 * @author WangXian
 * @email wo#wangxian.me
 * @package  libraries
 * @creation_date 2011-1-14 下午03:47:37
 * @last_modified 2011-1-14 下午03:47:37
 +------------------------------------------------------------------------------
 */

class Request
{
	/**
	 * 断言
	 * @param string $key
	 * @param string $default 断言默认值
	 */
    public function assert($key, $default = '')
    {
        return isset($key) ? $key : $default;
    }

    /**
     * 从get中获取一个值
     * 如果get某个值，如key为NULL返回所有$_GET
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function get($key = null, $default = '')
    {
        if (null === $key) return $_GET;
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    /**
     * 从post中获取一个值
     * 如果post某个值，如key为NULL返回所有$_POST
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function post($key = null, $default = '')
    {
        if (null === $key)  return $_POST;
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

   /**
     * 从cookie中获取一个值
     * 如果cookie某个值,key为NULL返回所有$_COOKIE
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function cookie($key = null, $default = '')
    {
        if (null === $key) return $_COOKIE;
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }

    /**
     * 从server中获取一个值
     * 如果server某个值,key为NULL返回所有$_SERVER
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function server($key = null, $default = '')
    {
        if (null === $key) return $_SERVER;
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    /**
     * 从$_ENV中获取一个值
     * 如果$_ENV某个值,key为NULL返回所有$_ENV
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function env($key = null, $default = '')
    {
        if (null === $key) return $_ENV;
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }

    /**
     * 从$_SESSION中获取一个值
     * 如果$_SESSION某个值,key为NULL返回所有$_SESSION
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function session($key = null, $default = '')
    {
    	isset($_SESSION) || session_start();
        if (null === $key)  return $_SESSION;
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
}