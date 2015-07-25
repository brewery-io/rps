<html >
	<head >
		<title >
			rps | login
		</title>
		<?php 
			require_once 'includes/templates/header.php';
		?>
	</head>
	<body class="login" >

		<form action="" method="post" >

			<input type="text" name="username" id="username" class="field" placeholder="username" autocomplete="off" />
			<input type="password" name="password" id="password" class="field" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;" autocomplete="off" />
			<span >
				<input type="checkbox" name="remember" id="remember" />
				<p >
					remember me
				</p>
			</span>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
			<input type="submit" value="login" />
			<p >
				or 
				<a href="register.php" >
					register
				</a>
			</p>
		</form>
	</body>
</html>