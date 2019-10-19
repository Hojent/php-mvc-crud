<?php
require_once '../Models/TaskService.php';
$taskService = new TaskService();
session_start();
$errmsg = []; //массив для сохранения ошибок
$errflag = false; //флаг ошибки

$username = $_POST['login'];//имя пользователя
$password = $_POST['password'];//пароль

//проверка имени пользователя
if ($username == '') {
    $errmsg[] = 'Username missing'; //ошибка
    $errflag = true; //поднимает флаг в случае ошибки
}

//проверка пароля
if ($password == '') {
    $errmsg[] = 'Password missing'; //ошибка
    $errflag = true; //поднимает флаг в случае ошибки
}

//если флаг ошибки поднят, направляет обратно к форме регистрации
if ($errflag) {
    $_SESSION['ERRMSG'] = $errmsg; //записывает ошибки
    session_write_close(); //закрытие сессии
    header("location: ../Views/login-form.php"); //перенаправление
    exit();
}

$row = $taskService->getUser($username, $password);
if ($row) {
    $_SESSION['UID'] = $row['id'];
    $_SESSION['USERNAME'] = $username;
    $_SESSION['ERRMSG'] = [];
    session_write_close(); //закрытие сессии
    header("location: /");//перенаправление
    exit();
} else {
    //session_start();
    $_SESSION['ERRMSG'] = "Invalid username or password"; //ошибка
    session_write_close(); //закрытие сессии
    header("location: ../Views/login-form.php"); //перенаправление
    exit();
}


