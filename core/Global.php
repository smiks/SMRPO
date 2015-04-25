<?php

function dbg(...$args){
	foreach ($args as $key => $value) {
		echo"<br> {$key} => <br>";
		var_dump($value);
		echo"<br><hr>";
	}
	exit();
}