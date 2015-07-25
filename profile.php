<?php

	require_once 'core/init.php';

	if(!$username = Input::get('user')) {									//if username isn't that from GET username
		Redirect::to('index.php');											//redirect to index
	}
	else {

		$user = new User($username);										//instantiate user

		if(!$user->exists()) {												//if user doesn't exist
			Redirect::to(404);												//redirect to 404 error
		}

		else {
			$data = $user->data();											//set data to user's data (actually, not really needed now that I think of it, but makes things easy) 
		}

		require_once 'includes/templates/profile_page.php';					//require profile tempate
	}