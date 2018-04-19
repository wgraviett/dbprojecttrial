<?php
	require('TasksModel.php');
	require('TasksViews.php');

	class TasksController {
		private $model;
		private $views;
		
		private $orderBy = '';
		private $view = '';
		private $action = '';
		private $message = '';
		private $data = array();
	
		public function __construct() {
			$this->model = new TasksModel();
			$this->views = new TasksViews();
			
			$this->view = $_GET['view'] ? $_GET['view'] : 'tasklist';
			$this->action = $_POST['action'];
		}
		
		public function __destruct() {
			$this->model = null;
			$this->views = null;
		}
		
		public function run() {
			if ($error = $this->model->getError()) {
				print $views->errorView($error);
				exit;
			}
			
			// Note: given order of handling and given processOrderBy doesn't require user to be logged in
			//...orderBy can be changed without being logged in
			$this->processOrderBy();
			
			$this->processLogout();

			switch($this->action) {
				case 'login':
					$this->handleLogin();
					break;
				case 'delete':
					$this->handleDelete();
					break;
				case 'approve':
					$this->handleSetApplicationStatus('Accepted');
					break;
				case 'deny':
					$this->handleSetApplicationStatus('denied');
					break;
				case 'add':
					$this->handleAddTask();
					break;
				case 'edit':
					$this->handleEditTask();
					break;
				case 'createuser':
					$this->handleCreateUser();
					break;	
				case 'view':
					$this->handleViewTask();
					break;
				case 'update':
					$this->handleUpdateTask();
					break;
				default:
					$this->verifyLogin();
			}
			
			switch($this->view) {
				case 'loginform': 
					print $this->views->loginFormView($this->data, $this->message);
					break;
				case 'taskform':
					print $this->views->taskFormView($this->model->getUser(), $this->data, $this->message/*, $this->model->getuserdata($this->model->getUser())*/);
					break;
				case 'userform':
					print $this->views->userformView($this->data, $this->message);
					break;
				case 'taskview':
					print $this->views->taskView($this->model->getUser(), $this->data, $this->message);
					break;
				default: // 'tasklist'
					//list($orderBy, $orderDirection) = $this->model->getOrdering();
					list($tasks, $error) = $this->model->getTasks();
					if ($error) {
						$this->message = $error;
					}
					print $this->views->taskListView($this->model->getUser(), $tasks, /*$orderBy, $orderDirection,*/ $this->message);
			}
		
		}
		
		private function verifyLogin() {
			if (! $this->model->getUser()) {
				$this->view = 'loginform';
				return false;
			} else {
				return true;
			}
		}
		
		private function processOrderby() {
			if ($_GET['orderby']) {
				$this->model->toggleOrder($_GET['orderby']);
			}			
		}
		
		private function processLogout() {
			if ($_GET['logout']) {
				$this->model->logout();
			}
		}
		
		private function handleLogin() {
			$loginID = $_POST['loginid'];
			$password = $_POST['password'];
			
			list($success, $message) = $this->model->login($loginID, $password);
			if ($success) {
				$this->view = 'tasklist';
			} else {
				$this->message = $message;
				$this->view = 'loginform';
				$this->data = $_POST;
			}
		}
		
		private function handleDelete() {
			if (!$this->verifyLogin()) return;
		
			if ($error = $this->model->deleteTask($_POST['id'])) {
				$this->message = $error;
			}
			$this->view = 'tasklist';
		}
		
		private function handleSetApplicationStatus($status) {
			if (!$this->verifyLogin()) return;
			
			if ($error = $this->model->updateapplicationStatus($_POST['id'], $status)) {
				$this->message = $error;
			}
			$this->view = 'tasklist';
		}
		
		private function handleAddTask() {
			if (!$this->verifyLogin()) return;
			
			if ($_POST['cancel']) {
				$this->view = 'tasklist';
				return;
			}
			//list($task, $error) = $this->model->getuserdata($this->model->getUser())
			$error = $this->model->addTask($_POST);
			if ($error) {
				$this->message = $error;
				$this->view = 'taskform';
				$this->data = $_POST;
			}
		}
		
		private function handleCreateUser(){
			if ($_POST['cancel']) {
				$this->view = 'userform';
				return;
			}
			$error = $this->model->CreateUser($_POST);
				if ($error) {
				$this->message = $error;
				$this->view = 'userform';
				$this->data = $_POST;
			}
		}
		
		
		private function handleEditTask() {
			if (!$this->verifyLogin()) return;
			
			list($task, $error) = $this->model->getTask($_POST['id']);
			if ($error) {
				$this->message = $error;
				$this->view = 'tasklist';
				return;
			}
			$this->data = $task;
			$this->view = 'taskform';
		}
		
		private function handleViewTask() {
			if (!$this->verifyLogin()) return;//return if not logged in
			
			list($task, $error) = $this->model->getTask($_POST['id']);
			if ($error) {//error handling
				$this->message = $error;
				$this->view = 'tasklist';//returns to tasklist if there is a problem
				return;
			}
			
			$this->data = $task;
			$this->view = 'taskview';
		}
		
		private function handleUpdateTask() {
			if (!$this->verifyLogin()) return;
			
			if ($_POST['cancel']) {
				$this->view = 'tasklist';
				return;
			}
			
			if ($error = $this->model->updateTask($_POST)) {
				$this->message = $error;
				$this->view = 'taskform';
				$this->data = $_POST;
				return;
			}
			
			$this->view = 'tasklist';
		}
	}
?>