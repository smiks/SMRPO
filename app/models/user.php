<?php


require_once 'Model.php';

class user extends Model{

	/*
	* koda je zakomentirana ker je trenutno ni v uporabi
	* sem jo pa pustil ce bo hotel kdo si pogledat kako je kaj narjeno
	*/

	/*
	public function allKanbanMasters() {
		global $db;
		$q  = $db -> query("SELECT * FROM users WHERE permissions='0100';");
		$data = $db -> fetch_row($q);

		$podatki = array();

		while($r = $db -> fetch_row($q)){
			$key = $r['id'];
			$podatki[$key] = array("username" => $r['username'], "email" => $r['email']);
		}

		return ($podatki);

	}
	*/
	
	//funkcija, ki vrne stevilo vrstic v bazi, ki ustrezajo podanim podatkom
	//to bomo uporabili za preverjanje pravilnosti uporabniskega imena ter gesla ob prijavi oz za preverjanje, ce vneseno uporabnisko ime ze obstaja ob registraciji
	public function countUsersByInfo($email, $password = null)
	{
		global $db;
		
		if(is_null($password))
			$q  = $db -> query("SELECT COUNT(*) FROM users WHERE email LIKE ('{$email}');");
		else
			$q  = $db -> query("SELECT COUNT(*) FROM users WHERE email LIKE ('{$email}') AND password LIKE ('{$password}');");
		
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

		$q  = $db -> query("SELECT * FROM users WHERE id_user='{$id}' LIMIT 1;");
		$data = $db -> fetch_row($q);
		return ($data);
	}
}