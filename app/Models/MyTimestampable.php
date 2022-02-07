<?php
namespace Models;

trait MyTimestampable {
	
	public function beforeCreate()
	{
		$dt = new \DateTime();
		$this->createdAt = $dt->format('Y-m-d H:i:s');
	}
	
	public function beforeUpdate()
	{
		$dt = new \DateTime();
		$this->modifiedAt = $dt->format('Y-m-d H:i:s');
	}
}

