<?php

	class Input {

		public static function exists($type = 'post') {					//if posts exists

			switch($type) {

				case 'post':
					return (!empty($_POST)) ? true : false;				//if post is set, return true
				break;

				case 'get':
					return (!empty($_GET)) ? true : false;				//if get is set, return true
				break;

				default:
					return false;										//if neither is set, return false
				break;
			}
		}

		public static function get($item) {

			if(isset($_POST[$item])) {
				return $_POST[$item];									//get item from post array
			}
			
			elseif(isset($_GET[$item])) {
				return $_GET[$item];									//get item from get array
			}
		}
	}