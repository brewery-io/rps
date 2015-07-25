<?php
	
	require_once 'core/init.php';

	$user = new User();										//instantiate user
	$user->logout();										//log user out

	Redirect::to('index.php');								//redirect to index