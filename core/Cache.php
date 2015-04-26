<?php

class Cache {

	protected $cache;

	public function __construct(){
		$this -> cache = array();
	}

	private static function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
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

	public static function store($key, $value) {
		global $_PrivateKey;
		$file = "cache/".$key.".cache";
		$fh  = fopen($file, "w");

		/* Create the initialization vector for added security. */
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), 1);

		$encrypted_value = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $_PrivateKey, $value, MCRYPT_MODE_CBC, $iv);

		/* store value and IV */
		$iv = base64_encode($iv);
		$encrypted_value = base64_encode($encrypted_value);
		$store = "<iv>{$iv}</iv><val>{$encrypted_value}</val>";

		fwrite($fh, $store);

		fclose($fh);
	}

	public static function load($key) {
		global $_PrivateKey;
		$file = "cache/".$key.".cache";
		$fh  = fopen($file, "r");
		$content = fgets($fh);

		$encrypted_value = Cache::get_string_between($content, "<val>", "</val>");
		$iv = Cache::get_string_between($content, "<iv>", "</iv>");
		$encrypted_value = base64_decode($encrypted_value);
		$iv = base64_decode($iv);

		$decrypted_value = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $_PrivateKey, $encrypted_value, MCRYPT_MODE_CBC, $iv);

		fclose($fh);

		return ($decrypted_value);
	}

	public static function keyExists($key) {
		$file = "cache/".$key.".cache";
		return file_exists($file);
	}
}