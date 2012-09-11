<?php

class IndexModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function tesODBC() {
        $sth = $this->db->prepare('SELECT * FROM USERINFO');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        $list = $data[0];
        var_dump($list['Name']);
    }
}