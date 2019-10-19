<?php
require_once 'DataBase.php';

class TaskService {

    public function getAllTasks($order)
    {
        try {
            $pdo = DataBase::connect();
            $sth = $pdo->prepare("SELECT * FROM tasks");
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
        return $result;
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

    public function createNewTask( $name, $email, $task ) {
        try {
            $pdo = DataBase::connect();
            $this->validateTaskParams($name, $email, $task);
            $stmt = $pdo->prepare("INSERT INTO tasks (name, email, task) VALUES (?,?,?)");
			$stmt->execute([$name,$email,$task]);
            DataBase::disconnect();;
            } catch (Exception $e) {
            DataBase::disconnect();
            throw $e;
        }
    }

     public function editTask( $name, $email, $task, $id ) {
         try {
             $pdo = DataBase::connect();
             $this->validateTaskParams($name, $email);

             $stmt = $pdo->prepare(
                 "UPDATE tasks SET name = ?, email = ?, task = ? 
                           WHERE id = $id");
             $stmt->execute([$name,$email,$task]);
             DataBase::disconnect();;
         } catch (Exception $e) {
             DataBase::disconnect();
             throw $e;
         }
    }
}
