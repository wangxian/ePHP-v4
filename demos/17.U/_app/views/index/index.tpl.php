<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_DIR;?>/css/common.css">

<h1>强大的url生成器 U()函数</h1>
<p>强大的U()函数,可以根据url_type生成不同类型的。现在url_type支持生成3中方式的url: <samp>PATH_INFO、GET、SEO</samp>
<br />如果设置了html_url_suffix 那么生成的url会添加上后缀。默认后缀为空。</p>
<p>这里html_url_suffix = '.html'</p>


<h2>'url_type'=>'PATH_INFO'</h2>
<?php C('url_type','main','PATH_INFO');?>
<pre>
echo U('index/info/id/23', array('name'=>'wx'));
生成：
<?php echo U('index/info/name/wx', array('id'=>22))?>


echo U('file/info');
生成：
<?php echo U('file/info')?>
</pre>


<h2>'url_type'=>'GET'</h2>
<?php C('url_type','main','GET');?>
<pre>
echo U('index/info/name/wx', array('name'=>'wx'));
生成：
<?php echo U('index/info/name/wx', array('id'=>22))?>


echo U('file/info');
生成：
<?php echo U('file/info')?>
</pre>


<h2>'url_type'=>'SEO',不带index.php的url</h2>
<?php C('url_type','main','SEO');?>
<pre>
echo U('index/info/id/23', array('name'=>'wx'));
生成：
/ephp/examples/17.U/index/info/name/wx/id/22.html


echo U('file/info');
生成：
/ephp/examples/17.U/file/info.html
</pre>

<h2>'url_type'=>'NODIR',不带index.php的url,并生成的url无目录</h2>
<?php C('url_type','main','NODIR');?>
<pre>
echo U('index/info/id/23', array('name'=>'wx'));
生成：
/ephp/examples/17.U/index-info-id-23-name-wx.html


echo U('file/info/23');
生成：
/ephp/examples/17.U/file-info-23.html
</pre>