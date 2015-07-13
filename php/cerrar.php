<?php
session_start();
	$_SESSION['username'] = "";
	$_SESSION['password'] = "";
	session_destroy();
echo "<script type='text/javascript'>location.href='../';</script>";

