<?php
	require_once('function.php');
	require_once('setting.php');

	$ERROR_MSG = '';
	if (!isset ($_SESSION))
	{
		session_start();	
	}

	if (!isset($_SESSION["id"])) {
		header('Location: ../../index.php');
		exit;
	}
	$link=connectingDb();
?>
