<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>CSS实现隔行变色的表格</title>
<style>
<!--
.datalist{
	border:1px solid #007108;	/* 表格边框 */
	font-family:Arial;
	border-collapse:collapse;	/* 边框重叠 */
	background-color:#d9ffdc;	/* 表格背景色 */
	font-size:14px;
}
.datalist th{
	border:1px solid #007108;	/* 行名称边框 */
	background-color:#00a40c;	/* 行名称背景色 */
	color:#FFFFFF;				/* 行名称颜色 */
	font-weight:bold;
	padding-top:4px; padding-bottom:4px;
	padding-left:12px; padding-right:12px;
	text-align:center;
}
.datalist td{
	border:1px solid #007108;	/* 单元格边框 */
	text-align:left;
	padding-top:4px; padding-bottom:4px;
	padding-left:10px; padding-right:10px;
}
.datalist tr.altrow{
	background-color:#a5e5aa;	/* 隔行变色 */
}
-->
</style>
</head>
<body>

<?php echo $this->data;?>

</body>
</html>