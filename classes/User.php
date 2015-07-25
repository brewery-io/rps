<?php

	class User {

		private $_db,
				$_data,
				$_sessionName,
				$_cookieName,
				$_isLoggedIn;

		public function __construct($user = null) {

			$this->_db = DB::getInstance();																			//get instance of DB
			$this->_sessionName = Config::get('session/session_name');												//get default session array name
			$this->_cookieName = Config::get('remember/cookie_name');												//get default remember cookie name

			if(!$user) {																							//if user is not set

				if(Session::exists($this->_sessionName)) {															//if the default session exists

					$user = Session::get($this->_sessionName);														//set user (id) to the value of default session

					if($this->find($user)) {																		//find the user with this id
						$this->_isLoggedIn = true;																	//set private variable isLoggedIn to true
					}

					else {
						$this->logout();																			//if not, log out
					}
				}				
			}

			else {
				$this->find($user);																					//if user is set, find user
			}
		}

		public function update($fields = array(), $id = null) {

			if(!$id && $this->isLoggedIn()) {																		//if no id is set, and user is logged in
				$id = $this->data()->id;																			//set id to user's id
			}

			if(!$this->_db->update('users', $id, $fields)) {														//if update doesn't run
				throw new Exception('There was a problem updating. ');												//throw user an exception
			}
		}

		public function create($fields = array()) {

			$this->_db->insert('users', $fields);																	//if insert doesn't run
		}

		public function find($user = null) {

			if($user) {																								//if user is set

				$field = (is_numeric($user)) ? 'id' : 'username';													//if user is a number, set field to id, else set it to username
				$data = $this->_db->get('users', array($field, '=', $user));										//set data to the result of search for user

				if($data->count()) {																				//if data has a count (exists)

					$this->_data = $data->first();																	//set private data to the first row
					return true;
				}
			}

			return false;
		}

		public function login($username = null, $password = null, $remember = true) {

			if(!$username && !$password && $this->exists()) {														//if username and password aren't set, but user exists
				Session::put($this->_sessionName, $this->data()->id);												//put user's id into session array
			}

			else {

				$user = $this->find($username);																		//else, find user with $username and set it to $user

				if($user) {

					if($this->data()->password === Hash::make($password, $this->data()->salt)) {					//set this user's password to a hash of the password and salt

						Session::put($this->_sessionName, $this->data()->id);										//set the default session to the user's id

						if($remember) {																				//if remember option was set

							$hash = Hash::unique();																	//create unique hash
							$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));//get user's unique hash, stored in users_session table, by user_id

							if(!$hashCheck->count()) {																//if hashCheck (remember) doesn't have a count (doesn't exist)
								$this->_db->insert('users_session', array(											//set the hashCheck in users_session table to current unique hash
									'user_id' => $this->data()->id,
									'hash' => $hash
								));
							}

							else {
								$hash = $hashCheck->first()->hash;													//if it exists, set it to $hash
							}

							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));			//set the $hash as a cookie
						}

						return true;
					}
				}
			}

			return false;
		}

		public function exists() {
			return (!empty($this->_data)) ? true : false;															//if user exists, return true, else return falst
		}

		public function logout() {

			$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));							//delete remember hash from users_session for security purposes
			Session::delete($this->_sessionName);																	//delete current default/user session
			Cookie::delete($this->_cookieName);																		//delete current default/user cookie
		}

		public function data() {
			return $this->_data;																					//return private data
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;																				//return private isLoggedIn
		}
	}