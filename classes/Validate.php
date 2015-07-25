<?php

	class Validate {

		private $_passed = false,
				$_errors = array(),
				$_db = null;

		public function __construct() {
			$this->_db = DB::getInstance();																			//set instance of DB
		}

		public function check($source, $items = array()) {
			
			foreach($items as $item => $rules) {																	//for each specified item (input) and it's rule

				foreach($rules as $rule => $rule_value) {															//for each rule's value
					
					$value = trim($source[$item]);																	//set value to input's value
					$item = escape($item);																			//escape the value (security purposes)

					if ($rule === 'required' && empty($value)) {													//if rule is required
						$this->addError("{$item} is required"); 													//add the error
					} 

					else if (!empty($value)) {																		//else if value isn't empty

						switch($rule) {

							case 'min':																				//check for minimum char length

								if(strlen($value) < $rule_value) {													//if length is less than rule_vale (min length)
									$this->addError("{$item} must be a minimum of {$rule_value} characters");		//add error
								}

							break;

							case 'max':																				//check for minimum char length

								if(strlen($value) > $rule_value) {													//if length is less than rule_vale (min length)
									$this->addError("{$item} must be a maximum of {$rule_value} characters");		//add error
								}

							break;

							case 'matches':																			//check for match value

								if($value != $source[$rule_value]) {												//if value doesn't match rule_value (the name of another input)
									$this->addError("{$rule_value} must match {$item}");							//add error
								}

							break;

							case 'unique':																			//check for unique value in database

								$check = $this->_db->get($rule_value, array($item, '=', $value));					//set check to the return of a search where item is value
								if($check->count()) {																//if the check has a count (exists)
									$this->addError("{$item} already exists");										//add error
								}

							break;
						}
					}
				}
			}

			if(empty($this->_errors)) {																				//if private errors are empty
				$this->_passed = true;																				//set private passed to true
			}

			return $this;
		}

		private function addError($error) {
			$this->_errors[] = $error;																				//append error to private error array
		}

		public function errors() {
			return $this->_errors;																					//return private error array
		}

		public function passed() {
			return $this->_passed;																					//return private passed
		}

	}