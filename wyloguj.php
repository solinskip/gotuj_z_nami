<?php
	session_start();
	$aktualna_strona = $_SESSION['aktualna_strona'];
	session_unset();

	header('Location: '.$aktualna_strona);