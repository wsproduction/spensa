<?php

class ExportModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllAccount() {
        $sth = $this->db->prepare('SELECT * FROM myschool_user');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}