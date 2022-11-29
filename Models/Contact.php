<?php
require_once('Db.php');

class Contact extends Db
{
    private $table = 'contacts';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }
}
