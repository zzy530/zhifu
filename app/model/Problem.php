<?php

class Problem extends AppModel{

	public $table = 'problems';
	
	public function check(&$data, array $ignore = array()){
		$check_arrays = array(
			'need' => array('title', 'company', 'cat', 'subcat', 'budget'),
			'length' => array('title'=>250),
			'int' => array('company', 'cat', 'subcat', 'budget'),
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

}