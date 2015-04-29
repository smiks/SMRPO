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

	/* Wrappers for integrated PHP functions (because of consistency and easier usage)*/
	public static function map($function, $array)
	{
		return (array_map($function, $array));
	}

	public static function reduce($function, $array)
	{
		return (array_reduce($array, $function));
	}

	public static function filter($function, $array)
	{
		return (array_filter($array, $function));
	}

	public static function merge($array1, $array2)
	{
		return (array_merge($array1, $array2));
	}

}