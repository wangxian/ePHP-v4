<h1 style="color:red;">下面的内容没有被缓存</h1>
<p>
my name is <!--{echo $this->myname;}--><br />
Now: <!--{echo date('Y-m-d H:i:s');}-->
</p>

<h1 style="color:red;">下面的内容被缓存了</h1>
<p style="color:blue;">缓存生成时间: <?php echo date('Y-m-d H:i:s');?></p>
<?php echo $this->content;?>