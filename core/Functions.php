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


	/* creates internal link. Example: domain.com/?page.... */
	public function internalLink($url){
		global $_Domain, $_http;
		$internalLink = $_http.$_Domain."/".$url;
		return ($internalLink);
	}
	
	/* Function returns client's IP address */
	public static function getClientIP()
	{
		if (isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			return $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
		{
			return $_SERVER["HTTP_X_FORWARDED"];
		}
		elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_FORWARDED"]))
		{
			return $_SERVER["HTTP_FORWARDED"];
		}
		else
		{
			return $_SERVER["REMOTE_ADDR"];
		}
	}
		
	/* Function generates hash of given plain text (one way hash function) */
	public static function hashing($plainText, $salt="A!$%csa132_-s", $numIterations=10000)
	{
		$i = 1;
		$hash = hash('haval256,3', $plainText.$salt, false);
		while($i <= $numIterations)
		{
			$hash = hash('haval256,4', $hash.$salt, false);
			$len  = strlen($hash);
			$size = $len%$i;
			$salt = substr(sha1($hash), 0, $size);
			$hash = hash("haval256,5", $hash.$salt, false);
			$i++;
		}

		return ($hash.$salt);
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
		header("Location: {$toUrl}");
	}

	public static function reload($toUrl, $time=0) {
		header("refresh:{$time};url={$toUrl}"); 
	}	
}