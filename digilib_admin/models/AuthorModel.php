<?php

class AuthorModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAll($start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT *
                                   FROM
                                        digilib_author
                                   ORDER BY author_first_name LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT *
                            FROM
                                digilib_author
                            WHERE
                                digilib_author.author_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function countAll() {
        $sth = $this->db->prepare('SELECT * FROM digilib_author');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }
    
    public function createSave() {
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_tes(
                        tes_isi,
                        tes_fk)
                    VALUES(
                        :first_name,
                        :tes_fk)
                ');

        $first_name = $this->method->post('first_name');
        $fk = $this->method->post('last_name');
        
        $sth->bindValue(':first_name', $first_name, PDO::PARAM_NULL);
        $sth->bindValue(':tes_fk', $fk, PDO::PARAM_NULL);

        return $sth->execute();
    }

    public function updateSave($id = 0) {
        $sth = $this->db->prepare('
                    UPDATE
                        digilib_author
                    SET
                        author_first_name = :first_name,
                        author_last_name = :last_name,
                        author_profile = :profile
                    WHERE
                        digilib_author.author_id = :id
                ');

        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $profile = trim($_POST['profile']);

        return $sth->execute(array(
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':profile' => $profile,
                    ':id' => $id
                ));
    }

    public function delete() {
        $delete_id = $_POST['val'];
        $sth = $this->db->prepare('DELETE FROM digilib_author WHERE author_id = :id');

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