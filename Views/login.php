<?php
require_once '../Models/TaskService.php';
$taskService = new TaskService();
session_start();
$errmsg = [];
$errflag = false;

$username = $_POST['login'];
$password = $_POST['password'];

//проверка имени пользователя
if ($username == '') {
    $errmsg[] = 'Username missing';
    $errflag = true; //поднимает флаг в случае ошибки
}

//проверка пароля
if ($password == '') {
    $errmsg[] = 'Password missing';
    $errflag = true;
}

//если флаг ошибки поднят, направляет обратно к форме регистрации
if ($errflag) {
    $_SESSION['ERRMSG'] = $errmsg;
    session_write_close();
    header("location: ../Views/login-form.php");
    exit();
}

$row = $taskService->getUser($username, $password);
if ($row) {
    $_SESSION['UID'] = $row['id'];
    $_SESSION['USERNAME'] = $username;
    $_SESSION['ERRMSG'] = [];
    session_write_close();
    header("location: /");
    exit();
} else {
    //session_start();
    $_SESSION['ERRMSG'] = "Invalid username or password";
    session_write_close();
    header("location: ../Views/login-form.php");
    exit();
}


