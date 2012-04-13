<?php
class t2Model extends model
{
	public function getOne()
	{
		return $this->where('id=4')->find('t_test');
	}
}
