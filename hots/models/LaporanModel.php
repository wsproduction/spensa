<?php

class LaporanModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllGuru($start = 1, $count = 100) {
        /*$sth = $this->db->prepare('SELECT *
                                   FROM
                                        USERINFO LIMIT ' . $start . ',' . $count);*/
        $sth = $this->db->prepare('SELECT * FROM USERINFO ORDER BY USERID');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function countAllGuru() {
        $sth = $this->db->prepare('SELECT COUNT(USERID) AS cnt FROM USERINFO');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $count = $sth->fetchAll();
        return $count[0]['cnt'];
    }

}