<?php

class ProfileModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectUserProfile($userid) {
        $sth = $this->db->prepare('
                            SELECT 
                                myschool_user.user_id,
                                myschool_user.user_references,
                                myschool_user.user_name,
                                myschool_user.user_password,
                                myschool_user.user_about,
                                myschool_user.user_photo_profile,
                                myschool_user.user_entry,
                                myschool_user.user_update,
                                myschool_user.user_status,
                                myschool_isa.isa_id,
                                myschool_isa.isa_title,
                                myschool_isa.isa_dbroot
                            FROM
                                myschool_user
                                INNER JOIN myschool_isa ON (myschool_user.user_isa = myschool_isa.isa_id)
                            WHERE 
                                myschool_user.user_id = :userid
                        ');
        $sth->bindValue(':userid', $userid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectEmployeesById($employeeid) {
        $sth = $this->db->prepare('
                            SELECT 
                                employees.employees_id,
                                employees.employees_nik,
                                employees.employees_nip,
                                employees.employees_nuptk,
                                employees.employess_name,
                                employees.employees_gender,
                                employees.employees_birthplace,
                                employees.employees_birthdate,
                                employees.employees_religion,
                                employees.employees_religionother,
                                employees.employees_address,
                                employees.employees_rt,
                                employees.employees_rw,
                                employees.employees_village,
                                employees.employees_subdisctrict,
                                employees.employees_city,
                                employees.employees_zipcode,
                                employees.employees_transportation,
                                employees.employees_distance,
                                employees.employees_distanceother,
                                employees.employees_phone1,
                                employees.employees_phone2,
                                employees.employees_email,
                                employees.employees_photo,
                                employees.employees_desc,
                                employees.employees_marriage_status,
                                employees.employees_total_children,
                                employees.employees_mother_name,
                                employees.employees_status,
                                employees.employees_entry,
                                employees.employees_entry_update
                            FROM
                                employees
                            WHERE
                                employees.employees_id = :employeeid
                        ');
        $sth->bindValue(':employeeid', $employeeid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}