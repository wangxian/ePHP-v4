<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
<h1>不定义控制器，渲染视图</h1>
<p>没有控制器和ACTION，如果对应的视图存在，自动加载该视图。</p>
<p>方便开发初期的开发和渲染静态视图。</p>
<ul>
  <li><a href="<?= U("dir1") ?>">/dir1.html</a></li>
  <li><a href="<?= U("dir2/info") ?>">/dir2/info.html</a></li>
</ul>
</body>
</html>