<?php

	class Session {

		public static function exists($name) {
			return (isset($_SESSION[$name])) ? true : false;				//if $name is set in session array, return true
		}

		public static function put($name, $value) {
			return $_SESSION[$name] = $value;								//put $name into session array
		}

		public static function get($name) {
			return $_SESSION[$name];										//return the $name session
		}

		public static function delete($name) {

			if(self::exists($name)) {										//if $name exists in session array
				unset($_SESSION[$name]);									//unset $name from session array
			}
		}

		public static function flash($name, $string = '') {					//flashes, displays one time message to users

			if(self::exists($name)) {										//if $name exists in session array

				$session = self::get($name);								//set $session variable to $name value in session array
				self::delete($name);										//delete $name from session array
				return $session;											//return $session
			}

			else {
				self::put($name, $string);									//if $name doesn't exist in session array, set it
			}
		}

	}