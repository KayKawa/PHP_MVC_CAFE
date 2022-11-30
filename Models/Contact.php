<?php
require_once('Db.php');

class Contact extends Db
{
    private $table = 'contacts';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function findAll():Array
    {
        $sql = 'SELECT * FROM '.$this->table;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findById($id = 0):Array
    {
        $sql = 'SELECT * FROM '.$this->table;
        $sql .= ' WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
