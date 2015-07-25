<?php 

	require_once 'core/init.php';

	if(Input::exists()) {

		if(Token::check(Input::get('token'))) {													//check form token againt session token

			$validate = new Validate();															//instantiate validate class and validate inputs
			$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'unique' => 'users'
				),
				'password' => array(
					'required' => true,
					'min' => 6,
				),
				'password_again' => array(
					'required' => true,
					'matches' => 'password'
				)
			));

			if($validation->passed()) {

				$user = new User();
				$salt = Hash::salt(32);															//create 32 character length salt

				
					$user->create(array(														//create a user with below specifications, should technically be in try/catch
						'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt
				));

				Session::flash('home', '<script>alert("You have been successfully registered.");</script>');		//temporarily flash registered message
				Redirect::to('index.php');																			//redirect to index
				
			}

			else {
				
				foreach($validation->errors() as $error) {
					echo '<script>alert("' . $error . '");location.reload();</script>'; 			//displays error, and reloads page to reapply style to elements. quick dirty fix
				}
			}
		}
	}

	require_once 'includes/templates/register_page.php';											//include register page template