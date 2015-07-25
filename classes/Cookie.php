<?php 

	class Cookie {

		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;						//if cookie exists, true/false
		}

		public static function get($name) {
			return $_COOKIE[$name];												//get cookie name
		}

		public static function put($name, $value, $expiry) {

			if(setcookie($name, $value, time() + $expiry, '/')) {				//set cookie with specified values
				return true;
			}

			return false;
		}

		public static function delete($name) {
			self::put($name, '', time() - 1);									//override cookie value and time
		}
	}