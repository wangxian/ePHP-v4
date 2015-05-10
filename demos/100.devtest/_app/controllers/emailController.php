<?php

class emailController
{
	public function indexAction()
	{
		$content = '<span style="color:green;">我是诚实的的阳光很刺眼，春天啊春天，春天的阳光很刺眼！</span>';
		//$content = file_get_contents('http://locahost/');

		$email = new Email('smtp.sina.com','mcp8815@sina.com', 'mcp8815123456');
		$r = $email->from('mcp8815@sina.com', '王见')
			  ->to('xian366@sina.com') // 如果要发给多个联系人，传递一个array()即可
              ->cc('wo#wangxian.me') //抄送，参数同to()
              ->bcc('admin@totour.info') //密送，参数同to()
              ->subject('测试邮件--标题')
              ->message( $content )
              ->attach('e:/test.7z')
              ->send();
		dump($r);
	}
}