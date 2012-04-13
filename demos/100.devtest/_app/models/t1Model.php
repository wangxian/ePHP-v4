<?php
class t1Model extends model
{
	public function getOne()
	{
		return $this->find('t_test');
	}
	
	function add_data($name)
	{
		$in['name'] = $name;
		return $this->table('t_test')->set($in)->insert();
	}
}