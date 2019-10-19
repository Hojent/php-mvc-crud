<?php
require_once 'DataBase.php';

class TaskService {

    public function getAllTasks($order = 'name', $paginate, $start_from)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM tasks ORDER BY $order LIMIT $start_from, $paginate");
            $sth->execute();
            $result = $sth->fetchAll();
            DataBase::disconnect();
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
        return $result;
    }

    public function getTask($id) {
        try{
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM tasks WHERE id = $id");
            $sth->execute();
            $result = $sth->fetch();
            DataBase::disconnect();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        return ($result);
    }

    private function validateTaskParams( $name, $email) {
        $errors = array();
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'Name is required';}
        elseif (!isset($email) || empty($email) ) {
            $errors[] = 'E-mail is required';
            }
        if ( empty($errors) ) {
            return;
        }
            throw new Exception ( $errors [0].' '.$errors[1]);
    }

    public function createNewTask( $name, $email, $task, $done =1 ) {
        try {
            $pdo = DataBase::connect();
            $this->validateTaskParams($name, $email, $task);
            $stmt = $pdo->prepare("INSERT INTO tasks (name, email, task, done) VALUES (?,?,?,?)");
			$stmt->execute([$name,$email,$task,$done]);
            DataBase::disconnect();;
            } catch (Exception $e) {
            DataBase::disconnect();
            throw $e;
        }
    }

     public function updateTask( $name, $email, $task, $id, $done ) {
         try {
             $pdo = DataBase::connect();
             $this->validateTaskParams($name, $email);

             $stmt = $pdo->prepare(
                 "UPDATE tasks SET name = ?, email = ?, task = ? , done = ?, edit = true
                           WHERE id = $id");
             $stmt->execute([$name, $email, $task, $done]);
             DataBase::disconnect();;
         } catch (Exception $e) {
             DataBase::disconnect();
             throw $e;
         }
    }

    public function getUser($login, $password) {
        try{
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM users WHERE login = '".$login."' AND password = '".$password."' ");
            $sth->execute();
            $result = $sth->fetch();
            DataBase::disconnect();
        }catch(PDOException  $e ){
            echo "Error: ".$e;
        }
        return $result;
    }

    public function paginator ($limit)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT COUNT(id) FROM tasks");
            $sth->execute();
            $result = $sth->fetchColumn();

            DataBase::disconnect();
            $total_pages = ceil($result / $limit);
            return $total_pages;
        } catch (PDOException  $e ){
            echo "Error: ".$e;
        }
    }

}
