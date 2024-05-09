<?php
require_once('db.php');
class admin extends user
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $loggedIn;

    public function init()
    {

        $result = $this->sql->query("SELECT * FROM admins WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->email = $row['email'];
    }
}
