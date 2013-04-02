<?php

class ResellerModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllReseller($param) {
        $prepare = ' SELECT 
                        members.members_id,
                        members.members_name,
                        members.members_nickname,
                        members.members_gender,
                        members.members_address,
                        members.members_birthplace,
                        members.members_birthdate,
                        members.members_last_education,
                        members.members_jobs,
                        members.members_phone_number,
                        members.members_email,
                        members.members_facebook,
                        members.members_twitter,
                        members.members_status,
                        members.members_entry,
                        members.members_entry_update
                      FROM
                        members';

        if ($param['query'])
            $prepare .= ' WHERE ' . $param['qtype'] . ' LIKE "%' . $param['query'] . '%" ';

        $prepare .= ' ORDER BY ' . $param['sortname'] . ' ' . $param['sortorder'];

        $start = (($param['page'] - 1) * $param['rp']);
        $prepare .= ' LIMIT ' . $start . ',' . $param['rp'];

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveReseller($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        members(
                        members_id,
                        members_name,
                        members_nickname,
                        members_gender,
                        members_address,
                        members_birthplace,
                        members_birthdate,
                        members_last_education,
                        members_jobs,
                        members_phone_number,
                        members_email,
                        members_facebook,
                        members_twitter,
                        members_status,
                        members_entry,
                        members_entry_update)
                      VALUES(
                        (SELECT IF (
                            (SELECT COUNT(e.members_id) FROM members AS e 
                                    WHERE e.members_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m%d"),"%")) 
                                    ORDER BY e.members_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.members_id + 1 ) FROM members AS e 
                                    WHERE e.members_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m%d"),"%")) 
                                    ORDER BY e.members_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m%d"),"0001")))
                        ),
                        :fullname,
                        :nickname,
                        :gender,
                        :address,
                        :birthplace,
                        :birthdate,
                        :education,
                        :jobs,
                        :phone,
                        :email,
                        :facebook,
                        :twitter,
                        :status,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':fullname', $param['fullname']);
        $sth->bindValue(':nickname', $param['nickname']);
        $sth->bindValue(':gender', $param['gender']);
        $sth->bindValue(':address', $param['address']);
        $sth->bindValue(':birthplace', $param['birthplace']);
        $sth->bindValue(':birthdate', $param['birthdate']);
        $sth->bindValue(':education', $param['education']);
        $sth->bindValue(':jobs', $param['jobs']);
        $sth->bindValue(':phone', $param['phone']);
        $sth->bindValue(':email', $param['email']);
        $sth->bindValue(':facebook', $param['facebook']);
        $sth->bindValue(':twitter', $param['twitter']);
        $sth->bindValue(':status', $param['status']);

        return $sth->execute();
    }

    public function updateReseller($param) {

        $sth = $this->db->prepare('
                      UPDATE
                        members
                      SET
                        members_name = :fullname,
                        members_nickname = :nickname,
                        members_gender = :gender,
                        members_address = :address,
                        members_birthplace = :birthplace,
                        members_birthdate = :birthdate,
                        members_last_education = :education,
                        members_jobs = :jobs,
                        members_phone_number = :phone,
                        members_email = :email,
                        members_facebook = :facebook,
                        members_twitter = :twitter,
                        members_status = :status,
                        members_entry_update = NOW()
                      WHERE
                        members.members_id = :id
                ');

        $sth->bindValue(':fullname', $param['fullname']);
        $sth->bindValue(':nickname', $param['nickname']);
        $sth->bindValue(':gender', $param['gender']);
        $sth->bindValue(':address', $param['address']);
        $sth->bindValue(':birthplace', $param['birthplace']);
        $sth->bindValue(':birthdate', $param['birthdate']);
        $sth->bindValue(':education', $param['education']);
        $sth->bindValue(':jobs', $param['jobs']);
        $sth->bindValue(':phone', $param['phone']);
        $sth->bindValue(':email', $param['email']);
        $sth->bindValue(':facebook', $param['facebook']);
        $sth->bindValue(':twitter', $param['twitter']);
        $sth->bindValue(':status', $param['status']);
        $sth->bindValue(':id', $param['id']);

        return $sth->execute();
    }

    public function deleteProduct($param) {
        $sth = $this->db->prepare('DELETE FROM members WHERE members.members_id IN (' . $param['id'] . ')');
        return $sth->execute();
    }

    public function selectResellerById($members_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                members.members_id,
                                members.members_name,
                                members.members_nickname,
                                members.members_gender,
                                members.members_address,
                                members.members_birthplace,
                                members.members_birthdate,
                                members.members_last_education,
                                members.members_jobs,
                                members.members_phone_number,
                                members.members_email,
                                members.members_facebook,
                                members.members_twitter,
                                members.members_status,
                                members.members_entry,
                                members.members_entry_update
                              FROM
                                members
                              WHERE
                                members.members_id = :members_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':members_id', $members_id);
        $sth->execute();
        return $sth->fetchAll();
    }

}