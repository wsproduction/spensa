<?php

class CollectionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAll($start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT 
                                        dbr.book_register_id,
                                        dbr.book_id,
                                        (SELECT dbc.book_condition FROM digilib_book_condition AS dbc WHERE dbc.book_condition_id = dbr.book_condition) AS book_con,
                                        dbr.entry_date,
                                        dbr.last_borrow,
                                        dbr.borrow_status
                                   FROM
                                        digilib_book_register AS dbr
                                   ORDER BY dbr.book_register_id LIMIT ' . $start . ',' . $count);
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
        $sth = $this->db->prepare('SELECT * FROM digilib_book_register');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }
    
    public function createSave() {
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_author(
                        author_first_name,
                        author_last_name,
                        author_profile)
                    VALUES(
                        :first_name,
                        :last_name,
                        :profile)
                ');

        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $profile = trim($_POST['profile']);

        return $sth->execute(array(
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':profile' => $profile
                ));
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