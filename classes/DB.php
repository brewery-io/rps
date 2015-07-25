<?php

	class DB {
		private static $_instance = null;
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;

		private function __construct() {

			try {																			//try to establish connection with specified db
				$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
			}

			catch(PDOException $e) {														//return and die with error
				die($e->getMessage());
			}
		}

		public static function getInstance() {

			if (!isset(self::$_instance)) {													//if instance of PDO connection doesn't exist
				self::$_instance = new DB();												//create a new one
			}

			return self::$_instance;
		}

		public function query($sql, $params = array()) {

			$this->_error = false;

			if($this->_query = $this->_pdo->prepare($sql)) {								//if query prepares successfully

				$x = 1;																		//set counter

				if(count($params)) {														//if there are paramaters

					foreach($params as $param) {

						$this->_query->bindValue($x, $param);								//bind paramaters for each "?" in query
						$x++;																//increment

					}
				}

				if($this->_query->execute()) {												//if query executes

					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);				//set results PDO object result
					$this->_count = $this->_query->rowCount();								//set count to number of results

				}

				else {
					$this->_error = true;													//set error to true
				}
			}

			return $this;
		}

		public function action($action, $table, $where = array()) {

			if(count($where) === 3) {														//if array used in calling class has 3 paramaters ex: array( "field", "=", "value" )

				$operators = array('=');													//allowable operators, only = needed for now, if search was implemented, LIKE can be used

				$field 		= $where[0];													//sets array values to variables
				$operator 	= $where[1];
				$value 		= $where[2];

				if(in_array($operator, $operators)) {										//if operator is allowable type

					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";			//prepare raw sql query

					if(!$this->query($sql, array($value))->error()) {						//execute query
						return $this;
					}
				}
			}

			return false;
		}

		public function get($table, $where) {
			return $this->action("SELECT *", $table, $where);								//call action with select
		}

		public function delete($table, $where) {
			return $this->action("DELETE", $table, $where);									//call action with delete, not necessary atm
		}

		public function insert($table, $fields = array()) {

			if(count($fields)) {															//if fields are specified

				$keys = array_keys($fields);												//get the keys
				$values = '';
				$x = 1;

				foreach($fields as $field) {												//loop through all fields

					$values .= '?';															//append "?" at end of query for each field

					if($x < count($fields)) {												//if there are more fields
						$values .= ', ';													//add separator
					}

					$x++;
				}
																							//prep query
				$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

				if(!$this->query($sql, $fields)) {											//if query is successful
					return true;															//return true
				}
			}

			return false;
		}

		public function update($table, $id, $fields) {

			$set = '';
			$x = 1;

			foreach($fields as $name => $value) {											//for each field as field's value

				$set .= "{$name} = ?";														//set field name = ?

				if($x < count($fields)) {													//if there are more fields
					$set .= ', ';															//set deliminator
				}

				$x++;																		//increment
			}

			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";							//set query

			if(!$this->query($sql, $fields)->error()) {										//if no error
				return true;																//return true
			}

			return false;
		}

		public function results() {
			return $this->_results;															//return private results
		}

		public function first() {
			return $this->results()[0];														//return first row of private results
		}

		public function error() {
			return $this->_error;															//return private error
		}

		public function count() {
			return $this->_count;															//return private count (of rows)
		}

	}