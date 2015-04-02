<?php

class Cache {

	protected $cache;

	public function __construct(){
		$this -> cache = array();
	}

	public function setValue($key, $value) {
		$this->cache[$key] = $value;
	}

	public function unsetValue($key) {
		$this->cache[$key] = null;
	}

	public function getValue($key) {
		return $this->cache[$key];
	}
}