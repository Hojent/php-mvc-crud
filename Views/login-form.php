<?php include ('head.php');
?>

<form action='login.php' method='post'>
    <table align="center">
        <tr>
            <td><?php echo $errs ?></td>
        </tr>
        <tr>
            <td>Имя пользователя</td>
            <td><input type='text' name='login'></td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td><input type='password' name='password'></td>
        </tr>
        <tr>
            <td><input type='submit' value='Войти'></td>
        </tr>
    </table>
</form>
<?php
include ('foot.php');