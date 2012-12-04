<?php

class DashboardModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function addSave() {

        $text = $_POST['text'];

        $sth = $this->db->prepare('INSERT INTO data (text) VALUES (:text)');
        $sth->execute(array(':text' => $text));
        $data = array('text' => $text, 'id' => $this->db->lastInsertId());
        echo json_encode($data);
    }

    public function selectList() {
        $sth = $this->db->prepare('SELECT * FROM data');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }
    
    public function delete() {
        $sth = $this->db->prepare('DELETE FROM data WHERE id = :id');
        $sth->execute(array(':id' => $_POST['id']));
    }

}