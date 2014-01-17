<?php
include('C:\wamp\www\f3-api\api\models\Data.php');
class DogsController{

	public function __construct(){
		$data_model = new Data;
		$key = (isset($_GET['token']))?$_GET['token']:'';
			
		$this->key = $data_model->keyExists($key);
		if($this->key){
			$this->admin = $data_model->isAdmin($key);
		}else{
			$this->admin = false;
		}
	}

	public function actionFindUsers(){
		if($this->admin){
			$data_model = new Data;
			$data['Users'] = $data_model->getUsers();
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Admin'));
		}
	}

	public function actionCreateUser(){
		if($this->admin){
			if(isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['pass'])){
				$data['Process'] = array('Create user with name ' . $_POST['name'] . ' and email ' . $_POST['email']);
				$data_model = new Data;
				$data['Status'] = $data_model->createUser($_POST['name'],$_POST['firstname'],$_POST['email'],md5($_POST['pass']));
				Api::response(200, $data);
			}
			else{
				Api::response(400, array('error'=>'Error'));
			}
		}else{
			Api::response(403, array('error'=>'Admin'));
		}
	}

	public function actionFindOneUser(){
		if($this->admin){
			$data_model = new Data;
			$id = F3::get('PARAMS.id');
			$data['User'] = $data_model->getUser($id);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Admin'));
		}
	}

	public function actionUpdateUser(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$put = PUT::get();
			$name=(!isset($put['name']))?false:$put['name'];
			$firstname=(!isset($put['firstname']))?false:$put['firstname'];
			$email=(!isset($put['email']))?false:$put['email'];
			$pass=(!isset($put['password']))?false:md5($put['password']);
			$values = array('name'=>$name,'firstname'=>$firstname,'email'=>$email,'pass'=>$pass);
			$param = false;
			foreach($values as $val){
				//Check if at least one param is set, else return an error
				if($val){
					$param = true;
				}
			}
			if($param){
				$data_model = new Data;
				$data = $data_model->updateUser($id,$values);
			}else{
				$data = "Aucun paramètre modifié, veuillez vérifier vos options (name, firstname, email, password)";
			}
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Admin'));
		}
	}

	public function actionDeleteUser(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$data_model = new Data;
			$data['User'] = $data_model->deleteUser($id);
			$data['Status'] = 'Delete user with name: ' . $id;
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Admin'));
		}
	}

	public function actionFindMovies(){
		if($this->key){
			$data_model = new Data;
			$response = $data_model->getMovies();
			if($response){
				$data['Movies'] = $response;
			}
			else{
				$data['Movies'] = "Aucun film";
			}
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionCreateMovie(){
		if($this->admin){
			if(isset($_POST['name'])){
				$data = array('Create Movie with name ' . $_POST['name']);
				$data_model = new Data;
				$data['Status'] = $data_model->createMovie($_POST['name'],$_POST['release'],$_POST['synopsis']);
				Api::response(200, $data);
			}
			else{
				Api::response(400, array('error'=>'Name is missing'));
			}
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindOneMovie(){
		if($this->key){
			$id = F3::get('PARAMS.id');
			$data_model = new Data;
			$data['Movie'] = $data_model->getMovie($id);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionUpdateMovie(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$put = PUT::get();
			$name=(!isset($put['name']))?false:$put['name'];
			$release=(!isset($put['release']))?false:$put['release'];
			$synopsis=(!isset($put['synopsis']))?false:$put['synopsis'];
			$values = array('name'=>$name,'release'=>$release,'synopsis'=>$synopsis);
			$param = false;
			foreach($values as $val){
				//Check if at least one param is set, else return an error
				if($val){
					$param = true;
				}
			}
			if($param){
				$data_model = new Data;
				$data = $data_model->updateMovie($id,$values);
			}else{
				$data = "Aucun paramètre modifié, veuillez vérifier vos options (name, release, synopsis)";
			}
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionDeleteMovie(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$data_model = new Data;
			$data['Movie'] = $data_model->deleteMovie($id);
			$data['Status'] = 'Delete Movie with id: ' . $id;
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindLikes(){
		if($this->key){
			$data_model = new Data;
			$data['Likes'] = $data_model->getLikes($_GET['token']);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindWishes(){
		if($this->key){
			$data_model = new Data;
			$data['Wishes'] = $data_model->getWishes($_GET['token']);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindViewed(){
		if($this->key){
			$data_model = new Data;
			$data['Viewed'] = $data_model->getViewed($_GET['token']);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindLikesFor(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$data_model = new Data;
			$data['Likes'] = $data_model->getLikesFor($id);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindWishesFor(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$data_model = new Data;
			$data['Wishes'] = $data_model->getWishesFor($id);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}

	public function actionFindViewedFor(){
		if($this->admin){
			$id = F3::get('PARAMS.id');
			$data_model = new Data;
			$data['Viewed'] = $data_model->getViewedFor($id);
			Api::response(200, $data);
		}else{
			Api::response(400, array('error'=>'Key access'));
		}
	}
}