<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SOURCE;?>/css/common.css">

<h1>文件上传类Uploadfile</h1>
<dfn>上传演示</dfn>

<form action="<?php echo U('index/upload');?>" method="post" name="form1" enctype="multipart/form-data">
<input type="file" name="file" id="file" /><br />
<input type="submit" name="submit" value="上传" />
</form>
<div style="color:red;">补充：在SAE平台下，该类不被支持，请使用SAE Storage，使用起来也非常方便。
	<a href="http://apidoc.sinaapp.com/sae/SaeStorage.html">http://apidoc.sinaapp.com/sae/SaeStorage.html</a>
</div>