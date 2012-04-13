<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE;?>/css/common.css">

<h1>生成图片验证码</h1>
<p>需要gd2库的支持！</p>
<samp>缩略图</samp>
<img src="<?php echo U('index/imgVerifyCode');?>?r=0" alt="" onclick="javascript:this.src=this.src.substring(0,this.src.lastIndexOf('?'))+'?r='+Math.random();" style="cursor:pointer;" />

<br /><br /><br />
<dfn>session信息：</dfn>
<?php dump($_SESSION);?>

<h2>验证码输入是否正确 <dfn>Image::chkVerify('输入的验证码');</dfn> </h2>

<?php dump(Image::chkVerify('输入的验证码'))?>

<p class="important"><strong>说明一下，用户输入的验证码是不区分大小写的。</strong></p>