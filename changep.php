<?php 
	
	require_once 'core/init.php';

	$user = new User();

	if(!$user->isLoggedIn()) {
		Redirect::to('index.php');
	}

	if(Input::exists()) {													//check if input (post) exists

		if(Token::check(Input::get('token'))) {								//check if token stored is the same as from form

			$validate = new Validate();										//instantiate validate class
			$validation = $validate->check($_POST, array(					//check the validation of the inputs
				'password_current' => array(
					'required' => true,
					'min' => 6
				),
				'password_new' => array(
					'required' => true,
					'min' => 6,
				),
				'password_new_again' => array(
					'required' => true,
					'min' => 6,
					'matches' => 'password_new'
				)
			));

			if($validation->passed()) {										//if validation passed
				
				if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password ) {	//if hash of current password and salt doesn't match one stored in DB
					echo '<script>alert("your current password is incorrect");location.reload();</script>'; 		//displays error and refreshes to apply css
				}

				else {																								//else

					$salt = Hash::salt(32);																			//make 32 char length hash

					$user->update(array(																			//update user password
						'password' => Hash::make(Input::get('password_new'), $salt),
						'salt' => $salt
					));

					Session::flash('home', '<script>alert("password changed successfully");</script>');										//flash to user
					Redirect::to('index.php');																								//redirect to index
				}
			}

			else {
				foreach($validation->errors() as $error) {															//for each error
					echo '<script>alert("' . $error . '");location.reload();</script>'; 							//displays error, and reloads page to reapply style to elements. quick dirty fix
				}
			}
		}
	}

	require_once 'includes/templates/change_page.php';