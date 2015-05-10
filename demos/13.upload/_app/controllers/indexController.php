<?php
/**
 +------------------------------------------------------------------------------
 * index
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<wo@wangxian.me>
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

	function uploadAction()
	{
		$set = array(
	         'fexts'=>'.jpg|.gif|.png|.txt',	//可以上传的文件扩展名
	         'maxSize'=>0, 				//单位为K,0:表示不限制
	         'savePath'=>'./assets/upload/',	//上传文件后保存的目录(要可写)
	         'isThumb'=>true,				//生成缩略图
	         'thumb'=>array(array(100,120)) //只生成一张缩略图,宽:100 高:120
	     );
		//如果当前提交表单中只有一个 FILE 域的话,则不需要指定期名称,否则需要指定其FILE域名称.
		//如 new uploadfile(''); 要想在多个不同FILE域名之间切换的话请用如 $up->setInputName('picfile');
		$up = new Uploadfile();
		$up->setAttrib($set); //设置属性

		if ($up->isUploaded()) //有文件上传
		{
		    $up->upload();//开始上传
		    if ($up->hasError()) //如果发生了错误
		    {
		        dump($up->error());
		    }else{
		        echo '上传后的文件名：'. $up->getUploadedFile(); //得到上传后的文件名
		        echo '<br />';
		        echo '得到缩略图文件名:';
		        dump($up->getThumbFile()); //得到缩略图文件名
		    }
		}
	}
}

/* End of file indexController.php */
/* Location: indexController.php */