<?php

/* TODO :: make page_settings more useful. Add (probably) cache registers */

/* Error Report Settings  */
	/* 0 - no report          */
	/* 1 - warnings only      */
	/* 2 - all errors         */	
	$_ERROR_REPORT = 1; 

/* Debug mode */
	$_DEBUG = false;

/* Allow registration or login */
	$_ALLOW_LOGIN = true;
	$_ALLOW_REGISTRATION = true;

/* Page statistics */
	$_PAGE_LOAD_TIME = false;
	$_NUM_QUERIES = false;


/* Toggle CSRF token */
	$_CSRF = true;


/* Previous page */
	$_RefererDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST); /* get domain from $_SERVER['HTTP_REFERER'] */

/* Private Key */
	$_PrivateKey = "framework";

/* Domain */
	$_http   = "http://"; // or https://
	$_Domain = "dev.smrpo.avatar-rpg.net";


if($_ERROR_REPORT== 1) 
{
	ini_set("display_errors", 1);
}
elseif($_ERROR_REPORT == 2) 
{
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
}


if($_DEBUG) {
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	$_PAGE_LOAD_TIME = true;
	$_NUM_QUERIES = true;
}