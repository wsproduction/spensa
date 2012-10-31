<?php

class PublisherModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllPublisher($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_publisher.publisher_id,
            digilib_publisher.publisher_name,
            digilib_publisher.publisher_address,
            digilib_publisher.publisher_phone,
            digilib_publisher.publisher_fax,
            digilib_publisher.publisher_email,
            digilib_publisher.publisher_website,
            digilib_publisher.publisher_description,
            digilib_publisher.publisher_status,
            digilib_publisher.publisher_entry,
            digilib_publisher.publisher_entry_update";

        $prepare = 'SELECT ' . $listSelect . ' FROM digilib_publisher';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllPublisher() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(publisher_id) AS cnt FROM digilib_publisher';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
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

    public function createSave() {

        $name = $this->method->post('name');
        $address = $this->method->post('address');
        $phone = $this->method->post('phoneNumber');
        $fax = $this->method->post('fax');
        $email = $this->method->post('email');
        $website = $this->method->post('website');
        $description = $this->method->post('description');

        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_publisher(
                        digilib_publisher.publisher_id,
                        digilib_publisher.publisher_name,
                        digilib_publisher.publisher_address,
                        digilib_publisher.publisher_phone,
                        digilib_publisher.publisher_fax,
                        digilib_publisher.publisher_email,
                        digilib_publisher.publisher_website,
                        digilib_publisher.publisher_description,
                        digilib_publisher.publisher_status,
                        digilib_publisher.publisher_entry,
                        digilib_publisher.publisher_entry_update)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dp.publisher_id) 
                             FROM digilib_publisher AS dp) > 0, 
                                (SELECT dp.publisher_id 
                                 FROM digilib_publisher AS dp 
                                 ORDER BY dp.publisher_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :name,
                        :address,
                        :phone,
                        :fax,
                        :email,
                        :website,
                        :description,
                        :status,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':name', $name);
        $sth->bindValue(':address', $address);
        $sth->bindValue(':phone', $phone);
        $sth->bindValue(':fax', $fax);
        $sth->bindValue(':email', $email);
        $sth->bindValue(':website', $website);
        $sth->bindValue(':description', $description);
        $sth->bindValue(':status', 1);

        return $sth->execute();
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
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_publisher WHERE digilib_publisher.publisher_id IN (' . $id . ')');
        return $sth->execute();
    }

}