<?php $this->_block('css'); ?>
<style></style>
//css here
<?php $this->_endblock(); ?>

<h1>视图block测试</h1>

<?php $this->_include('public/menu');?>

<?php $this->_block('main'); ?>
<div id="main">
	<?php $this->_block('left'); ?>
	<span style="color: green">here is left bock. default<span><hr />
	<?php $this->_endblock(); ?>

	<?php $this->_block('right'); ?>
	<span style="color: red">here is right bock. default<span><hr />
	<?php $this->_endblock(); ?>
</div>
<?php $this->_endblock(); ?>

