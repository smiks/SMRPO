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