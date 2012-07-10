<?php

class DdcModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAll($start=1, $count=100) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=1 ORDER BY ddc_call_number LIMIT ' . $start .',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAll() {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }

    public function selectLevelDDC() {
        $level = array();
        foreach ($this->db->enum('digilib_ddc', 'ddc_level') as $value) {
            $level[$value] = $value;
        }
        return $level;
    }

    public function selectSub1() {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    public function selectSub2() {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=2 AND ddc_parent=:parent');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':parent' => $_GET['id']));
        return $sth->fetchAll();
    }

    public function addSave() {
        $sth = $this->db->prepare('
                INSERT INTO
                digilib_ddc(
                ddc_call_number,
                ddc_title,
                ddc_description,
                ddc_level,
                ddc_parent)
                VALUES(
                :callNumber,
                :title,
                :description,
                :level,
                :parent)
                ');

        $callNumber = trim($_POST['callNumber'], ' ');
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $level = $_POST['level'];

        if ($_POST['level'] == 2) {
            $parent = $_POST['sub1'];
        } else if ($_POST['level'] == 3) {
            $parent = $_POST['sub2'];
        } else {
            $parent = 'NULL';
        }

        return $sth->execute(array(
                    ':callNumber' => $callNumber,
                    ':title' => $title,
                    ':description' => $description,
                    ':level' => $level,
                    ':parent' => $parent
                ));
    }

    public function delete() {
        $delete_id = $_POST['val'];
        $sth = $this->db->prepare('DELETE FROM digilib_ddc WHERE ddc_id = :id');

        try {
            foreach ($delete_id as $id) {
                $sth->execute(array(':id' => $id));
            }
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
    }

}