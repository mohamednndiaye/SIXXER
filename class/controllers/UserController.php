<?php

class UserController extends UserModel {

	public function __construct($username = '', $password = '', $firstname = '', $lastname = '') 
	{
		if( isset($username) ) $this->set_username($username);
		if( isset($password) ) $this->set_password($password);
		if( isset($firstname) ) $this->set_firstname($firstname);
		if( isset($lastname) ) $this->set_lastname($lastname);
	}

	public function login_user( $postArr )
	{
		$db = new DatabaseController();

		$db->query('SELECT * FROM users WHERE username = :username');
		$db->bind(':username', $postArr['username']);	
		
		if ($db->execute() && $db->resultset()) {
			if (password_verify($postArr['password'], $db->resultset()[0]['password'])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function register_user( $postArr ) 
	{
		$db = new DatabaseController();

		$db->query('SELECT count(username) AS count FROM users WHERE username = :username');
		$db->bind(':username', $postArr['username']);
		
		if ($db->execute() && $db->single()['count'] < 1) {
			return $this->insert_user($postArr);
		} else {
			return false;
		}
	}

	private function insert_user( $postArr )
	{
		$db = new DatabaseController();

		$db->query('INSERT INTO users(username, password, firstname, lastname) VALUES (:username,:password,:firstname,:lastname)');
		$db->bind(':username', $postArr['username']);
		$db->bind(':password', password_hash($postArr['password'], PASSWORD_BCRYPT));
		$db->bind(':firstname', $postArr['firstname']);
		$db->bind(':lastname', $postArr['lastname']);

		if ($db->execute() && $db->lastInsertId()) {
			return true;
		} else {
			return false;
		}
	}

}