<?php

class Model extends MysqlDAO {
	
	private static $models = array();
	public static $objects = array();
	
	function Model(){}
	
	public static function add_model($model){
		self::$models[] = $model;
	}
	
	public static function load_model($model){
		$file = MODEL_DIR."/$model.php";
		if(file_exists($file) && !in_array($model, self::$models)){
			include($file);
			self::$models[] = $model;
		}
	}
	
	public static function load(array $models){
		foreach($models as $model){
			self::load_model($model);
		}
	}
	
	public static function add_object($model, $object){
		self::$objects[$model] = $object;
	}
	
	protected function _check_get_value(&$data, $name){
		if(is_object($data)){
			return $data->$name;
		}
		else if(is_array($data)){
			return $data[$name];
		}
	}
	
	protected function _check_set_value(&$data, $name, $value){
		if(is_object($data)){
			$data->$name = $value;
		}
		else if(is_array($data)){
			$data[$name] = $value;
		}
	}
	
	public function check(&$data, array $check_arrays, array $ignore = array()){
		$must_need = $check_arrays['need'];
		$length_check = $check_arrays['length'];
		$must_int = $check_arrays['int'];
		$must_number = $check_arrays['number'];	//int or double
		$mobile = $check_arrays['mobile'];
		$phone = $check_arrays['phone'];
		$email = $check_arrays['email'];
		if(is_array($ignore) && count($ignore) > 0){
			$must_need = array_diff($must_need, $ignore);
			$length_check = array_diff($length_check, $ignore);
			$must_int = array_diff($must_int, $ignore);
			$email = array_diff($email, $ignore);
		}
		$error = array();
		if($must_need){
			foreach($must_need as $field){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && strlen($v) == 0){
					$error[$field] = "不能为空";
				}
			}
		}
		if($length_check){
			foreach($data as $field => $value){
				if($length_check && !array_key_exists($field, $length_check)){
					$v = $this->_check_get_value($data, $field);
					if(empty($error[$field]) && utf8_strlen($v) > 250){
						$error[$field] = "不能超过250个字符";
					}
				}
			}
			foreach($length_check as $field => $length){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && utf8_strlen($v) > $length){
					$error[$field] = "不能超过{$length}个字符";
				}
			}
		}
		if($must_int){
			$must_int[] = 'id';
			foreach($must_int as $field){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && strlen($v) > 0){
					if($v != '0'){
						$r = intval($v);
						if("$r" != $v){
							$error[$field] = "不是整数";
							continue;
						}
					}
					$this->_check_set_value($data, $field, 
								intval($this->_check_get_value($data, $field)));
				}
			}
		}
		if($must_number){
			foreach($must_number as $field){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && strlen($v) > 0){
					if($v != '0'){
						$r = doubleval($v);
						if($r == 0){
							$error[$field] = "格式不正确";
							continue;
						}
					}
					$this->_check_set_value($data, $field, 
								intval($this->_check_get_value($data, $field)));
				}
			}
		}
		if($mobile){
			foreach($mobile as $field){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && strlen($v) > 0){
					if(!CheckUtils::check_mobile($v)){
						$error[$field] = "手机格式不正确";
					}
				}
			}
		}
		if($phone){
			foreach($phone as $field){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && strlen($v) > 0){
					if(!CheckUtils::check_phone($v, 1)){
						$error[$field] = "电话格式不正确";
					}
				}
			}
		}
		if($email){
			foreach($email as $field){
				$v = $this->_check_get_value($data, $field);
				if(empty($error[$field]) && strlen($v) > 0){
					if(!CheckUtils::check_email($v)){
						$error[$field] = "邮箱格式不正确";
					}
				}
			}
		}
		return $error;
	}
	
	public function escape(&$data, array $escape_array, array $ignore){
		$url = $escape_array['url'];
		$string = $escape_array['string'];
		$html = $escape_array['html'];
		if(is_array($ignore) && count($ignore) > 0){
			$url = array_diff($url, $ignore);
			$string = array_diff($string, $ignore);
			$html = array_diff($html, $ignore);
		}
		if($string){
			foreach($string as $field){
				$v = $this->_check_get_value($data, $field);
				if($v){
					$v = esc_text($v);
					$this->_check_set_value($data, $field, $v);
				}
			}
		}
		if($url){
			foreach($url as $field){
				$v = $this->_check_get_value($data, $field);
				if($v){
					$v = esc_html($v);
					$v = esc_url($v);
					$this->_check_set_value($data, $field, $v);
				}
			}
		}
		if($html){
			foreach($html as $field){
				$v = $this->_check_get_value($data, $field);
				if($v){
					$v = addslashes($v);
					$this->_check_set_value($data, $field, $v);
				}
			}
		}
	}
	
	public function format(array $format_array){
		$string = $format_array['string'];
		$url = $format_array['url'];
		$html = $format_array['html'];
		if($string){
			foreach($string as $field){
				$v = $this->$field;
				if($v){
					$this->$field = esc_attr($v);
				}
			}
		}
		if($url){
			foreach($url as $field){
				$v = $this->$field;
				if($v){
					$v = esc_textarea($v);
					$v = esc_url($v);
					$this->$field = $v;
				}
			}
		}
		if($html){
			foreach($html as $field){
				$v = $this->$field;
				if($v){
					$this->$field = esc_textarea($v);
				}
			}
		}
	}
	
}

