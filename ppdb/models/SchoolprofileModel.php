<?php

class SchoolprofileModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllSchool($param) {
        $prepare = ' SELECT 
                        ppdb_school_profile.school_id,
                        ppdb_school_profile.school_nss,
                        ppdb_school_profile.school_name,
                        ppdb_school_profile.school_address,
                        ppdb_school_profile.school_rt,
                        ppdb_school_profile.school_rw,
                        ppdb_school_profile.school_village,
                        ppdb_school_profile.school_subdistric,
                        ppdb_school_profile.school_distric,
                        ppdb_school_profile.school_province,
                        ppdb_school_profile.school_zipcode,
                        ppdb_school_profile.school_phone,
                        ppdb_school_profile.school_entry,
                        ppdb_school_profile.school_entry_update
                      FROM
                        ppdb_school_profile';

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

    public function saveSchoolProfile($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        ppdb_school_profile(
                        school_id,
                        school_nss,
                        school_name,
                        school_address,
                        school_rt,
                        school_rw,
                        school_village,
                        school_subdistric,
                        school_distric,
                        school_province,
                        school_zipcode,
                        school_phone,
                        school_entry,
                        school_entry_update)
                      VALUES(
                        (SELECT IF (
                            (SELECT COUNT(e.school_id) FROM ppdb_school_profile AS e 
                                    WHERE e.school_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.school_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.school_id + 1 ) FROM ppdb_school_profile AS e 
                                    WHERE e.school_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.school_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"0001")))
                        ),
                        :nss,
                        :school_name,
                        :address,
                        :rt,
                        :rw,
                        :village,
                        :sub_distric,
                        :distric,
                        :province,
                        :zip_code,
                        :phone,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':nss', $param['nss']);
        $sth->bindValue(':school_name', $param['school_name']);
        $sth->bindValue(':address', $param['address']);
        $sth->bindValue(':rt', $param['rt']);
        $sth->bindValue(':rw', $param['rw']);
        $sth->bindValue(':village', $param['village']);
        $sth->bindValue(':sub_distric', $param['sub_distric']);
        $sth->bindValue(':distric', $param['distric']);
        $sth->bindValue(':province', $param['province']);
        $sth->bindValue(':zip_code', $param['zip_code']);
        $sth->bindValue(':phone', $param['phone']);

        return $sth->execute();
    }

    public function updateSchoolProfile($param) {

        $sth = $this->db->prepare('
                      UPDATE
                        ppdb_school_profile
                      SET
                        school_nss = :nss,
                        school_name = :school_name,
                        school_address = :address,
                        school_rt = :rt,
                        school_rw = :rw,
                        school_village = :village,
                        school_subdistric = :sub_distric,
                        school_distric = :distric,
                        school_province = :province,
                        school_zipcode = :zip_code,
                        school_phone = :phone,
                        school_entry_update = NOW()
                      WHERE
                        ppdb_school_profile.school_id = :id
                ');

        $sth->bindValue(':nss', $param['nss']);
        $sth->bindValue(':school_name', $param['school_name']);
        $sth->bindValue(':address', $param['address']);
        $sth->bindValue(':rt', $param['rt']);
        $sth->bindValue(':rw', $param['rw']);
        $sth->bindValue(':village', $param['village']);
        $sth->bindValue(':sub_distric', $param['sub_distric']);
        $sth->bindValue(':distric', $param['distric']);
        $sth->bindValue(':province', $param['province']);
        $sth->bindValue(':zip_code', $param['zip_code']);
        $sth->bindValue(':phone', $param['phone']);
        $sth->bindValue(':id', $param['id']);

        return $sth->execute();
    }

    public function deleteSchoolProfile($param) {
        $sth = $this->db->prepare('DELETE FROM ppdb_school_profile WHERE ppdb_school_profile.school_id IN (' . $param['id'] . ')');
        return $sth->execute();
    }

    public function selectSchoolProfileById($id) {
        $sth = $this->db->prepare('
                             SELECT 
                                ppdb_school_profile.school_id,
                                ppdb_school_profile.school_nss,
                                ppdb_school_profile.school_name,
                                ppdb_school_profile.school_address,
                                ppdb_school_profile.school_rt,
                                ppdb_school_profile.school_rw,
                                ppdb_school_profile.school_village,
                                ppdb_school_profile.school_subdistric,
                                ppdb_school_profile.school_distric,
                                ppdb_school_profile.school_province,
                                ppdb_school_profile.school_zipcode,
                                ppdb_school_profile.school_phone,
                                ppdb_school_profile.school_entry,
                                ppdb_school_profile.school_entry_update
                              FROM
                                ppdb_school_profile
                              WHERE
                                ppdb_school_profile.school_id = :school_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':school_id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

}