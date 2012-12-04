<?php

class ImportModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function saveStudent($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_student(
                                        student_nis,
                                        student_name,
                                        student_gender,
                                        student_nisn,
                                        student_nik,
                                        student_birthplace,
                                        student_birthdate,
                                        student_religion,
                                        student_religionother,
                                        student_residance,
                                        student_residanceother,
                                        student_address,
                                        student_rt,
                                        student_rw,
                                        student_village,
                                        student_subdisctrict,
                                        student_city,
                                        student_zipcode,
                                        student_distance,
                                        student_distanceother,
                                        student_transportation,
                                        student_phonenumber1,
                                        student_phonenumber2,
                                        student_email,
                                        student_height,
                                        student_weight,
                                        student_specialneeds,
                                        student_pin,
                                        student_entry,
                                        student_entry_update,
                                        student_status)
                                VALUES(
                                        :nis,
                                        :name,
                                        :gender,
                                        :nisn,
                                        :nik,
                                        :birthplace,
                                        :birthdate,
                                        :religion,
                                        :religionother,
                                        :residance,
                                        :residanceother,
                                        :address,
                                        :rt,
                                        :rw,
                                        :village,
                                        :subdisctrict,
                                        :city,
                                        :zipcode,
                                        :distance,
                                        :distanceother,
                                        :transportation,
                                        :phonenumber1,
                                        :phonenumber2,
                                        :email,
                                        :height,
                                        :weight,
                                        :specialneeds,
                                        NULL,
                                        NOW(),
                                        NOW(),
                                        1);
                            ');
        $sth->bindValue(':nis', $data['nis']);      
        $sth->bindValue(':name', $data['name']);      
        $sth->bindValue(':gender', $data['gender']);      
        $sth->bindValue(':nisn', $data['nisn']);      
        $sth->bindValue(':nik', $data['nik']);      
        $sth->bindValue(':birthplace', $data['birthplace']);      
        $sth->bindValue(':birthdate', $data['birthdate']);      
        $sth->bindValue(':religion', $data['religion']);      
        $sth->bindValue(':religionother', $data['religionother']); 
        $sth->bindValue(':residance', $data['residance']);      
        $sth->bindValue(':residance', $data['residance']);      
        $sth->bindValue(':residanceother', $data['residanceother']);      
        $sth->bindValue(':address', $data['address']);      
        $sth->bindValue(':rt', $data['rt']);      
        $sth->bindValue(':rw', $data['rw']);      
        $sth->bindValue(':village', $data['village']);      
        $sth->bindValue(':subdisctrict', $data['subdisctrict']);      
        $sth->bindValue(':city', $data['city']);      
        $sth->bindValue(':zipcode', $data['zipcode']);      
        $sth->bindValue(':distance', $data['distance']);      
        $sth->bindValue(':distanceother', $data['distanceother']);      
        $sth->bindValue(':transportation', $data['transportation']);      
        $sth->bindValue(':phonenumber1', $data['phonenumber1']);      
        $sth->bindValue(':phonenumber2', $data['phonenumber2']);      
        $sth->bindValue(':email', $data['email']);      
        $sth->bindValue(':height', $data['height']);      
        $sth->bindValue(':weight', $data['weight']);      
        $sth->bindValue(':specialneeds', $data['specialneeds']);      
        return $sth->execute();
    }
    
    public function saveEmployees($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    employees(
                                        employees_id,
                                        employees_nik,
                                        employees_nip,
                                        employees_nuptk,
                                        employess_name,
                                        employees_gender,
                                        employees_birthplace,
                                        employees_birthdate,
                                        employees_religion,
                                        employees_religionother,
                                        employees_address,
                                        employees_rt,
                                        employees_rw,
                                        employees_village,
                                        employees_subdisctrict,
                                        employees_city,
                                        employees_zipcode,
                                        employees_transportation,
                                        employees_distance,
                                        employees_distanceother,
                                        employees_phone1,
                                        employees_phone2,
                                        employees_email,
                                        employees_photo,
                                        employees_desc,
                                        employees_marriage_status,
                                        employees_total_children,
                                        employees_mother_name,
                                        employees_status,
                                        employees_entry,
                                        employees_entry_update)
                                VALUES(
                                        ( SELECT IF (
                                            (SELECT COUNT(e.employees_id) FROM employees AS e 
                                                    WHERE e.employees_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                    ORDER BY e.employees_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.employees_id + 1 ) FROM employees AS e 
                                                    WHERE e.employees_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                    ORDER BY e.employees_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0001")))
                                        ),
                                        :nik,
                                        :nip,
                                        :nuptk,
                                        :name,
                                        :gender,
                                        :birthplace,
                                        :birthdate,
                                        :religion,
                                        :religionother,
                                        :address,
                                        :rt,
                                        :rw,
                                        :village,
                                        :subdisctrict,
                                        :city,
                                        :zipcode,
                                        :transportation,
                                        :distance,
                                        :distanceother,
                                        :phone1,
                                        :phone2,
                                        :email,
                                        :photo,
                                        :desc,
                                        :marriage_status,
                                        :total_children,
                                        :mother_name,
                                        :status,
                                        NOW(),
                                        NOW());
                            ');
        $sth->bindValue(':nik', $data['nik']);    
        $sth->bindValue(':nip', $data['nip']);    
        $sth->bindValue(':nuptk', $data['nuptk']);    
        $sth->bindValue(':name', $data['name']);    
        $sth->bindValue(':gender', $data['gender']);    
        $sth->bindValue(':birthplace', $data['birthplace']);    
        $sth->bindValue(':birthdate', $data['birthdate']);    
        $sth->bindValue(':religion', $data['religion']);    
        $sth->bindValue(':religionother', $data['religionother']);    
        $sth->bindValue(':address', $data['address']);    
        $sth->bindValue(':rt', $data['rt']);    
        $sth->bindValue(':rw', $data['rw']);    
        $sth->bindValue(':village', $data['village']);    
        $sth->bindValue(':subdisctrict', $data['subdisctrict']);    
        $sth->bindValue(':city', $data['city']);    
        $sth->bindValue(':zipcode', $data['zipcode']);    
        $sth->bindValue(':transportation', $data['transportation']);    
        $sth->bindValue(':distance', $data['distance']);    
        $sth->bindValue(':distanceother', $data['distanceother']);    
        $sth->bindValue(':phone1', $data['phone1']);    
        $sth->bindValue(':phone2', $data['phone2']);    
        $sth->bindValue(':email', $data['email']);    
        $sth->bindValue(':photo', $data['photo']);    
        $sth->bindValue(':desc', $data['desc']);    
        $sth->bindValue(':marriage_status', $data['marriage_status']);    
        $sth->bindValue(':total_children', $data['total_children']);    
        $sth->bindValue(':mother_name', $data['mother_name']);    
        $sth->bindValue(':status', $data['status']);    
        return $sth->execute();
    }
    
    public function saveClassGroup($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_classhistory(
                                        classhistory_id,
                                        classhistory_student,
                                        classhistory_classgroup,
                                        classhistory_status,
                                        classhistory_entry,
                                        classhistory_entry_update)
                                VALUES(
                                    (SELECT IF(
                                        (SELECT COUNT(ac.classhistory_id) 
                                        FROM academic_classhistory AS ac) > 0, 
                                            (SELECT ac.classhistory_id 
                                            FROM academic_classhistory AS ac 
                                            ORDER BY ac.classhistory_id DESC LIMIT 1) + 1,
                                        1)
                                    ),
                                    :nis,
                                    :class_group,
                                    :status,
                                    NOW(),
                                    NOW());
                            ');
        $sth->bindValue(':nis', $data['nis']);    
        $sth->bindValue(':class_group', $data['class_group']);    
        $sth->bindValue(':status', $data['status']);
        
        return $sth->execute();
    }
    
    public function selectAllClassHistory() {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_classhistory.classhistory_id,
                                    academic_classhistory.classhistory_student,
                                    academic_classhistory.classhistory_classgroup,
                                    academic_classhistory.classhistory_status,
                                    academic_classhistory.classhistory_entry,
                                    academic_classhistory.classhistory_entry_update
                                FROM
                                    academic_classhistory
                            ');        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function updateClassHistory($newid, $oldid) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_classhistory
                                SET
                                    classhistory_id = :newid
                                WHERE
                                    academic_classhistory.classhistory_id = :oldid
                            ');        
        $sth->bindValue(':newid' , $newid);
        $sth->bindValue(':oldid' , $oldid);
        return $sth->execute();
    }
    
}