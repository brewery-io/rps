<?php

	class Redirect {

		public static function to($location = null) {
			if(is_numeric($location)) {							//if redirect to is a number

				switch($location) {								//set switch statement for all potential numeral errors that can be set

					case 404:									//if redirect to is 404

						header('HTTP/1.0 404 Not Found');		//set the header for a 404 error
						include 'includes/errors/404.php';		//inclue 404 error page
						exit();
					break;
				}
			}

			if($location) {
				header('Location: ' . $location);				//set file's header location to set location
			}
		}
	}