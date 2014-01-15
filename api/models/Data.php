<?php
	class Data{
	protected $db;

	public function __construct(){
		$this->db = new DB\SQL('mysql:host=localhost;port=3306;dbname=f3-api','root','');
	}

	/*
	*Create User
	*/
	public function createUser($name,$firstname,$email,$pass){
		$sql = 'SELECT count(id) from users WHERE users.email="'.$email.'"';
		if($this->db->exec($sql) == 0){
			$status = $this->db->exec('INSERT INTO users VALUES("","'.$name.'","'.$firstname.'","'.$email.'","' . $pass . '")');
		}else{
			$status = 'Email déjà existante';
		}
		return $status;
	}

	/*
	*Update User
	*/
	public function updateUser($name,$firstname,$email,$pass){
		$this->db->exec('UPDATE users WHERE VALUES("","'.$name.'","'.$firstname.'","'.$email.'","'.md5($pass).'")');
	}


	/*
	*Get User
	*/
	public function getUsers(){
		$users = $this->db->exec('SELECT id as Identifiant, name as Name, firstname as Firstname, email as Email, pwd as Password FROM users');
		return $users;
	}

	/*
	*Get User
	*/
	public function getUser($id){
		$user = $this->db->exec('SELECT id as Identifiant, name as Name, firstname as Firstname, email as Email, pwd as Password FROM users WHERE users.id = "' . $id . '"');
		return $user;
	}

	/*
	*Delete User
	*/
	public function deleteUser($id){
		$status = $this->db->exec('DELETE FROM users WHERE users.id = "' . $id . '"');
		return $status;
	}

	/*
	*Create Movie
	*/
	public function createMovie($name,$release_date,$synopsis){
		$sql = 'SELECT count(id) from movies WHERE movies.name="'.$name.'"';
		if($this->db->exec($sql) == 0){
			$status = $this->db->exec('INSERT INTO movies VALUES("","' . $name . '","' . $release_date . '","' . $synopsis .'")');
		}else{
			$status = 'Film déjà existant';
		}
		return $status;
	}

	/*
	*Update Movie
	*/
	public function updateMovie($name,$firstname,$email,$pass){
	}

	/*
	*Get Movies
	*/
	public function getMovies(){
		$movies = $this->db->exec('SELECT id as Identifiant, name as Name, release_date as Release_Date, synopsis as Synopsis FROM movies');
		return $movies;
	}

	/*
	*Get Movie
	*/
	public function getMovie($id){
		$movie = $this->db->exec('SELECT id as Identifiant, name as Name, release_date as Release_Date, synopsis as Synopsis FROM movies WHERE movies.id = "' . $id . '"');
		return $movie;
	}

	/*
	*Delete Movie
	*/
	public function deleteMovie($name){
		$status = $this->db->exec('DELETE FROM movies WHERE movies.id = "' . $id . '"');
		return $status;
	}
}