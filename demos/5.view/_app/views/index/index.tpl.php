<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> new document </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="generator" content="WangXian" />
<meta name="author" content="" />
<meta name="keywords" content="" />
<meta name="description" content="" />
</head>
<body>
<h1>视图渲染演示！</h1>

用对象传值,在视图中，可以这样使用$this-&gt;data<br />
输出结果：<br />
<div style="color:blue;"><?php echo $this->data;?></div>

用assign()传值,在视图中，可以这样使用，$data<br />
输出结果：<br />
<div style="color:blue;"><?php echo $data;?></div>

<div style="margin:5px;padding:1em;background-color:#E6EFC2;color:#264409;border:2px #C6D880 solid;font-size:12px;">
	不过建议使用$this->data 这样的方式，效率高些，而且，在使用IDE打开视图的时候，不会总提示，变量没定义。
</div>
<?php run_info();?>
</body>
</html>