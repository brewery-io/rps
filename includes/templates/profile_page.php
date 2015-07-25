<!DOCTYPE html >

<html >
	<head >

		<title >
			rps | register
		</title>

		<?php 
			require_once 'includes/templates/header.php';
		?>
	</head>
	<body class="landing" >

		<h1 >
			<?php echo escape($data->username); ?>
		</h1>

		<h1 >
			hiscore: <?php echo escape($data->hiscore); ?>
		</h1>
		<a href="index.php" >
			<div class="logout" >
				home
			</div>
		</a>
	</body>
</html>