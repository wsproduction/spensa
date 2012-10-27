<?php

class MembersModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllMembers($page = 1) {
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_members.members_id,
            digilib_members.members_name,
            digilib_members.members_gender,
            digilib_members.members_birthplace,
            digilib_members.members_birthday,
            digilib_members.members_address,
            digilib_members.members_email,
            digilib_members.members_password,
            digilib_members.members_photo,
            digilib_members.members_visit,
            digilib_members.members_borrowed,
            digilib_members.members_last_visit,
            digilib_members.members_entry,
            digilib_members.members_status";

        $prepare = 'SELECT ' . $listSelect . ' FROM digilib_members';
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

    public function countAllMembers() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(members_id) AS cnt FROM digilib_members';
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
                                digilib_members
                            WHERE
                                digilib_members.members_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function createSave() {
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_members(
                    members_id,
                    members_name,
                    members_gender,
                    members_birthplace,
                    members_birthday,
                    members_address,
                    members_email,
                    members_status,
                    members_entry)
                    VALUES(
                    ( SELECT IF (
                        (SELECT COUNT(cdm . members_id) FROM digilib_members AS cdm 
                                WHERE cdm . members_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),DATE_FORMAT(CURDATE(),"%y")+1,DATE_FORMAT(CURDATE(),"%m"),"%")) 
                                ORDER BY cdm . members_id DESC LIMIT 1
                        ) > 0,
                        (SELECT ( dm.members_id + 1 ) FROM digilib_members AS dm 
                                WHERE dm . members_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),DATE_FORMAT(CURDATE(),"%y")+1,DATE_FORMAT(CURDATE(),"%m"),"%")) 
                                ORDER BY dm . members_id DESC LIMIT 1),
                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),DATE_FORMAT(CURDATE(),"%y")+1,DATE_FORMAT(CURDATE(),"%m"),"0001"))) AS dd ),
                    :name,
                    :gender,
                    :birthplace,
                    :birthday,
                    :address,
                    :email,
                    :status,
                    NOW()
                    )
                ');

        $name = trim($_POST['full_name']);
        $gender = trim($_POST['gender']);
        $birthplace = trim($_POST['birthplace']);
        $birthday = trim($_POST['birth_years']) . '-' . trim($_POST['birth_month']) . '-' . trim($_POST['birth_date']);
        $address = trim($_POST['address']);
        $email = trim($_POST['email']);
        //$photo = trim($_POST['photo']);
        $status = trim($_POST['status']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':gender' => $gender,
                    ':birthplace' => $birthplace,
                    ':birthday' => $birthday,
                    ':address' => $address,
                    ':email' => $email,
                    ':status' => $status
                ));
    }

    public function updateSave($id = 0) {
        $sth = $this->db->prepare('
                    UPDATE
                        digilib_members
                    SET
                        members_name = :name,
                        members_gender = :gender,
                        members_birthplace = :birthplace,
                        members_birthday = :birthday,
                        members_address = :address,
                        members_email = :email,
                        members_status = :status
                    WHERE
                        digilib_members.members_id = :id
                ');

        $name = trim($_POST['full_name']);
        $gender = trim($_POST['gender']);
        $birthplace = trim($_POST['birthplace']);
        $birthday = trim($_POST['birth_years']) . '-' . trim($_POST['birth_month']) . '-' . trim($_POST['birth_date']);
        $address = trim($_POST['address']);
        $email = trim($_POST['email']);
        //$photo = trim($_POST['photo']);
        $status = trim($_POST['status']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':gender' => $gender,
                    ':birthplace' => $birthplace,
                    ':birthday' => $birthday,
                    ':address' => $address,
                    ':email' => $email,
                    ':status' => $status,
                    ':id' => $id
                ));
    }

    public function delete() {
        $delete_id = $_POST['val'];
        $tempid = '0';
        foreach ($delete_id as $id) {
            $tempid .= ',' . $id;
        }
        $sth = $this->db->prepare('DELETE FROM digilib_members WHERE members_id IN (' . $tempid . ')');
        return $sth->execute();
    }

}