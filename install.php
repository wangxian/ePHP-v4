<?php
header('Content-Type: text/html;charset=UTF-8');

$conn = new mysqli(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB, SAE_MYSQL_PORT);

$sql = file_get_contents('demos/demos.sql');
$ret = $conn->multi_query($sql);


echo '<h1>数据库初始化完成.</h1> <br />';
var_dump($ret);
echo '<br />';
echo '<a href="/">开始ePHP之旅</a> 吧!';