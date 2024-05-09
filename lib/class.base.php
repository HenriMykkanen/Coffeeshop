<?php
require_once('db.php');
class base 
{
    protected $id;
    protected $sql;
    protected $tablename;

    public function __construct($id, $sql, $tablename = null)
    {
        $this->id = $id;
        $this->sql = $sql;
        $this->tablename = $tablename;

    }
    public function delete(): bool
    {
        if ($this->sql->query("DELETE FROM ".$this->tablename." WHERE id = '" . $this->id . "'")) {
            return true;
        } else {
            return false;
        }
    }
}
?>