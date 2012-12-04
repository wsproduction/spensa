<?php

class MessagesModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function tes() {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        echo 'Messages : '.$sth->rowCount();
    }

}