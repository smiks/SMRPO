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

	/* returns date in SQL format yyyy-mm-dd */
	public static function dateDB(){
		$day = date('d');
		$month = date('m');
		$year  = date('Y');

		$date = $year."-".$month."-".$day;

		return ($date);
	}

	public static function dateTime(){
		return (date("H:i, d/M, Y"));
	}

	/* creates internal link. Example: domain.com/?page.... */
	public static function internalLink($url){
		global $_Domain, $_http;
		$internalLink = $_http.$_Domain."/".$url;
		return ($internalLink);
	}
	

	public static function forceLogin(){
		if($_SESSION['loggedin'] == 0 || !isset($_SESSION['loggedin'])){
			Functions::redirect(Functions::internalLink("?page=main"));
		}
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

	public static function splitText($text, $splitAt)
	{
		if(strlen($text) < $splitAt){
			return ($text);
		}
		return self::splitTextHelper($text, $splitAt, "");
	}

	private static function splitTextHelper($text, $splitAt, $acc)
	{
		$textLen = strlen($text);
		if($textLen > $splitAt){
			$space = strpos($text, ' ', $splitAt);
		}
		else{
			return $acc.$text;
		}
		
		if($textLen > $splitAt && $space > 0){
			$partA  = substr($text, 0, $space);
			$partB .= substr($text, $space);
			$partA  = $partA."<br>";
			$acc    = $acc.$partA;
			return self::splitTextHelper($partB, $splitAt, $acc);
		}
		if($textLen > $splitAt && $space == 0){
			$text  = substr($text, 0, $splitAt);
			$text .= "...";
			return ($text);
		}
	}
}