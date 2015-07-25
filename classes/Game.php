<?php

	class Game {

		private $_computerHand,
				$_hands = array('rock', 'paper', 'scissors'),
				$_result,
				$_score;

		public function __construct() {

			$this->_db = DB::getInstance();								//set instance of database for use
		}

		public function play($playerHand) {
			
			if($playerHand == 'rock') {									//if player plays rock

				switch($this->_computerHand) {							//switch through values of computer's hand

					case 'rock':
						$this->_result = 'tied';						//set result to tied. this is what happens for the three switch statements
					break;

					case 'paper':
						$this->_result = 'lost';
					break;

					case 'scissors':
						$this->_result = 'won';
					break;
				}
			}

			elseif($playerHand == 'paper') {							//if player plays paper

				switch($this->_computerHand) {							//switch through values of computer's hand

					case 'rock':
						$this->_result = 'won';
					break;

					case 'paper':
						$this->_result = 'tied';
					break;

					case 'scissors':
						$this->_result = 'lost';
					break;
				}
			}

			elseif($playerHand == 'scissors') {							//if player plays scissors

				switch($this->_computerHand) {							//switch through values of computer's hand

					case 'rock':
						$this->_result = 'lost';
					break;
					case 'paper':
						$this->_result = 'won';
					break;
					case 'scissors':
						$this->_result = 'tied';
					break;
				}
			}
		}

		public function setScore($id, $hiscore) {

			switch($this->_result) {									//switch through cases of result

				case 'won':												//if won
					$score = Cookie::get('score');						//get current score from cookie
					Cookie::put('score', $score + 1, time()+60*60*24);	//reset cookie score +1 value
				break;

				case 'lost':											//if lost
					Cookie::put('score', 0, time()+60*60*24);			//set cookie score to 0
				break;													//no need for tied, because nothing happens to score
			}

			if($hiscore < Cookie::get('score')) {						//if user's hiscore is less than current score
				$this->_db->update('users', $id, array(					//run DB update
					'hiscore' => Cookie::get('score')					//set hiscore to current score
				));
			}
		}

		public function randomHand() {
			$this->_computerHand = $this->_hands[rand(0,2)];			//set computer's hand to random field form private fields array
		}

		public function computerHand() {
			return $this->_computerHand;								//get computer's hand
		}

		public function result() {
			return $this->_result;										//return result of match
		}

		public function score() {
			return $this->_score;										//return current score
		}
	}