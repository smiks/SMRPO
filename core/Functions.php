<?php

class Functions {

	public function __construct(){
	}


	/*  Functions are sorted by name ASC  */

	public static function input($type="ALL"){
		if(strtoupper($type) == "GET"){
			return $_GET;
		}
		elseif(strtoupper($type) == "POST"){
			return $_POST;
		}
		elseif(strtoupper($type) == "ALL"){
			return array("GET" => $_GET, "POST" => $_POST);
		}
		return array(0);
	}


	public static function redirect($toUrl) {
		header("Location: {$toURL}");
	}


	public static function reload($toUrl, $time=0) {
		header("refresh:{$time};url={$toUrl}"); 
	}	
}