<?php


require_once 'Model.php';

class user extends Model{

	//funkcija, ki vrne stevilo vrstic v bazi, ki ustrezajo podanim podatkom
	//to bomo uporabili za preverjanje pravilnosti uporabniskega imena ter gesla ob prijavi oz za preverjanje, ce vneseno uporabnisko ime ze obstaja ob registraciji
	public function countUsersByInfo($email, $password = null)
	{
		global $db;
		
		if(is_null($password))
			$q  = $db -> query("SELECT COUNT(*) FROM User WHERE email LIKE ('{$email}') AND active=1;");
		else
			$q  = $db -> query("SELECT COUNT(*) FROM User WHERE email LIKE ('{$email}') AND password LIKE ('{$password}') AND active=1;");
		
		$data = $db -> fetch_single($q);
		return ($data);
	}
	
	public function __construct() {

	}


	public function userInfoByID($id=0){
		global $db;

		if($id == 0){
			return array();
		}

		$q  = $db -> query("SELECT * FROM User WHERE id_user='{$id}' LIMIT 1;");
		$data = $db -> fetch_row($q);
		return ($data);
	}


	public function getAllUsers(){
		return $this->sql("SELECT * FROM User WHERE active=1 ORDER BY name ASC, surname ASC", $return = "array", $key ="id_user");
	}

	public function isKanbanMAster($userId)
	{
		global $db;
		$q  = $db -> query("SELECT COUNT(*) FROM User WHERE id_user =('{$userId}') AND abilities LIKE ('_1_') AND active=1;");

		$isKM = $db -> fetch_single($q);

		if ($isKM != 0)
			return true;

		return false;		
	}


	public function getAllUsersWithAbilities ($role)
	{
		global $db;
		
		preg_match('/1\d\d/', $role, $matches);

		if (sizeOf($matches) > 0){
			$ret = $this->sql("SELECT * FROM User WHERE abilities LIKE ('1__') AND active=1;", $return = "array", $key ="id_user");
		}
		else
		{
			preg_match('/\d\d1/', $role, $matches);
			if (sizeOf($matches) > 0)
			$ret = $this->sql("SELECT * FROM User WHERE abilities LIKE ('__1') AND active=1;", $return = "array", $key ="id_user");
		}

		return ($ret);
	}

	public function deleteUser($userid){
		global $db;
		$db -> query("UPDATE User SET active=0 WHERE id_user='{$userid}' LIMIT 1;");
		return true;
	}
}
