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

    public function saveAccount($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    myschool_user(
                                    user_id,
                                    user_references,
                                    user_name,
                                    user_password,
                                    user_about,
                                    user_photo_profile,
                                    user_isa,
                                    user_entry,
                                    user_update,
                                    user_status)
                                  VALUES(
                                    ( SELECT IF (
                                        (SELECT COUNT(e.user_id) FROM myschool_user AS e 
                                                WHERE e.user_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.user_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.user_id + 1 ) FROM myschool_user AS e 
                                                WHERE e.user_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.user_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0000001")))
                                    ),
                                    :references,
                                    :username,
                                    PASSWORD(:password),
                                    NULL,
                                    "default-thumbnail.png",
                                    2,
                                    NOW(),
                                    NOW(),
                                    1);
                            ');

        $sth->bindValue(':references', $data['references']);
        $sth->bindValue(':username', $data['username']);
        $sth->bindValue(':password', $data['password']);
        return $sth->execute();
    }

    public function saveMlc($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_mlc(
                                        mlc_id,
                                        mlc_subject,
                                        mlc_period,
                                        mlc_semester,
                                        mlc_grade,
                                        mlc_value,
                                        mlc_entry,
                                        mlc_entry_update)
                                  VALUES(
                                        ( SELECT IF (
                                            (SELECT COUNT(e.mlc_id) FROM academic_mlc AS e 
                                                    WHERE e.mlc_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.mlc_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.mlc_id + 1 ) FROM academic_mlc AS e 
                                                    WHERE e.mlc_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.mlc_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                        ),
                                        :subject,
                                        :period,
                                        :semester,
                                        :grade,
                                        :value,
                                        NOW(),
                                        NOW())
                            ');

        $sth->bindValue(':subject', $data['subject']);
        $sth->bindValue(':period', $data['period']);
        $sth->bindValue(':semester', $data['semester']);
        $sth->bindValue(':grade', $data['grade']);
        $sth->bindValue(':value', $data['value']);
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
                                    (SELECT IF (
                                        (SELECT COUNT(e.classhistory_id) FROM academic_classhistory AS e 
                                                WHERE e.classhistory_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.classhistory_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.classhistory_id + 1 ) FROM academic_classhistory AS e 
                                                WHERE e.classhistory_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.classhistory_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :nis,
                                    :class_group,
                                    :status,
                                    NOW(),
                                    NOW())
                            ');
        $sth->bindValue(':nis', $data['nis']);
        $sth->bindValue(':class_group', $data['class_group']);
        $sth->bindValue(':status', $data['status']);

        return $sth->execute();
    }

    public function saveTeaching($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_teaching(
                                        teaching_id,
                                        teaching_teacher,
                                        teaching_classgroup,
                                        teaching_subject,
                                        teaching_total_time,
                                        teaching_period,
                                        teaching_semester,
                                        teaching_entry,
                                        teaching_entry_update)
                                  VALUES(
                                    (SELECT IF (
                                        (SELECT COUNT(e.teaching_id) FROM academic_teaching AS e 
                                                WHERE e.teaching_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.teaching_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.teaching_id + 1 ) FROM academic_teaching AS e 
                                                WHERE e.teaching_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.teaching_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :id,
                                    :classgrop,
                                    :subject,
                                    :time,
                                    :period,
                                    :semester,
                                    NOW(),
                                    NOW())
                            ');

        $sth->bindValue(':id', $data['id']);
        $sth->bindValue(':classgrop', $data['kelas']);
        $sth->bindValue(':subject', $data['mapel']);
        $sth->bindValue(':time', $data['jam']);
        $sth->bindValue(':period', $data['period']);
        $sth->bindValue(':semester', $data['semester']);

        return $sth->execute();
    }

    public function saveGuidance($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_guidance(
                                        guidance_id,
                                        guidance_classgroup,
                                        guidance_teacher,
                                        guidance_period,
                                        guidance_semester,
                                        guidance_entry,
                                        guidance_entry_update)
                                  VALUES(
                                        (SELECT IF (
                                            (SELECT COUNT(e.guidance_id) FROM academic_guidance AS e 
                                                    WHERE e.guidance_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.guidance_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.guidance_id + 1 ) FROM academic_guidance AS e 
                                                    WHERE e.guidance_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.guidance_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                        ),
                                        :classgroup,
                                        :teacher,
                                        :period,
                                        :semester,
                                        NOW(),
                                        NOW())
                            ');

        $sth->bindValue(':classgroup', $data['classgroup']);
        $sth->bindValue(':teacher', $data['teacher']);
        $sth->bindValue(':period', $data['period']);
        $sth->bindValue(':semester', $data['semester']);

        return $sth->execute();
    }
    
    public function saveGuidanceEskul($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_extracurricular_coach_history(
                                        extracurricular_coach_history_id,
                                        extracurricular_coach_history_name,
                                        extracurricular_coach_history_field,
                                        extracurricular_coach_history_period,
                                        extracurricular_coach_history_semester,
                                        extracurricular_coach_history_totaltime,
                                        extracurricular_coach_history_entry,
                                        extracurricular_coach_history_entry_update)
                                  VALUES(
                                        (SELECT IF (
                                            (SELECT COUNT(e.extracurricular_coach_history_id) FROM academic_extracurricular_coach_history AS e 
                                                    WHERE e.extracurricular_coach_history_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.extracurricular_coach_history_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.extracurricular_coach_history_id + 1 ) FROM academic_extracurricular_coach_history AS e 
                                                    WHERE e.extracurricular_coach_history_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.extracurricular_coach_history_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                        ),
                                        :teacher,
                                        :eskul,
                                        :period,
                                        :semester,
                                        2,
                                        NOW(),
                                        NOW())
                            ');

        $sth->bindValue(':eskul', $data['eskul']);
        $sth->bindValue(':teacher', $data['teacher']);
        $sth->bindValue(':period', $data['period']);
        $sth->bindValue(':semester', $data['semester']);

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
        $sth->bindValue(':newid', $newid);
        $sth->bindValue(':oldid', $oldid);
        return $sth->execute();
    }
    
    
    public function saveEskulParticipan($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_extracurricular_participant(
                                        extracurricular_participant_id,
                                        extracurricular_participant_name,
                                        extracurricular_participant_activity,
                                        extracurricular_participant_entry,
                                        extracurricular_participant_entry_update)
                                  VALUES(
                                        ( SELECT IF (
                                            (SELECT COUNT(e.extracurricular_participant_id) FROM academic_extracurricular_participant AS e 
                                                    WHERE e.extracurricular_participant_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.extracurricular_participant_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.extracurricular_participant_id + 1 ) FROM academic_extracurricular_participant AS e 
                                                    WHERE e.extracurricular_participant_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.extracurricular_participant_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                        ),
                                        :student,
                                        :eskul,
                                        NOW(),
                                        NOW())
                            ');

        $sth->bindValue(':student', $data['student']);
        $sth->bindValue(':eskul', $data['eskul']);
        return $sth->execute();
    }

}