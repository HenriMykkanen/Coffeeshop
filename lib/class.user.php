<?php
require_once('db.php');
class user
{
    protected $id;
    protected $sql;
    protected $tablename;
    public $firstname;
    public $lastname;
    public $street;
    public $zip;
    public $city;
    public $phone;
    protected $email;
    protected $password;
    public $role;
    public $loggedIn;

    public function __construct($id, $sql, $tablename = null, $email = null, $password = null)
    {
        $this->id = $id;
        $this->sql = $sql;
        $this->tablename = $tablename;
        $this->email = $email;
        $this->password = $password;

    }

    public function addUser(): bool
    {

        if ($this->sql->query("INSERT INTO users (firstname, lastname, street, zip, city, phone, email, password, role) 
        VALUES
        ('" . $this->firstname . "',
        '" . $this->lastname . "',
        '" . $this->street . "',
        '" . $this->zip . "',
        '" . $this->city . "',
        '" . $this->phone . "',
        '" . $this->email . "',
        '" . $this->password . "',
        '" . $this->role . "')")) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password) : array
    {
        global $sql;

        $userIDAndRole = [];

        $email = $sql->real_escape_string($email);
        $password = $sql->real_escape_string($password);

        $result = $sql->query("SELECT id, role FROM $this->tablename WHERE email = '" . $email . "' AND password = '" . $password . "'");

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc())
            {
                $userIDAndRole = $row;
            }
            $this->loggedIn = true;
            
        } 
        return $userIDAndRole;

    }

    public function logout()
    {
        $this->loggedIn = false;
    }

    public function isLoggedIn()
    {
        return $this->loggedIn;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function isEmailUnique(): bool
    {
        $result = $this->sql->query("SELECT email FROM users WHERE email='" . $this->email . "'");
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }
}
