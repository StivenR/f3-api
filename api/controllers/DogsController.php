<?php
include('C:\wamp\www\f3-api\api\models\Data.php');
class DogsController{

	public function __construct(){
	}

	public function actionFindUsers(){
		$data_model = new Data;
		$data['Users'] = $data_model->getUsers();
		Api::response(200, $data);
	}

	public function actionCreateUser(){
		if(isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['pass'])){
			$data = array('Create user with name ' . $_POST['name'] . ' and email ' . $_POST['email']);
			$data_model = new Data;
			$data['Status'] = $data_model->createUser($_POST['name'],$_POST['firstname'],$_POST['email'],md5($_POST['pass']));
			Api::response(200, $data);
		}
		else{
			Api::response(400, array('error'=>'Error'));
		}
	}

	public function actionFindOneUser(){
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$id = basename(parse_url($url, PHP_URL_PATH));
		$data_model = new Data;
		$data['User'] = $data_model->getUser($id);
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
		$data_model = new Data;
		$data['Movies'] = $data_model->getMovies();
		Api::response(200, $data);
	}

	public function actionCreateMovie(){
		if(isset($_POST['name'])){
			$data = array('Create Movie with name ' . $_POST['name']);
			$data_model = new Data;
			$data['Status'] = $data_model->createMovie($_POST['name'],$_POST['release'],$_POST['synopsis']);
			Api::response(200, $data);
		}
		else{
			Api::response(400, array('error'=>'Name is missing'));
		}
	}

	public function actionFindOneMovie(){
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$id = basename(parse_url($url, PHP_URL_PATH));
		$data_model = new Data;
		$data['Movie'] = $data_model->getMovie($id);
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