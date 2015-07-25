<!DOCTYPE html >

<html >
	<head >

		<title >
			rps
		</title>

		<?php
			require_once 'header.php';
		?>

	</head>
	<body class="landing" >

		<h1 >play for fun</h1>
		<h3 >or
		<h1 >
			<a href="login.php">
				login
			</a>
			and rank your hiscore
		</h1>

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
					require_once 'core/init.php';															//require core

					if(Session::exists('result')) {															//if result exists (match has been played)
						echo '<img src="includes/img/' . Session::get('computerHand') . '.png" />';			//display computer's hand from session array
						echo '<div class="result" >you ' . Session::get('result') . '!</div>';				//display result from session array
						Session::delete('result');															//delete the result from session array
						Session::delete('computerHand');													//delete the computer's hand from session array
					}

					else {
						echo '<img src="http://www.xiconeditor.com/image/icons/loading.gif" class="load" />';		//else display waiting
						echo 'waiting for you';
					}
				?>

				<script >
					$('.result').fadeOut(1500);
				</script>

			</div>
		</div>
	</body>
</html>