<?php

$sql = new mysqli("localhost", "henri_mykkanen", "sg1Ka0_2", "sakky_henri_mykkanen");

if($sql->connect_errno) {
    die("Problems occurred while trying to connect to the database " . $sql->connect_error);
}

?>