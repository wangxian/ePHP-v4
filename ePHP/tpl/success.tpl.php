<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
body{ font: 12px/22px "Microsoft Yahei", "Consolas",Tahoma, Geneva, sans-serif;background-color: #f2f2f2;letter-spacing:1px;}
#content{margin: 50px auto;width: 650px; background-color: #FFFFFF; border-radius: 8px;border: 1px solid #dddddd;}
h2{font-size: 24px; color: #262626; margin: 40px 0 20px 40px;}
#message{ margin: 0 0 40px 40px; color:#999;}

#redirect{margin: 0 0 40px 0; padding: 18px 0 18px 40px;background-color: #f1fafe;border-top: 1px solid #dae3ea;border-bottom: 1px solid #dae3ea;}
#redirect a{color: #185787;}
#redirect em {color:red;}
</style>
</head>
<body>
<div id="content">
  <h2>Successful Operation - 200</h2>
  <p id="message"><?php echo $message;?></p>
  <?php if($url):?>
  <p id="redirect">
      <img src="data:image/gif;base64,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" align="absmiddle" />
      <em><?php echo $wait;?></em> 秒后自动跳转, 如果没有自动跳转请
      <a href="javascript:R();">Click here to go back</a>.
  </p>
  <?php endif;?>
</div>

<script type="text/javascript">
var $wait = <?php echo $wait;?>;
var R = function() {<?php if($url) echo "window.location.href=\"{$url}\"";?>};
if(document.getElementById("redirect")){
    var WD = function(){
        $wait--;
        if(!$wait) R();
        var $wt = document.getElementById("redirect").getElementsByTagName("em")[0].firstChild;
        $wt.nodeValue = $wait;
        setTimeout("WD()",1000);
    }
    setTimeout("WD()",1000);
}
</script>
</body>
</html>