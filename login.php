<?php 

	require_once 'core/init.php';

	$user = new User();

	if($user->isLoggedIn()) {
		Redirect::to('index.php');
	}

	if(Input::exists()) {																			//if input exists
		
		if(Token::check(Input::get('token'))) {														//check session token against form token

			$validate = new Validate();
			$validation = $validate->check($_POST, array(											//validate inputs
				'username' => array(
					'required' => true
				),
				'password' => array(
					'required' => true
				)
			));

			if($validation->passed()) {																//if validation passed
									
				$remember = (Input::get('remember') === 'on') ? true : false;						//if remember was checked, set remember to true

				$login = $user->login(Input::get('username'), Input::get('password'), true);		//login user based on username and password

				if($login) {																		//if login is true
					Redirect::to('index.php');														//redirect to index
				}

				else {
					echo 'Bad login';																//tell user it was bad login (should probably style this nicely and template it)
				}
			}

			else {

				foreach($validation->errors() as $error) {											//for each error, display error
					echo $error . '<br />';
				}
			}
		}
	}

    require_once 'includes/templates/login_page.php';												//require login page