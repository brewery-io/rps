<?php 

	require_once 'core/init.php';

	if(Session::exists('home')) {													//if session "home" exists
		echo Session::flash('home');												//flash message of home
	}

	$user = new User();																//instantiante new user

	if($user->isLoggedIn()) {														//if user is logged in

		require_once 'includes/templates/home.php';									//require home page template

		if(!Cookie::exists('score')) {												//if cookie score doesn't exist
			Cookie::put('score', 0, time()+60*60*24);								//set a cookie of a score of 0
		}

		if(Input::exists()) {														//if input (post) exists

			$game = new Game();														//instantiate new game
			$game->randomHand();													//generate a computer's random hand

			$game->play(Input::get('hand'));										//play player's hand (from input)

			$computerHand = $game->computerHand();									//set the computer's hand
			$result = $game->result();												//set the result

			Session::put('computerHand', $computerHand);							//put the computer's hand into session array
			Session::put('result', $result);										//put the result of the match into session array

			$game->setscore($user->data()->id, $user->data()->hiscore);				//set the score for the user, and pass in id and hiscore in case of id

			Redirect::to('index.php');												//redirect to index (refresh)
		}
	}

	else {

		require_once 'includes/templates/landing.php';								//require landing page template

		if(Input::exists()) {														//if input exists

			$game = new Game();														//instantiate hand
			$game->randomHand();													//generate computer's random hand

			$game->play(Input::get('hand'));										//play the player's hand from input

			$computerHand = $game->computerHand();									//set the computer's hand
			$result = $game->result();												//set the result

			Session::put('computerHand', $computerHand);							//put the computer's hand into session array
			Session::put('result', $result);										//put the result of the match into session array

			Redirect::to('index.php');												//redirect to index (refresh)

		}
	}