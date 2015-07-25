<?php

	class Config {
		public static function get($path = null) {
			if($path) { //if specified path

				$config = $GLOBALS['config']; 				//sets config name
				$path = explode('/', $path); 				//resets path with / inbetween
				
				foreach($path as $bit) { 					//goes in 
					if(isset($config[$bit])) {				//if there is a deeper level
						$config = $config[$bit];			//set deeper level
					}
				}

				return $config;
			}

			return false;
		}
	}