<?php
require_once 'Models/TaskService.php';

class TaskController
{
    private $taskService = NULL;

    public function __construct() {
        $this->taskService = new TaskService();
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

    public function handleRequest() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        try {
            if ( !$op || $op == 'list' ) {
                $this->listTask();
            } elseif ( $op == 'new') {
                $this->saveTask();
            } elseif ( $op == 'edit') {
                $this->editTask($id);
            }
            else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
// some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function listTask() {
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "name";
        $tasks = $this->taskService->getAllTasks($orderby);
        include "Views/list.php";
    }

    public function saveTask() {

        $title = 'Add new task';

        $name = '';
        $email = '';
        $task = '';

        if ( isset($_POST['form-submitted']) ) {

            $name       = isset($_POST['name']) ?   $_POST['name']  :NULL;
            $email      = isset($_POST['email'])?   $_POST['email'] :NULL;
            $task    = isset($_POST['task'])? $_POST['task']:NULL;

            try {
                $this->taskService->createNewTask($name, $email, $task);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/task-form.php';
    }

    public function editTask($id) {
        $title = 'Edit task';
        $item = $this->taskService->getTask($id);
        $name = $item['name'];
        $email = $item['email'];
        $task = $item['task'];
        $done = $item['done'];

        if ( isset($_POST['form-submitted']) ) {
            $name       = isset($_POST['name']) ?   $_POST['name']  : NULL;
            $email      = isset($_POST['email']) ?   $_POST['email'] : NULL;
            $task    = isset($_POST['task']) ? $_POST['task'] : NULL;
            $done = isset($_POST['done']) ? 1 : 0;
            try {
                $this->taskService->updateTask($name, $email, $task, $id, $done);
                $this->redirect('index.php');
                return;
            } catch (Exception $exception) { echo 'Error: '. $exception->getMessage(); }
        }
        include 'Views/task-form.php';
    }

    public function showError($title, $message) {
        echo ("$title : $message");
    }

	function render($template, $vars = [])
	{
 	    extract($vars);
	        include "Views/$template.php";
	}

}