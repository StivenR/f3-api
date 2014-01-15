<?php
include('C:\wamp\www\f3-api\api\models\Data.php');
class DogsController{

	public function __construct(){
	}

	public function actionFindUsers(){
		Api::response(200, array('Get all users'));
	}

	public function actionCreateUser(){
		if(isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['pass'])){
			$data = array('Create user with name ' . $_POST['name'] . ' and email ' . $_POST['email']);
			$data_model = new Data;
			$data_model->createUser($_POST['name'],$_POST['firstname'],$_POST['email'],$_POST['pass']);
			Api::response(200, $data);
		}
		else{
			Api::response(400, array('error'=>'Error'));
		}
	}

	public function actionFindOneUser(){
		$data = array('Find one user with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}

	public function actionUpdateUser(){
		$data = array('Update user with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}

	public function actionDeleteUser(){
		$data = array('Delete user with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}

	public function actionFindMovies(){
		Api::response(200, array('Get all Movies'));
	}

	public function actionCreateMovie(){
		if(isset($_POST['name'])){
			$data = array('Create Movie with name ' . $_POST['name']);
			Api::response(200, $data);
		}
		else{
			Api::response(400, array('error'=>'Name is missing'));
		}
	}

	public function actionFindOneMovie(){
		$data = array('Find one Movie with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}

	public function actionUpdateMovie(){
		$data = array('Update Movie with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}

	public function actionDeleteMovie(){
		$data = array('Delete Movie with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}
}