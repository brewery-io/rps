<?php 

	class Token {																				//this creates a random token for each form, so that the form can only be submitted once
																								//and by the user
		public static function generate() {
			return Session::put(Config::get('session/token_name'), md5(uniqid()));				//return a unique token hash and set it into the session array
		}

		public static function check($token) {

			$token_name = Config::get('session/token_name');									//if the token name has the specified token name

			if(Session::exists($token_name) && $token === Session::get($token_name)) {			//if the session exists and the $token is the $token in session array
				
				Session::delete($token_name);													//delete the token from the session array
				return true;
			}

			return false;
		}
	}