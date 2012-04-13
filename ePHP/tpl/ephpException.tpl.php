<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>系统发生错误</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="Generator" content="ephpException"/>
<style>
body{font-family: 'Microsoft Yahei', Verdana, arial, sans-serif;font-size:14px;}
a{text-decoration:none;color:#174B73;}
a:hover{ text-decoration:none;color:#FF6600;}
h2{border-bottom:1px solid #DDD;padding:8px 0; font-size:25px;}
.title{margin:4px 0;color:#F60;font-weight:bold;}
.message,#trace{padding:1em;border:solid 1px #000;margin:10px 0;background:#FFD;line-height:150%;}
.message{background:#FFD;color:#2E2E2E;	border:1px solid #E0E0E0;}
#trace{background:#E7F7FF;border:1px solid #E0E0E0;color:#535353;}
.notice{padding:10px;margin:5px;color:#666;background:#FCFCFC;border:1px solid #E0E0E0;}
.red{color:red;font-weight:bold;}
</style>
</head>
<body>
<div class="notice">
<h2>系统发生错误 </h2>
<div >您可以选择 [ <a href="<?php echo($_SERVER['PHP_SELF'])?>">重试</a> ] [ <a href="javascript:history.back()">返回</a> ] 或者 [ <a href="<?php echo URL.'/';?>">回到首页</a> ]</div>

<p><strong>错误位置:</strong>　FILE: <span class="red"><?php echo $this->getFile(); ;?></span>　LINE: <span class="red"><?php echo $this->getLine();?></span> ErrorCode: <span class="red"><?php echo $this->getCode();?></span></p>

<p class="title">[ 错误信息 ]</p>
<p class="message"><?php echo $this->getMessage();?></p>

<p class="title">[ TRACE ]</p>
<p id="trace">
<?php echo nl2br($this->ephpTraceString);?>
</p>

</div>
<div style="color: rgb(255, 51, 0); margin: 5pt; font-weight: bold; text-align:center;">ePHP
<span style='color:silver'> { Fast &amp; Simple PHP Framework } -- [ WE CAN DO IT JUST LIKE IT ]</span>
</div>
</body>
</html>