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

        $prepare = 'SELECT 
                        digilib_members.members_id,
                        digilib_members.members_name,
                        digilib_members.members_gender,
                        digilib_members.members_birthplace,
                        digilib_members.members_birthdate,
                        digilib_members.members_address,
                        digilib_members.members_phone1,
                        digilib_members.members_phone2,
                        digilib_members.members_email,
                        digilib_members.members_photo,
                        digilib_members.members_isa,
                        digilib_members.members_desc,
                        digilib_members.members_status,
                        digilib_members.members_entry,
                        digilib_members.members_entry_update,
                        public_gender.gender_title,
                        digilib_isa.isa_title,
                        (SELECT COUNT(dbh.borrowed_history_id) FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_members = digilib_members.members_id) AS borrow_count,
                        (SELECT dbh.borrowed_history_star FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_members = digilib_members.members_id ORDER BY dbh.borrowed_history_star DESC LIMIT 1) AS last_borrow
                    FROM 
                        digilib_members
                        INNER JOIN public_gender ON (digilib_members.members_gender = public_gender.gender_id)
                        INNER JOIN digilib_isa ON (digilib_members.members_isa = digilib_isa.isa_id)';
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

    public function selectPrintListBySession($sessionid = 0) {

        $listSelect = "
            digilib_members.members_id,
            digilib_members.members_name,
            digilib_members.members_gender,
            digilib_members.members_birthplace,
            digilib_members.members_birthdate,
            digilib_members.members_address,
            digilib_members.members_phone1,
            digilib_members.members_phone2,
            digilib_members.members_email,
            digilib_members.members_photo,
            digilib_members.members_isa,
            digilib_members.members_desc,
            digilib_members.members_status,
            digilib_members.members_entry,
            digilib_members.members_entry_update,
            public_gender.gender_title,
            digilib_isa.isa_title";

        $prepare = 'SELECT 
                   ' . $listSelect . ' 
                   FROM 
                        digilib_members_temp_printcard
                        INNER JOIN digilib_members ON (digilib_members_temp_printcard.temp_members = digilib_members.members_id)
                        INNER JOIN public_gender ON (digilib_members.members_gender = public_gender.gender_id)
                        INNER JOIN digilib_isa ON (digilib_members.members_isa = digilib_isa.isa_id)
                   WHERE
                        digilib_members_temp_printcard.temp_session = :sessionid ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':sessionid', $sessionid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllPrintList($sessionid = 0, $page = 1) {

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
            digilib_members.members_birthdate,
            digilib_members.members_address,
            digilib_members.members_phone1,
            digilib_members.members_phone2,
            digilib_members.members_email,
            digilib_members.members_photo,
            digilib_members.members_isa,
            digilib_members.members_desc,
            digilib_members.members_status,
            digilib_members.members_entry,
            digilib_members.members_entry_update,
            public_gender.gender_title,
            digilib_isa.isa_title";

        $prepare = 'SELECT 
                   ' . $listSelect . ' 
                   FROM 
                        digilib_members_temp_printcard
                        INNER JOIN digilib_members ON (digilib_members_temp_printcard.temp_members = digilib_members.members_id)
                        INNER JOIN public_gender ON (digilib_members.members_gender = public_gender.gender_id)
                        INNER JOIN digilib_isa ON (digilib_members.members_isa = digilib_isa.isa_id)
                   WHERE
                        digilib_members_temp_printcard.temp_session = :sessionid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':sessionid', $sessionid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllPrintList($sessionid = 0) {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(temp_id) AS cnt FROM digilib_members_temp_printcard WHERE digilib_members_temp_printcard.temp_session = :sessionid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':sessionid', $sessionid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectMembersByID($id) {
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

        $name = $this->method->post('full_name');
        $gender = $this->method->post('gender');
        $birthplace = $this->method->post('birthplace');
        $birthdate = $this->method->post('birth_years') . '-' . $this->method->post('birth_month') . '-' . $this->method->post('birth_day');
        $address = $this->method->post('address');
        $phone1 = $this->method->post('phone1');
        $phone2 = $this->method->post('phone2');
        $email = $this->method->post('email');
        $isa = $this->method->post('isa');
        $desc = $this->method->post('desc');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_members(
                        members_id,
                        members_name,
                        members_gender,
                        members_birthplace,
                        members_birthdate,
                        members_address,
                        members_phone1,
                        members_phone2,
                        members_email,
                        members_isa,
                        members_desc,
                        members_status,
                        members_entry,
                        members_entry_update)
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
                    :birthdate,
                    :address,
                    :phone1,
                    :phone2,
                    :email,
                    :isa,
                    :desc,
                    :status,
                    NOW(),
                    NOW())
                ');

        $sth->bindValue(':name', $name);
        $sth->bindValue(':gender', $gender);
        $sth->bindValue(':birthplace', $birthplace);
        $sth->bindValue(':birthdate', $birthdate);
        $sth->bindValue(':address', $address);
        $sth->bindValue(':phone1', $phone1);
        $sth->bindValue(':phone2', $phone2);
        $sth->bindValue(':email', $email);
        $sth->bindValue(':isa', $isa);
        $sth->bindValue(':desc', $desc);
        $sth->bindValue(':status', $status);

        if ($sth->execute()) {
            $id = $this->db->lastInsID('members_id', 'digilib_members');
            $upload = Src::plugin()->PHPUploader();
            if ($this->method->files('photo', 'tmp_name')) {
                $upload->SetFileName($this->method->files('photo', 'name'));
                $upload->ChangeFileName('photo_' . date('Ymd') . time());
                $upload->SetTempName($this->method->files('photo', 'tmp_name'));
                $upload->SetUploadDirectory(Web::path() . 'asset/upload/images/members/'); //Upload directory, this should be writable
                if ($upload->UploadFile()) {
                    $this->savePhoto($id, $upload->GetFileName());
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function updateSave($id = 0) {
        $name = $this->method->post('full_name');
        $gender = $this->method->post('gender');
        $birthplace = $this->method->post('birthplace');
        $birthdate = $this->method->post('birth_years') . '-' . $this->method->post('birth_month') . '-' . $this->method->post('birth_day');
        $address = $this->method->post('address');
        $phone1 = $this->method->post('phone1');
        $phone2 = $this->method->post('phone2');
        $email = $this->method->post('email');
        $isa = $this->method->post('isa');
        $desc = $this->method->post('desc');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('
                    UPDATE
                        digilib_members
                    SET
                        members_name = :name,
                        members_gender = :gender,
                        members_birthplace = :birthplace,
                        members_birthdate = :birthdate,
                        members_address = :address,
                        members_phone1 = :phone1,
                        members_phone2 = :phone2,
                        members_email = :email,
                        members_isa = :isa,
                        members_desc = :desc,
                        members_status = :status,
                        members_entry_update = NOW()
                    WHERE
                        digilib_members.members_id = :id
                ');

        $sth->bindValue(':name', $name);
        $sth->bindValue(':gender', $gender);
        $sth->bindValue(':birthplace', $birthplace);
        $sth->bindValue(':birthdate', $birthdate);
        $sth->bindValue(':address', $address);
        $sth->bindValue(':phone1', $phone1);
        $sth->bindValue(':phone2', $phone2);
        $sth->bindValue(':email', $email);
        $sth->bindValue(':isa', $isa);
        $sth->bindValue(':desc', $desc);
        $sth->bindValue(':status', $status);
        $sth->bindValue(':id', $id);

        if ($sth->execute()) {
            $upload = Src::plugin()->PHPUploader();
            if ($this->method->files('photo', 'tmp_name')) {
                $upload->SetFileName($this->method->files('photo', 'name'));
                $upload->ChangeFileName('photo_' . date('Ymd') . time());
                $upload->SetTempName($this->method->files('photo', 'tmp_name'));
                $upload->SetUploadDirectory(Web::path() . 'asset/upload/images/members/'); //Upload directory, this should be writable
                if ($upload->UploadFile()) {

                    $listdata = $this->selectMembersByID($id);
                    $olddata = $listdata[0];
                    if ($olddata['members_photo'] != '') {
                        $upload->RemoveFile(Web::path() . 'asset/upload/images/members/' . $olddata['members_photo']);
                    }

                    $fn = $upload->GetFileName();
                    $this->savePhoto($id, $fn);
                }
            } else {
                $fn = '';
            }
            return array(true, $fn);
        } else {
            return false;
        }
    }

    public function savePhoto($id, $filename) {
        $sth = $this->db->prepare('
                                    UPDATE
                                        digilib_members
                                    SET
                                        members_photo = :filename
                                    WHERE
                                        digilib_members.members_id = :id
                                  ');
        $sth->bindValue(':filename', $filename);
        $sth->bindValue(':id', $id);
        return $sth->execute();
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_members WHERE digilib_members.members_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function deleteprintlist($sessionid = 0) {
        $id = $this->method->post('id', 0);
        $action = $this->method->post('action');
        if ($action == 'all') {
            $sth = $this->db->prepare('DELETE FROM digilib_members_temp_printcard WHERE digilib_members_temp_printcard.temp_session = :sessionid');
        } else {
            $sth = $this->db->prepare('DELETE FROM digilib_members_temp_printcard WHERE digilib_members_temp_printcard.temp_session = :sessionid AND digilib_members_temp_printcard.temp_members IN (' . $id . ')');
        }
        $sth->bindValue(':sessionid', $sessionid);
        return $sth->execute();
    }

    public function selectAllGender() {
        $sth = $this->db->prepare('SELECT * FROM public_gender');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllIsa() {
        $sth = $this->db->prepare('SELECT * FROM digilib_isa ORDER BY isa_title');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTempPrintcardBySession($sessionid = 0) {
        $sth = $this->db->prepare('
                        SELECT 
                            digilib_members_temp_printcard.temp_id,
                            digilib_members_temp_printcard.temp_members,
                            digilib_members_temp_printcard.temp_session
                        FROM
                            digilib_members_temp_printcard
                        WHERE 
                            digilib_members_temp_printcard.temp_session = :sessionid
                    ');

        $sth->bindValue(':sessionid', $sessionid);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countTempPrintcardBySession($sessionid = 0) {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(temp_id) AS cnt FROM digilib_members_temp_printcard WHERE digilib_members_temp_printcard.temp_session = :sessionid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':sessionid', $sessionid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function savePrintList($sessionid = 0, $newid = array()) {
        $countid = count($newid);

        if ($countid > 0) {
            $sql = "INSERT INTO
                    digilib_members_temp_printcard(
                        temp_id,
                        temp_members,
                        temp_session)
                    VALUES ";
            $idx = 1;
            foreach ($newid as $value) {
                $sql .= '(
                        (SELECT IF(
                            (SELECT COUNT(dmtp.temp_id) 
                             FROM digilib_members_temp_printcard AS dmtp) > 0, 
                                (SELECT dmtp.temp_id 
                                 FROM digilib_members_temp_printcard AS dmtp 
                                 ORDER BY dmtp.temp_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        "' . $value . '",
                        "' . $sessionid . '"
                        )';
                if ($idx != $countid) {
                    $sql .= ',';
                }
                $idx++;
            }
            $sth = $this->db->prepare($sql);
            return $sth->execute();
        } else {
            return false;
        }
    }

    public function saveMembers($data) {
        $name = $data['name'];
        $gender = $data['gender'];
        $birthplace = $data['birthplace'];
        $birthdate = $data['birthdate'];
        $address = $data['address'];
        $phone1 = $data['phonenumber1'];
        $phone2 = $data['phonenumber1'];
        $email = $data['email'];
        $isa = 1;
        $desc = '';
        $status = 1;

        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_members(
                        members_id,
                        members_name,
                        members_gender,
                        members_birthplace,
                        members_birthdate,
                        members_address,
                        members_phone1,
                        members_phone2,
                        members_email,
                        members_isa,
                        members_desc,
                        members_status,
                        members_entry,
                        members_entry_update)
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
                    :birthdate,
                    :address,
                    :phone1,
                    :phone2,
                    :email,
                    :isa,
                    :desc,
                    :status,
                    NOW(),
                    NOW())
                ');

        $sth->bindValue(':name', $name);
        $sth->bindValue(':gender', $gender);
        $sth->bindValue(':birthplace', $birthplace);
        $sth->bindValue(':birthdate', $birthdate);
        $sth->bindValue(':address', $address);
        $sth->bindValue(':phone1', $phone1);
        $sth->bindValue(':phone2', $phone2);
        $sth->bindValue(':email', $email);
        $sth->bindValue(':isa', $isa);
        $sth->bindValue(':desc', $desc);
        $sth->bindValue(':status', $status);
        return $sth->execute();
    }

}