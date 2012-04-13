<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE;?>/css/common.css">

<h1>第三方扩展类(自定义类) 的使用</h1>
<p>在开发过程中，你可能会需要函数或使用第三方的类，或者你自己写的类，那么在ePHP中如何使用自定义函数，如何自定义类呢？</p>


<h2>使用自定义函数</h2>
<p>
	使用自定义函数，需要先把自定义函数，加载到控制器中。使用Loader::helper('mytest');
	会自动加载exts/helper/mytest.php文件。然后你就可以使用 mytest() 函数了
</p>

<h2>使用自定义类 或 第三方类</h2>
<p>使用自定义类也很简单了，直接把你的类放到exts/目录下就可以使用了。命名规则是 <dfn>xxxx.class.php</dfn></p>

<p>
<samp>使用举例：</samp>
<br />
在exts/下新建 abc.class.php,类的内容为：
<pre>
class abc
{
	public function test()
	{
		return '我被调用了！';
	}
}
</pre>

然后在控制器中就可以这样调用了,不用你include，当你new的时候，系统会自动include abc类。
<pre>
...
public function indexAction()
{
	$abc = new abc();
	echo $abc->test();
}
...
</pre>
</p>

<h2>第三方类分组</h2>
<p>
	可以把扩展类进行分组，如Util类分组。命名方式为，文件夹名Util_类名Test。 调用和上面一样。Util_Test::boo();
</p>
<pre>
class Util_Test
{
	public static function boo()
	{
		return 'function boo.';
	}
}
</pre>


