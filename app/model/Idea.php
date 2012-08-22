<?php

class Idea extends AppModel{

	public $table = 'ideas';
	
	public function check(&$data, array $ignore = array()){
		$check_arrays = array(
			'need' => array('title', 'company', 'budget', 'description'),
			'length' => array('title'=>250),
			'int' => array('one', 'two', 'three'),
			'number' => array('budget', 'one_m', 'two_m', 'three_m'),
			'word'=> array('title', 'description'),
		);
		$errors = &parent::check($data, $check_arrays, $ignore);
		return $errors;
	}
	
	public function escape(&$data, array $ignore = array()){
		$escape_array = array(
			'string'=>array('title'),
			'url'=>array(),
			'html'=>array('description')
		);
		return parent::escape($data, $escape_array, $ignore);
	}
	
	public static function default_image(){
		return IMAGE_HOME.'/default.jpg';
	}
	
	public static function get_status($status){
		if($status == 0){
			return '竞标中';
		}
	}

}