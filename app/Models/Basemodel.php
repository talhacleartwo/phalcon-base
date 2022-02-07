<?php
namespace Models;

use Phalcon\Mvc\Model;
//use Phalcon\Collection;
use Plugins\UtilHelper;

class Basemodel extends Model
{
	public $createdon;
	public $createdby;
	public $modifiedon;
	public $modifiedby;
	public $deletedon;
	public $status;
	
	 use UtilHelper;

	public static function all($parameters = null)
	{
		$data = self::find($parameters = null);
		//$collection = new Collection($data->toArray());
		return $data;
	}


	public static function active($conditions = null, $bind = null)
	{
		
		if($conditions && $bind)
		{
			$conditions .= ' AND status = :basestatus: AND deletedon IS NULL';
			$bind['basestatus'] = 'Y';
			$data = self::find(['conditions' => $conditions, 'bind' => $bind]);
		}
		else
		{
			$data = self::find(['conditions' => 'status = :basestatus: AND deletedon IS NULL', 'bind' => ['basestatus' => 'Y']]);
		}			

		return $data;
	}
	
	public static function inactive($conditions = null, $bind = null)
	{
		
		if($conditions && $bind)
		{
			$conditions .= ' AND status = :basestatus: AND deletedon IS NULL';
			$bind['basestatus'] = 'N';
			$data = self::find(['conditions' => $conditions, 'bind' => $bind]);
		}
		else
		{
			$data = self::find(['conditions' => 'status = :basestatus: AND deletedon IS NULL', 'bind' => ['basestatus' => 'N']]);
		}			

		return $data;
	}
	
	public function softDelete() : bool
	{
		$this->deletedon = UtilHelper::dateTimeNow();
		return $this->save();
	}

	/*public static function collectionAll($parameters = null)
	{
		$data = self::find($parameters = null);
		$collection = new Collection($data->toArray());
		return $collection;
	}*/

	public function beforeValidationOnCreate()
	{		
		//Set Created By and Modified By
		$di = \Phalcon\DI::getDefault();
		$ident = $di->get('session')->get('auth-identity');
		$this->createdby = $ident['firstname'] . ' ' . $ident['lastname'];
		$this->modifiedby = $ident['firstname'] . ' ' . $ident['lastname'];
	}

	public function beforeValidationOnUpdate()
	{
		//Set Modified On
		$this->modifiedon = UtilHelper::dateTimeNow();
		
		//Set Modified By
		$di = \Phalcon\DI::getDefault();
		$ident = $di->get('session')->get('auth-identity');
		$this->modifiedby = $ident['firstname'] . ' ' . $ident['lastname'];
	}
	
	public static function findFirstById($id)
	{
		return self::findFirst(['conditions' => 'id = ?0', 'bind' => [ 0 => $id]]);
	}
	
	public function activate()
	{
		try{
			$this->status = 'Y';
			$this->save();
		}
		catch(\Exception $e)
		{
			return false;
		}
	}
	
	public function deactivate()
	{
		try{
			$this->status = 'N';
			$this->save();
		}
		catch(\Exception $e)
		{
			return false;
		}
	}
	
	public function statusLabel()
	{
		return $this->status === 'Y' ? 'Active' : 'Inactive';
	}
}

