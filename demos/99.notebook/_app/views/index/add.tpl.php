<?php include APP_PATH.'/views/public/header.tpl.php';?>
<script type="text/javascript">
function $(id){ return document.getElementById(id);}
function check_submit()
{
	if($("title").value == "")
	{
		alert('标题必填！');return false;
	}

	if($("content").value == "")
	{
		alert('内容必填！');return false;
	}
	document.form1.submit();
}
</script>
<p>
<form name="form1" action="" method="post" >
标题：<br />
<input type="text" name="title" id="title" size="40" /><br />

内容：<br />
<textarea rows="8" cols="40" id="content" name="content"></textarea><br /><br />

<input name="button" type="button" value="写记事" onclick="javascript:check_submit();" />

</form>
</p>

<?php include APP_PATH.'/views/public/footer.tpl.php';?>
