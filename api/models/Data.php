<?php
	class Data{
	protected $db;

	public function __construct(){
		$this->db = new DB\SQL('mysql:host=localhost;port=3306;dbname=f3-api','root','');
	}

	public function createUser($name,$firstname,$email,$pass){
		$this->db->exec('INSERT INTO users VALUES("","'.$name.'","'.$firstname.'","'.$email.'","'.md5($pass).'")');
	}
}