<?php

function dbg($var){
	echo"<br>";
	var_dump($var);
	exit();
}

function checkVar($var){
	echo"<br>";
	if(!isset($var)){
		echo"Variable is not set. <br>";
	}
	if(is_null($var)){
		echo"Variable is NULL. <br>";
	}
	if(!is_object($var) && is_nan($var)){
		echo"Variable is NAN. <br>";
	}
	if(is_object($var)){
		echo"Variable is OBJECT. <br>";
	}
	if(is_numeric($var)){
		echo"Variable is numeric. <br>";
	}
	if(is_integer($var)){
		echo"Variable is integer. <br>";
	}
	if(is_float($var)){
		echo"Variable is float. <br>";
	}
	if(is_bool($var)){
		echo"Variable is boolean. <br>";
	}
	if(is_array($var)){
		echo"Variable is array. <br>";
	}
}