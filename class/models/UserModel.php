<?php 

class UserModel {

	public $username;

	private $password;

	protected $firstname;

	protected $lastname;

	/*
	 * protected function set_username
	 * @param string $username
	 */
	protected function set_username ($username) 
	{
		$this->username = $username;
	}

	/*
	 * protected function set_password
	 * @param string $password
	 */
	protected function set_password ($password) 
	{
		$this->password = $password;
	}

	/*
	 * protected function set_firstname
	 * @param $string $firstname
	 */
	protected function set_firstname ($firstname) 
	{
		$this->firstname = $firstname;
	}

	/*
	 * protected function set_lastname
	 * @param string $lastname
	 */
	protected function set_lastname ($lastname) 
	{
		$this->lastname = $lastname;
	}

}