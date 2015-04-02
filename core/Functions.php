<?php

class Functions {

	public function __construct(){
	}

	/*  Functions are sorted by name ASC  */

	private static function cleanInput($value)
	{
		$replace     = array("'",'"','<','>','\\');
		$replacement = array("&#39;",'&quot;','&lt;','&gt;','&#092;');
		$outputVal   = str_replace($replace, $replacement, $value);
		return $outputVal;
	}

	public static function input($type="ALL"){
		if(strtoupper($type) == "GET"){
			$ret = Functions::cleanInput($_GET);
			return $ret;
		}
		elseif(strtoupper($type) == "POST"){
			$ret = Functions::cleanInput($_POST);
			return $ret;
		}
		elseif(strtoupper($type) == "ALL"){
			$retGet  = Functions::cleanInput($_GET);
			$retPost = Functions::cleanInput($_POST);
			return array("GET" => $retGet, "POST" => $retPost);
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