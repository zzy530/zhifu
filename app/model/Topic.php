<?php

class Topic extends AppModel{

	public $table = 'topics';
	
	public function check(&$data, array $ignore = array()){
		$check_arrays = array(
			'need' => array('title', 'content', 'parent', 'belong', 'type'),
			'length' => array('title'=>250),
			'int' => array('parent', 'belong'),
			'word' => array('title', 'content')
		);
		$errors = &parent::check($data, $check_arrays, $ignore);
		return $errors;
	}
	
	public function escape(&$data, array $ignore = array()){
		$escape_array = array(
			'string'=>array('title','content'),
			'url'=>array(),
			'html'=>array()
		);
		return parent::escape($data, $escape_array, $ignore);
	}

}