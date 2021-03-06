<?php


require_once 'Model.php';

class user extends Model{

	/* construction and helper functions */
	public function __construct() {

	}

	private static function cleanInput($value)
	{
		$replace     = array("'",'"','<','>','\\');
		$replacement = array("&#39;",'&quot;','&lt;','&gt;','&#092;');
		$outputVal   = str_replace($replace, $replacement, $value);
		return $outputVal;
	}

	/* other functions ordered by name asc */

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

	public function deleteUser($userid){
		global $db;
		$db -> query("UPDATE User SET active=0 WHERE id_user='{$userid}' LIMIT 1;");
		return true;
	}

	public function exists($parameter, $table){
		global $db;
		$pName  = $parameter[0];
		$pValue = $parameter[1];
		$sql 	="SELECT COUNT(*) FROM {$table} WHERE {$pName} = '{$pValue}' LIMIT 1;";
		$q = $db -> query($sql);
		$exists = $db -> fetch_single($q);
		if($exists == 1)
		{
			return true;
		}
		return false;
	}

	public function getAllUsers(){
		return $this->sql("SELECT * FROM User WHERE active=1 ORDER BY name ASC, surname ASC", $return = "array", $key ="id_user");
	}

	//funkcija, ki za vlogo (razvijalec, product owner ali KM) vrne vse uporabnike z 탑elenimi ability-ji
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

	public function insertUser($userid, $data){
		global $db;
		$sql 	= "INSERT INTO User (<INSERT> active) VALUES (<VALUES> '1');";
		$insert = "";
		$values = "";
		foreach ($data as $key => $value) {
			$value = $this->cleanInput($value);
			$insert .= $key.", ";
			$values .= "'{$value}', ";
		}
		$sql = str_replace("<INSERT>", $insert, $sql);
		$sql = str_replace("<VALUES>", $values, $sql);
		
		$db -> query($sql);

		return true;
	}

	//funkcija, ki preveri, ce ima vneseni uporabnik pravice administratorja
	public function isAdmin($userID)
	{
		global $db;
		$q  = $db -> query("SELECT COUNT(*) FROM User WHERE id_user =('{$userID}') AND administrator='1' LIMIT 1;");

		$isAdmin = $db -> fetch_single($q);

		if ($isAdmin != 0)
			return true;

		return false;		
	}

	//funkcija, ki preveri, ce ima vneseni uporabnik pravice za kreiranje skupine - KM
	public function isKanbanMAster($userID)
	{
		global $db;
		$q  = $db -> query("SELECT COUNT(*) FROM User WHERE id_user =('{$userID}') AND abilities LIKE ('_1_') AND active=1;");

		$isKM = $db -> fetch_single($q);

		if ($isKM != 0)
			return true;

		return false;		
	}

	public function lastUserID(){
		global $db;
		$sql 	="SELECT id_user FROM User ORDER BY id_user DESC LIMIT 1;";
		$q = $db -> query($sql);
		$lastID = $db -> fetch_single($q);
		return $lastID;
	}

	public function lockUser($email){
		global $db;
		$sql 	="UPDATE User SET locked = 1 WHERE email LIKE ('{$email}') LIMIT 1;";
		$q = $db -> query($sql);
	}

	public function resetFailedLoginAttempt($email){
		global $db;
		$sql 	="UPDATE User SET num_invalid_login = 0 WHERE email LIKE ('{$email}') LIMIT 1;";
		$q = $db -> query($sql);
	}

	public function updateFailedLoginAttempt($email){
		global $db;
		$sql 	="UPDATE User SET num_invalid_login = num_invalid_login + 1 WHERE email LIKE ('{$email}') LIMIT 1;";
		$q = $db -> query($sql);
	}

	public function updateUser($userid, $data){
		global $db;
		$sql = "UPDATE User SET <SET> WHERE id_user='{$userid}' LIMIT 1;";
		$set = "";
		foreach ($data as $key => $value) {
			$value = $this->cleanInput($value);
			$set .= $key." = '".$value."', ";
		}
		$set = substr($set, 0, strlen($set)-2);
		$sql = str_replace("<SET>", $set, $sql);
		
		$db -> query($sql);

		return true;
	}

	public function userInfoByEmail($email){
		global $db;
		$q  = $db -> query("SELECT * FROM User WHERE email LIKE ('{$email}') LIMIT 1;");
		$data = $db -> fetch_row($q);
		return ($data);
	}


	public function userInfoByID($id){
		global $db;
		$q  = $db -> query("SELECT * FROM User WHERE id_user='{$id}' LIMIT 1;");
		$data = $db -> fetch_row($q);
		return ($data);
		if($id == 0){
			return array();
		}


		return ($ret);
	}	

}
