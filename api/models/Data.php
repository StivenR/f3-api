<?php
	class Data{
	protected $db;

	public function __construct(){
		$this->db = new DB\SQL('mysql:host=localhost;port=3306;dbname=f3-api','root','');
	}

	/*
	*Create User, token is auto-generate and group is set to 0.
	*/
	public function createUser($name,$firstname,$email,$pass){
		$sql = 'SELECT id from users WHERE users.email="'.$email.'"';
		if(count($this->db->exec($sql)) == 0){
			$req = $this->db->exec('INSERT INTO users VALUES("","'.$name.'","'.$firstname.'","'.$email.'","' . $pass . '","'.sha1(md5($email)).'","2")');
			$status['Clé'] = 'Votre access token : '.sha1(md5($email));
		}else{
			$status['?'] = 'Email déjà existante';
			
		}
		return $status;
	}

	/*
	*Update User By ID and values (array[name, firstname, email, pass, group]), Token can't be update
	*/
	public function updateUser($id,$values){
		$user = $this->getUser($id);
		$name = (!$values['name'])?$user['Name']:$values['name'];
		$firstname = (!$values['firstname'])?$user['Firstname']:$values['firstname'];
		$email = (!$values['email'])?$user['Email']:$values['email'];
		$pass = (!$values['pass'])?$user['Password']:$values['pass'];
		$group = (!$values['group'])?$user['Group']:$values['group'];
		$this->db->exec('UPDATE users SET name="'.$name.'",firstname="'.$firstname.'",email="'.$email.'",pwd="'.$pass.'",user_group="'.$group.'" WHERE users.id="' .$id . '"');
		$new = $this->getUser($id);
		$data['Before'] = $user;
		$data['After'] = $new;
		return $data;
	}


	/*
	*Get All Users
	*/
	public function getUsers(){
		$users = $this->db->exec('SELECT id as Identifiant, name as Name, firstname as Firstname, email as Email, pwd as Password FROM users');
		return $users;
	}

	/*
	*Get One User By ID
	*/
	public function getUser($id){
		$user = $this->db->query('SELECT id as Identifiant, name as Name, firstname as Firstname, email as Email, pwd as Password FROM users WHERE users.id = "' . $id . '"')->fetch(PDO::FETCH_ASSOC);
		return $user;
	}

	/*
	*Delete One User By ID
	*/
	public function deleteUser($id){
		$item = $this->getUser($id);
		$this->db->exec('DELETE FROM users WHERE users.id = "' . $id . '"');
		return $item;
	}

	/*
	*Create Movie (Name, Release Date, Synopsis)
	*/
	public function createMovie($name,$release_date,$synopsis){
		$sql = 'SELECT id from movies WHERE movies.name="'.$name.'"';
		if(count($this->db->exec($sql)) == 0){
			$status = $this->db->exec('INSERT INTO movies VALUES("","' . $name . '","' . $release_date . '","' . $synopsis .'")');
		}else{
			$status = 'Film déjà existant';
		}
		return $status;
	}

	/*
	*Update Movie by ID with values (array[name, release, synopsis])
	*/
	public function updateMovie($id, $values){
		$movie = $this->getMovie($id);
		$name = (!$values['name'])?$movie['Name']:$values['name'];
		$release = (!$values['release'])?$movie['Release']:$values['release'];
		$synopsis = (!$values['synopsis'])?$movie['Synopsis']:$values['synopsis'];
		$this->db->exec('UPDATE users SET name="'.$name.'",release="'.$release.'",synopsis="'.$synopsis.'" WHERE movies.id="' .$id . '"');
		$new = $this->getMovie($id);
		$data['Before'] = $movie;
		$data['After'] = $new;
		return $data;
	}

	/*
	*Get All Movies
	*/
	public function getMovies(){
		$movies = $this->db->exec('SELECT id as Identifiant, name as Name, release_date as Release_Date, synopsis as Synopsis FROM movies');
		return $movies;
	}

	/*
	*Get One Movie By ID
	*/
	public function getMovie($id){
		$movie = $this->db->query('SELECT id as Identifiant, name as Name, release_date as Release_Date, synopsis as Synopsis FROM movies WHERE movies.id = "' . $id . '"')->fetch(PDO::FETCH_ASSOC);
		return $movie;
	}

	/*
	*Delete One Movie By ID
	*/
	public function deleteMovie($id){
		$item = $this->getMovie($id);
		$this->db->exec('DELETE FROM movies WHERE movies.id = "' . $id . '"');
		return $item;
	}

	/*
	*Chek if token key exists
	*/
	public function keyExists($key){
		$response = $this->db->exec('SELECT * FROM users WHERE users.key="'. $key.'"');
		$response = (count($response) < 1)?false:true;
		return $response;
	}

	/*
	*Get User By Token Key
	*/
	public function getUserByKey($key){
		$response = $this->db->exec('SELECT * FROM users WHERE users.key="'. $key.'"');
		return $response;
	}

	/*
	*Check if user is admin
	*/
	public function isAdmin($key){
		$req = $this->db->exec('SELECT user_group FROM users WHERE users.key="'. $key.'" AND users.user_group ="1"');
		$response = (count($req) < 1)?false:true;
		return $response;
	}

	/*
	*Return all movies 
	*/
	public function getLikes($token){
		$user = $this->getUserByKey($token);
		$id = $user[0]['id'];
		$req = $this->db->exec('SELECT movies.* FROM users_movies_likes as l, movies WHERE l.id_user="'. $id.'" AND l.id_movie=movies.id');
		return $req;
	}

	public function getWishes($token){
		$user = $this->getUserByKey($token);
		$id = $user[0]['id'];
		$req = $this->db->exec('SELECT movies.* FROM users_movies_wishes as w, movies WHERE w.id_user="'. $id.'" AND w.id_movie=movies.id');
		return $req;
	}

	public function getViewed($token){
		$user = $this->getUserByKey($token);
		$id = $user[0]['id'];
		$req = $this->db->exec('SELECT movies.* FROM users_movies_viewed as v, movies WHERE v.id_user="'. $id.'" AND v.id_movie=movies.id');
		return $req;
	}

	public function getLikesFor($id){
		$req = $this->db->exec('SELECT movies.* FROM users_movies_likes as l, movies WHERE l.id_user="'. $id.'" AND l.id_movie=movies.id');
		return $req;
	}

	public function getWishesFor($id){
		$req = $this->db->exec('SELECT movies.* FROM users_movies_wishes as w, movies WHERE w.id_user="'. $id.'" AND w.id_movie=movies.id');
		return $req;
	}

	public function getViewedFor($id){
		$req = $this->db->exec('SELECT movies.* FROM users_movies_viewed as v, movies WHERE v.id_user="'. $id.'" AND v.id_movie=movies.id');
		return $req;
	}
}