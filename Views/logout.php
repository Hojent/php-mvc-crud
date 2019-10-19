<?php
session_start();

unset($_SESSION['USERNAME']);
unset($_SESSION["UID"]);

header('Refresh: 2');
header("location: / ");