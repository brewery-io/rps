<!DOCTYPE html >

<html >
	<head >
		
		<?php 
			require_once 'includes/templates/header.php';
		?>

	</head>
	<body class="login" >
		<form action="" method="post" >

			<input type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>" placeholder="username" autocomplete="off" />
			<input type="password" name="password" id="password" placeholder="password" />
			<input type="password" name="password_again" id="password_again" placeholder="password again" />

			<input name="token" type="hidden" value="<?php echo Token::generate(); ?>" >

			<input type="submit" class="register_btn" value="register" />

		</form>
	</body>
</html>