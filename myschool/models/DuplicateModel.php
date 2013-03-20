<?php

class DuplicateModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function selectClassGroupByPeriod($period_id) {
        $sth = $this->db->prepare("
              SELECT 
                academic_classgroup.classgroup_id,
                academic_classgroup.classgroup_grade,
                academic_classgroup.classgroup_name,
                academic_classgroup.classgroup_room,
                academic_classgroup.classgroup_period,
                academic_classgroup.classgroup_semester,
                academic_classgroup.classgroup_guardian,
                academic_classgroup.classgroup_entry,
                academic_classgroup.classgroup_entry_update
              FROM
                academic_classgroup
              WHERE
                academic_classgroup.classgroup_period = :period_id
            ");
        $sth->bindValue(':period_id', $period_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
        
    public function saveClassGroup($data) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_classgroup(
                                    classgroup_id,
                                    classgroup_grade,
                                    classgroup_name,
                                    classgroup_room,
                                    classgroup_period,
                                    classgroup_semester,
                                    classgroup_guardian,
                                    classgroup_entry,
                                    classgroup_entry_update)
                                  VALUES(
                                    ( SELECT IF (
                                        (SELECT COUNT(e.classgroup_id) FROM academic_classgroup AS e 
                                                WHERE e.classgroup_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.classgroup_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.classgroup_id + 1 ) FROM academic_classgroup AS e 
                                                WHERE e.classgroup_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.classgroup_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :grade,
                                    :name,
                                    :room,
                                    :period,
                                    :semester,
                                    :guardian,
                                    NOW(),
                                    NOW())
                            ');
        $sth->bindValue(':grade', $data['grade']);
        $sth->bindValue(':name', $data['name']);
        $sth->bindValue(':room', $data['room']);
        $sth->bindValue(':period', $data['period']);
        $sth->bindValue(':semester', $data['semester']);
        $sth->bindValue(':guardian', $data['guardian']);
        return $sth->execute();
    }
        
    public function selectTeachingByPeriod($period_id) {
        $sth = $this->db->prepare("
              SELECT 
                academic_teaching.teaching_id,
                academic_teaching.teaching_teacher,
                academic_teaching.teaching_classgroup,
                academic_teaching.teaching_subject,
                academic_teaching.teaching_total_time,
                academic_teaching.teaching_period,
                academic_teaching.teaching_semester,
                academic_teaching.teaching_entry,
                academic_teaching.teaching_entry_update
              FROM
                academic_teaching
              WHERE
                academic_teaching.teaching_period = :period_id
            ");
        $sth->bindValue(':period_id', $period_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
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
                                    ( SELECT IF (
                                        (SELECT COUNT(e.teaching_id) FROM academic_teaching AS e 
                                                WHERE e.teaching_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.teaching_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.teaching_id + 1 ) FROM academic_teaching AS e 
                                                WHERE e.teaching_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.teaching_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :teacher,
                                    :classgroup,
                                    :subject,
                                    :total_time,
                                    :period,
                                    :semester,
                                    NOW(),
                                    NOW())
                            ');
        $sth->bindValue(':teacher', $data['teacher']);
        $sth->bindValue(':classgroup', $data['classgroup']);
        $sth->bindValue(':subject', $data['subject']);
        $sth->bindValue(':total_time', $data['total_time']);
        $sth->bindValue(':period', $data['period']);
        $sth->bindValue(':semester', $data['semester']);
        return $sth->execute();
    }
    
    public function selectMlcByPeriod($period_id) {
        $sth = $this->db->prepare("
              SELECT 
                academic_mlc.mlc_id,
                academic_mlc.mlc_subject,
                academic_mlc.mlc_period,
                academic_mlc.mlc_semester,
                academic_mlc.mlc_grade,
                academic_mlc.mlc_value,
                academic_mlc.mlc_entry,
                academic_mlc.mlc_entry_update
              FROM
                academic_mlc
              WHERE
                academic_mlc.mlc_period = :period_id
            ");
        $sth->bindValue(':period_id', $period_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
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
    
    public function selectClassHistoryByPeriod($period_id) {
        $sth = $this->db->prepare("
              SELECT 
                academic_classhistory.classhistory_id,
                academic_classhistory.classhistory_student,
                academic_classhistory.classhistory_classgroup,
                academic_classhistory.classhistory_status,
                academic_classhistory.classhistory_entry,
                academic_classhistory.classhistory_entry_update
              FROM
                academic_classhistory
                INNER JOIN academic_classgroup ON (academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id)
              WHERE
                academic_classgroup.classgroup_period = :period_id
              ORDER BY
                academic_classhistory.classhistory_id
              LIMIT 1000,100
            ");
        $sth->bindValue(':period_id', $period_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function saveClassHistotry($data) {
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
                                    ( SELECT IF (
                                        (SELECT COUNT(e.classhistory_id) FROM academic_classhistory AS e 
                                                WHERE e.classhistory_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.classhistory_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.classhistory_id + 1 ) FROM academic_classhistory AS e 
                                                WHERE e.classhistory_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.classhistory_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :student,
                                    :classgroup,
                                    :status,
                                    NOW(),
                                    NOW())
                            ');
        
        $sth->bindValue(':student', $data['student']);
        $sth->bindValue(':classgroup', $data['classgroup']);
        $sth->bindValue(':status', $data['status']);
        
        return $sth->execute();
    }
    
    public function selectGuidanceByPeriod($period_id) {
        $sth = $this->db->prepare("
              SELECT 
                academic_guidance.guidance_id,
                academic_guidance.guidance_classgroup,
                academic_guidance.guidance_teacher,
                academic_guidance.guidance_period,
                academic_guidance.guidance_semester,
                academic_guidance.guidance_entry,
                academic_guidance.guidance_entry_update
              FROM
                academic_guidance
            ");
        $sth->bindValue(':period_id', $period_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
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
                                    ( SELECT IF (
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
    
}