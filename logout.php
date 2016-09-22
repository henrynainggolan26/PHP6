<?php
include_once 'start_session.php';
unset($_SESSION['username']);
session_destroy();
header('Location: login.php');
?>