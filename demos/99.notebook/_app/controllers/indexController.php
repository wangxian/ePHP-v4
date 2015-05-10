<?php
/**
 +------------------------------------------------------------------------------
 * 记事本示例
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author  WangXian
 * @email	<wo@wangxian.me>
 * @creation date 2011-07-31 02:04:00
 * @last modified 2011-07-31 02:04:05
 +------------------------------------------------------------------------------
 */
class indexController extends controller
{

	function indexAction()
	{
		$note = new notebookModel();
		$this->view->data = $note->list_note( getv('page',1) );
		//dump($this->view->data);

		//翻页导航
		$link = new Link( getv('page',1), $this->view->data['data_count'], U('index'));
		$this->view->pagelink = $link->show(3);

		$this->view->render();
	}

	public function deleteAction()
	{
		$id = (int)getv('id');
		if($id)
		{
			$note = new notebookModel();
			if($note->del_note( getv('id') )) show_success('删除成功!');
			else show_error('删除失败！');
		}
		else show_error('非法请求！', U('index'));
	}

	public function addAction()
	{
		if(postv('title'))
		{
			$data['title']		= htmlspecialchars(postv('title'));
			$data['content']	= htmlspecialchars(postv('content'));
			$data['created_at'] = date('Y-m-d H:i:s');

			//dump($data);
			$note = new notebookModel();
			if($note->add_note( $data )) show_success('添加成功!', U('index'));
			else show_error('添加失败！');
		}
		else $this->view->render();
	}

	public function editAction()
	{
		if( postv('id',0) )
		{
			$data['title']		= htmlspecialchars(postv('title'));
			$data['content']	= htmlspecialchars(postv('content'));

			//dump($data);
			$note = new notebookModel();
			if( $note->update_note( postv('id'), $data ) ) show_success('更新成功!', U('index/detail/id/'.postv('id') ) );
			else show_error('更新失败！');
		}
		else if( getv('id') )
		{
			$note = new notebookModel();
			$this->view->data = $note->note_info(getv('id'));
			$this->view->render();
		}
		else show_error('非法请求！', U('index'));
	}

	public function detailAction()
	{
		if(getv('id'))
		{
			$note = new notebookModel();
			$this->view->data = $note->note_info(getv('id'));
			$this->view->render();
		}
		else show_error('非法请求！', U('index'));
	}

	function __destruct()
	{
		run_info();
	}
}

/* End of file indexController.php */
/* Location: indexController.php */