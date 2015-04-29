<?php

class Functional {

	public function __construct(){
	}


	public static function head($array = array())
	{
		$aLen = count($array);
		if($aLen > 0){
			return ($array[0]);
		}
		return (null);
	}

	public static function tail($array = array())
	{
		$aLen = count($array);
		if($aLen < 2){
			return (null);
		}
		return (array_slice($array, 1));
	}

}