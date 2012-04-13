<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE;?>/css/common.css">

<h1>Widget 测试</h1>
<p>
Widget使用，首先在_app/widgets/xx目录下，建一个 xxWidget.php的挂件文件，内容为
<pre>
class mytestWidget extends Widget
{
	//挂件中必须包含一个run的接口方法，不然无法运行。参数为$data=''
	public function run($data='')
	{
		$this->view->data = $data;
		$this->view->render();
	}
}
</pre>
render()会渲染当前目录下的mytest.tpl.php，你也可以指定渲染那个视图<br />

mytest.tpl.php的内容：
<pre>
姓名：&lt;?php echo $this-&gt;data['name'];?&gt;&lt;br /&gt;
年龄：&lt;?php echo $this-&gt;data['age'];?&gt;
</pre>

调用挂件很容易：<dfn>Widget::show(调用挂件名称,传递data参数);</dfn>
<br />Widget::show（）第二个参数data可以省略。
<br /><samp>在xxWidget run中可以使用$this->view->render()渲染widget视图。</samp>
</p>

<p>
以下是mytestWidget的输出：<br />
<textarea rows="12" cols="120"><?php Widget::show('mytest', array('name'=>'wangxian','age'=>80));?></textarea>

</p>
