<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_DIR;?>/css/common.css">

<h1>ePHP扩展库 Http类。</h1>
<p>Http类为系统自带的类。其实ePHP可以很方便的扩展第三方类。只要把类放到exts/下，名为{类名.class.php}然后直接new就行了。如果是static class 那xxxx::xxxx()就可以了。</p>
<p>
这个示例要介绍的Http类，也就算是一个扩展类。该类提供了7个方法。
<samp>Http::download() Http::sendStatus() Http::sendAuthUser() Http::getAuthUser() Http::clientIp()等，其他的看Http.class.php或开发文档api chm</samp>
</p>

<p>
<a href="<?php echo U('index/download')?>">Http::download()演示</a>,其他方法和这个类似。
</p>

<dfn>示例代码：</dfn>
<code>
//直接在线下载。<br />
Http::download('','baidu.html', file_get_contents('http://www.baidu.com'));<br /><br />

//下载服务器上的文件<br />
//Http::download('e:/a.txt','a.txt');<br />
</code>