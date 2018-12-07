<?php
	session_start();
	session_unset();
	
	header('Location: /poetese/index.php');