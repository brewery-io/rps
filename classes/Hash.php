<?php
class Hash {
	public static function make( $string, $salt = '') {
		return hash('sha256', $string . $salt);					//return a sha256 hash of a string appended to a salt
	}

	public static function salt($length) {
		return mcrypt_create_iv($length); 						//create random varchar of length $length
	}

	public static function unique() {
		return self::make(uniqid());							//return a unique hash
	}

}
?>