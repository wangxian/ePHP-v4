<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> 记事本演示程序 -- 由 ePHP 驱动</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE;?>/css/common.css">
<meta name="generator" content="WangXian" />
<style>
body,p,div{ line-height: 2em; }
#list_note .title{color:#669900;font-size:1.2em;}
#list_note .title:hover{color:red;}
input[type="text"]{height: 2em;width: 520px;}
textarea{height: 180px;width: 570px;}
</style>
</head>
<body>

<h1>我的记事本</h1>
<div id="func">
	<a href="<?php echo U('index/add')?>" tiltle="">写记事</a>
	<a href="<?php echo U('index')?>" tiltle="">查看记事</a>
</div>