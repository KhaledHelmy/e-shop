<?php
//User.class.php
require_once 'DB.class.php';


class User {

	public $id;
	public $firstname;
	public $lastname;
	public $hashedPassword;
	public $email;
	public $avatar;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : "";
		$this->hashedPassword = (isset($data['password'])) ? $data['password'] : "";
		$this->email = (isset($data['email'])) ? $data['email'] : "";
		$this->avatar = (!empty($data['avatar'])) ? $data['avatar'] : "img/profile.png";
		$this->firstname = (isset($data['first_name'])) ? $data['first_name'] : "";
		$this->lastname = (isset($data['last_name'])) ? $data['last_name'] : "";
	}

	public function save($isNewUser = false) {
		//create a new database object.
		$db = new DB();

		//set the data array
		$data = array(
			"first_name" => "'$this->firstname'",
			"last_name" => "'$this->lastname'",
			"password" => "'$this->hashedPassword'",
			"email" => "'$this->email'",
			"avatar" => "'$this->avatar'"
		);
		//if the user is already registered and we're
		//just updating their info.
		if(!$isNewUser) {
			//update the row in the database
			$db->update($data, 'users', 'id = '.$this->id);
		}else {
			//if the user is being registered for the first time.
			$this->id = $db->insert($data, 'users');
			$this->joinDate = time();
		}
		return true;
	}
	
}

?>