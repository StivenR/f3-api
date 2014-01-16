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
		$data_model = new Data;
		$id = F3::get('PARAMS.id');
		$data['User'] = $data_model->getUser($id);
		Api::response(200, $data);
	}

	public function actionUpdateUser(){
		$id = F3::get('PARAMS.id');
		$values = array('name'=>F3::get('PUT.name'),'firstname'=>F3::get('PUT.firstname'),'email'=>F3::get('PUT.email'),'pass'=>md5(F3::get('PUT.pass'));
		$data_model = new Data;
		$data['Movie'] = $data_model->getMovie($id,$values);
		Api::response(200, $data);
	}

	public function actionDeleteUser(){
		$id = F3::get('PARAMS.id');
		$data_model = new Data;
		$data['User'] = $data_model->deleteUser($id);
		$data['Status'] = 'Delete user with name: ' . $id;
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
		$id = F3::get('PARAMS.id');
		$data_model = new Data;
		$data['Movie'] = $data_model->getMovie($id);
		Api::response(200, $data);
	}

	public function actionUpdateMovie(){
		$id = F3::get('PARAMS.id');
		$values = array('name'=>F3::get('PUT.name'),'release'=>F3::get('PUT.release'),'date'=>F3::get('PUT.date'),'synopsis'=>F3::get('PUT.synopsis'));
		$data_model = new Data;
		$data['Movie'] = $data_model->getMovie($id,$values);
		Api::response(200, $data);
	}

	public function actionDeleteMovie(){
		$id = F3::get('PARAMS.id');
		$data_model = new Data;
		$data['Movie'] = $data_model->deleteMovie($id);
		$data['Status'] = 'Delete Movie with id: ' . $id;
		Api::response(200, $data);
	}
}