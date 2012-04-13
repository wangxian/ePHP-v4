<?php
 /**
 +------------------------------------------------------------------------------
 * index
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<admin@loopx.cn>
 * @creation date 2011-07-31 02:04:00
 * @last modified 2011-07-31 02:04:05
 +------------------------------------------------------------------------------
 */
class indexController
{
	function __construct()
	{
		$this->view = new view();
	}

	function indexAction()
	{
		$this->view->render();
	}

	function downloadAction()
	{
		//直接在线下载。
		Http::download('','baidu.html', file_get_contents('http://www.baidu.com'));
		//下载服务器文件
		//Http::download('e:/a.txt','a.txt');
	}


	//登陆
	public function loginAction()
	{
		$account = Http::getAuthUser();
		if( !empty($account) && $account['user'] == 'test25' && $account['pwd'] == 'test25')
		{
//				$_SESSION['admin'] = $account['user'];
//				R(U('index/index'));
		}
		else
			Http::sendAuthUser('username|password','HTTP/1.0 401 Unauthorized');
	}
}

/* End of file indexController.php */
/* Location: indexController.php */