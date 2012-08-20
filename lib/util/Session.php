<?php

class Session{
	
	public function __construct(){
		session_start();
	}
	
	public function exist(){
		return isset($_SESSION[$key]);
	}
	
	public function get($key){
		return $_SESSION[$key];
	}
	
	public function set($key, $value){
		$_SESSION[$key] = $value;
	}
	
}