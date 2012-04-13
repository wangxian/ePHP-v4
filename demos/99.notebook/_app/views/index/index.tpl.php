<?php include APP_PATH.'/views/public/header.tpl.php';?>

<?php if($this->data['data_count']):?>
<ul id="list_note">
<?php foreach ($this->data['data'] as $v):?>

<li>
<a href="<?php echo U('index/detail/id/'.$v['id'])?>" title="" class="title"><?php echo $v['title']?></a>

<a href="<?php echo U('index/edit/id/'.$v['id']);?>">编辑</a>
<a href="<?php echo U('index/delete/id/'.$v['id']);?>" onclick="javascript:return confirm('您确定要删除吗？');">删除</a>
(<?php echo $v['updated_at']?>)
</li>


<?php endforeach;?>
</ul>
<?php echo $this->pagelink;?>
<?php endif;?>

<?php include APP_PATH.'/views/public/footer.tpl.php';?>
