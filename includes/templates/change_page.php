<!DOCTYPE html >

<html >
	<head >

	<?php 
		require_once 'includes/templates/header.php';
	?>

	</head>	

	<body class="login" >

		<form action="" method="post" >

			<input type="password" name="password_current" placeholder="current password" />
			<input type="password" name="password_new" placeholder="new password" />
			<input type="password" name="password_new_again" placeholder="new password again" />

			<input name="token" type="hidden" value="<?php echo Token::generate(); ?>" >
			<input type="submit" value="Change" class="register_btn" />

		</form>

	</body>
</html>