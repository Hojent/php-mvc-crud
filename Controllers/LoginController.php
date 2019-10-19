<?php
require_once '../Models/TaskService.php';

class LoginController
{
    public  function loginAction ()
    {
        $pdo = DataBase::connect();

        if(isset($_SESSION['ERRMSG']) && is_array ($_SESSION['ERRMSG']) && count($_SESSION['ERRMSG']) > 0 ) {
            $errs = "";
            foreach($_SESSION['ERRMSG'] as $msg) {
                $errs .= "<p>" . $msg . "</p>";
            }
            unset($_SESSION['ERRMSG']);
        }

        include '../Views/login-form.php';

        $errmsg = []; //массив для сохранения ошибок
        $errflag = false; //флаг ошибки

        $username = filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);//имя пользователя
        $password = filter_var($_POST['password']);//пароль

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

        $query = "SELECT * FROM users WHERE login = $username AND password = $password";
        $sth = $pdo->prepare($query);
        $sth->execute();
        $row = $sth->fetch();
        DataBase::disconnect();
          var_dump($row); die();

        if (mysql_num_rows($result) == 1) {
            while ($row = mysql_fetch_assoc($result)) {
                $_SESSION['UID'] = $row['id'];//получение UID из базы данных и помещение его в сессию
                $_SESSION['USERNAME'] = $username;//устанавливает, совпадает ли имя пользователя с сессионным
                session_write_close(); //закрытие сессии
                header("location: ../Views/list.php");//перенаправление
            }
        } else {
            $_SESSION['ERRMSG'] = "Invalid username or password"; //ошибка
            session_write_close(); //закрытие сессии
            //header("location: ../Views/login-form.php"); //перенаправление
            exit();
        }
    }
}