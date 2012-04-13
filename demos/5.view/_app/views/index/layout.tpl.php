<?php $this->_extends('public/default');?>

<?php $this->_block('right'); ?>
<span style="color: red">here is right bock. reload<span><hr />
<?php $this->_endblock(); ?>

<?php $this->_block('left'); ?>
	<?php echo $name;echo $this->name;?><br />
	<span style="color: green">here is left bock. reload<span><hr />

<?php $this->_endblock(); ?>
