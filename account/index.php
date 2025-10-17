<?php

session_start();

if (!isset($_SESSION["user_id"]))
	header("Location: /login.php");
else
	header("Location: /account/my-info.php");

die();