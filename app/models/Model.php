<?php


class Model {

	private $table;
	private $_sql;
	private $usedOrAnd;

	/* function returns ID of insert */
	public function insertID($sql){
		global $c;
		mysqli_query($c, $sql);
		$id = mysqli_insert_id($c);
		return $id;
	}

	public function sql($sql, $return="array", $key=null){
		global $db;
		$q  = $db -> query($sql);
		if($return == "single"){
			return $db -> fetch_single($q);
		}
		elseif($return == "array"){
			$acc = array();

			while($r = $db -> fetch_row($q)){
				if(array_key_exists($key, $r)){
					$k = $r[$key];
					$acc[$k] = $r;
				}
				else{
					throw new Exception("SQL_ARRAY_KEY_NOTFOUND");
				}
			}
			return $acc;
		}
		else{
			throw new Exception("SQL_ARRAY_RETURN_METHOD_NOTFOUND");
		}

	}

	public function orm(){
		$this->_sql = "SELECT <select> FROM <from>";
		return $this;
	}

	public function table($table){
		$sl = $this->_sql;
		$sl = str_replace("<from>", $table, $sl);
		$this->_sql = $sl;
		return $this;
	}

	public function select($select){
		$sl = $this->_sql;
		$sl = str_replace("<select>", $select, $sl);
		$this->_sql = $sl;
		return $this;
	}

	public function where($what, $op, $toWhat){
		$sl = $this->_sql;
		$sl .= "<where>";
		if($this->usedOrAnd){
			$sentence = " {$what} {$op} '{$toWhat}' ";
		}
		else{
			$sentence = " WHERE {$what} {$op} '{$toWhat}' ";	
		}
		
		$sl = str_replace("<where>", $sentence, $sl);
		$this->_sql = $sl;
		return $this;
	}

	public function whereAnd($what, $op, $toWhat){
		$sl = $this->_sql;
		$sl .= "<where>";
				if($this->usedOrAnd){
			$sentence = " {$what} {$op} '{$toWhat}' AND ";
		}
		else{
			$sentence = " WHERE {$what} {$op} '{$toWhat}' AND ";	
		}
		$sl = str_replace("<where>", $sentence, $sl);
		$this->_sql = $sl;
		$this->usedOrAnd = true;
		return $this;
	}

	public function whereOr($what, $op, $toWhat){
		$sl = $this->_sql;
		$sl .= "<where>";
				if($this->usedOrAnd){
			$sentence = " {$what} {$op} '{$toWhat}' OR ";
		}
		else{
			$sentence = " WHERE {$what} {$op} '{$toWhat}' OR ";	
		}
		$sl = str_replace("<where>", $sentence, $sl);
		$this->_sql = $sl;
		$this->usedOrAnd = true;
		return $this;
	}

	public function limit($limit){
		$sl = $this->_sql;
		$sl .= "<limit>";
		$sentence = " LIMIT {$limit} ";
		$sl = str_replace("<limit>", $sentence, $sl);
		$this->_sql = $sl;
		return $this;
	}	

	public function toSql(){
		return $this->_sql;
	}

	public function fetchRow(){
		global $db;
		$sl = $this->_sql;
		$sl .= ";";
		$q  = $db -> query($sl);
		$data = $db -> fetch_row($q);
		return ($data);
	}

	public function fetchSingle(){
		global $db;
		$sl = $this->_sql;
		$sl .= ";";
		$q  = $db -> query($sl);
		$data = $db -> fetch_single($q);
		return ($data);
	}

	public function __construct() {

	}


}