<?php

session_start();

unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['email']);
unset($_SESSION['is_admin']);
unset($_SESSION['login_time']);
unset($_SESSION['user_appointment']);

header("Location: /login.php");