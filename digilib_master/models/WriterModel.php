<?php

class WriterModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAll($start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT *
                                   FROM
                                        digilib_writer
                                   ORDER BY writer_name LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT *
                            FROM
                                digilib_writer
                            WHERE
                                digilib_writer.writer_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function countAll() {
        $sth = $this->db->prepare('SELECT * FROM digilib_writer');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }
    
    public function createSave() {
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_writer(
                        writer_name,
                        writer_profile)
                    VALUES(
                        :name,
                        :profile)
                ');

        $name = trim($_POST['name']);
        $address = trim($_POST['profile']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':profile' => $address
                ));
    }

    public function updateSave($id = 0) {
        $sth = $this->db->prepare('
                    UPDATE
                        digilib_writer
                    SET
                        writer_name = :name,
                        writer_profile = :profile
                    WHERE
                        digilib_writer.writer_id = :id
                ');

        $name = trim($_POST['name']);
        $address = trim($_POST['profile']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':profile' => $address,
                    ':id' => $id
                ));
    }

    public function delete() {
        $delete_id = $_POST['val'];
        $sth = $this->db->prepare('DELETE FROM digilib_writer WHERE writer_id = :id');

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