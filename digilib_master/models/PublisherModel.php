<?php

class PublisherModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAll($start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT * FROM digilib_publisher ORDER BY publisher_name LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT *
                            FROM
                                digilib_publisher
                            WHERE
                                digilib_publisher.publisher_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function countAll() {
        $sth = $this->db->prepare('SELECT * FROM digilib_publisher');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }

    public function createSave() {
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_publisher(
                        publisher_name,
                        publisher_address,
                        publisher_phone,
                        publisher_fax,
                        publisher_email,
                        publisher_website,
                        publisher_description,
                        publisher_status)
                    VALUES(
                        :name,
                        :address,
                        :phone,
                        :fax,
                        :email,
                        :website,
                        :description,
                        :isa)
                ');

        $name = trim($_POST['name']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phoneNumber']);
        $fax = trim($_POST['fax']);
        $email = trim($_POST['email']);
        $website = trim($_POST['website']);
        $description = trim($_POST['description']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':address' => $address,
                    ':phone' => $phone,
                    ':fax' => $fax,
                    ':email' => $email,
                    ':website' => $website,
                    ':description' => $description,
                    ':isa' => 1,
                ));
    }

    public function updateSave($id = 0) {
        $sth = $this->db->prepare('
                    UPDATE
                        digilib_publisher
                    SET
                        publisher_name = :name,
                        publisher_address = :address,
                        publisher_phone = :phone,
                        publisher_fax = :fax,
                        publisher_email = :email,
                        publisher_website = :website,
                        publisher_description = :description
                    WHERE
                        digilib_publisher.publisher_id = :id
                ');

        $name = trim($_POST['name']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phoneNumber']);
        $fax = trim($_POST['fax']);
        $email = trim($_POST['email']);
        $website = trim($_POST['website']);
        $description = trim($_POST['description']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':address' => $address,
                    ':phone' => $phone,
                    ':fax' => $fax,
                    ':email' => $email,
                    ':website' => $website,
                    ':description' => $description,
                    ':id' => $id
                ));
    }

    public function delete() {
        $delete_id = $_POST['val'];
        $sth = $this->db->prepare('DELETE FROM digilib_publisher WHERE publisher_id = :id');

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