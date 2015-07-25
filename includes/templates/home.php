<!DOCTYPE html >

<html >
	<head >
		<title >
			rps | play
		</title>

		<?php 
			require_once 'includes/templates/header.php';
		?>

	</head>

	<body class="landing" >

		<h2 >
			Hello
		</h2>

		<a href="profile.php?user=<?php echo escape($user->data()->username); ?>" class="username" >
			<?php echo escape($user->data()->username); ?>
		</a>

		<div class="main" >

			<form action="" method="post" >
				<input type="submit" name="hand" class="rock" value="rock" ></input>
				<input type="submit" name="hand" class="paper" value="paper" ></input>
				<input type="submit" name="hand" class="scissors" value="scissors" ></input>
			</form>

			<h4 >your choice</h4>
			<h4 >v</h4>
			<h4 >computer's choice</h4>

			<div class="computer" >
				
				<?php 
					require_once 'core/init.php';																//require core

					if(Session::exists('result')) {																//if the result exists (match has been played)
						echo '<img src="includes/img/' . Session::get('computerHand') . '.png" />';				//echo computer's hand from session array to set image
						echo '<div class="result" >you ' . Session::get('result') . '!</div>';					//display the result of the match
						Session::delete('result');																//remove the result from the session
						Session::delete('computerHand');														//remove computer's hand from session 
					}

					else {
						echo '<img src="http://www.xiconeditor.com/image/icons/loading.gif" class="load" />';	//if not, display loading gif
						echo 'waiting for you';																	//and message
					}
				?>

				<script >
					$('.result').fadeOut(1500);
				</script>

			</div>
		</div>

		<div class="score" >

			score: 

			<?php 
				echo Cookie::get('score'); 																		//display current score
			?>
		</div>
		<div class="hiscore" >

			hiscore:

			<?php 
				echo $user->data()->hiscore;																	//displays user's current hiscore
			?>

		</div>
		<a href="changep.php" class="changep" >
			change password
		</a>
		<a href="logout.php" class="logout" >
			log out
		</a>
	</body>
</html>
