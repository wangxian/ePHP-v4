<?php include APP_PATH.'/views/public/header.tpl.php';?>

<h2><?php echo $this->data['title']?></h2>


<a href="<?php echo U('index/edit/id/'.$this->data['id']);?>">编辑</a>
<a href="<?php echo U('index/delete/id/'.$this->data['id']);?>" onclick="javascript:return confirm('您确定要删除吗？');">删除</a>
(<?php echo $this->data['updated_at']?>)

<pre class="important"><?php echo $this->data['content']?></pre>

<?php include APP_PATH.'/views/public/footer.tpl.php';?>
