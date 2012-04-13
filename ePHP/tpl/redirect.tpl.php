<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="<?php echo $wait;?>;URL=<?php echo $url;?>" />
<title>HTTP/1.1 301 Moved Permanently</title>
<style type="text/css">
body {background-color:	#fff; margin:40px;font-family: Consolas, Verdana, Arial, sans-serif;}
#content {border: 1px solid #E1E1E1;background-color:	#E8F3FF;padding:20px 20px 12px 20px;}
p{color:#000;font-size:13px;	}

#redirect{color:#999;}
</style>
</head>
<body>
<div id="content">
  <p><?php echo $message;?></p>
  <?php echo '<p id="redirect">'. $wait .' seconds later will be redirect, if not automatically jump, Please <a href="'. $url .'">click here</a>.</p>';?>

</div>
</body>
</html>