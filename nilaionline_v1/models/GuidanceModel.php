<?php

class GuidanceModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectTeacherInformationById($id = 0) {
        $sth = $this->db->prepare("
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
                                    employees.employees_id = :id
                                ");

        $sth->bindValue(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllSemester() {
        $sth = $this->db->prepare('
                            SELECT 
                                academic_semester.semester_id,
                                academic_semester.semester_name
                            FROM
                                academic_semester
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllPeriod() {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_period.period_id,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end,
                                    academic_period.period_status
                                FROM
                                    academic_period
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTeaching($teacherid, $periodid, $semesterid) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_guidance.guidance_id,
                                    academic_classroom.classroom_name,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    employees.employees_nip,
                                    employees.employess_name,
                                    academic_guidance.guidance_entry_update,
                                    (SELECT COUNT(academic_classhistory.classhistory_id) FROM academic_classhistory WHERE academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id ) AS student_count
                                  FROM
                                    academic_guidance
                                    INNER JOIN academic_classgroup ON (academic_guidance.guidance_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                                  WHERE
                                    academic_guidance.guidance_teacher = :teacherid AND 
                                    academic_guidance.guidance_period = :periodid AND 
                                    academic_guidance.guidance_semester = :semesterid
                          ');

        $sth->bindValue(':teacherid', $teacherid);
        $sth->bindValue(':periodid', $periodid);
        $sth->bindValue(':semesterid', $semesterid);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectClassListByTeachingId($teachingid, $user_references) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_guidance.guidance_id,
                                    academic_classroom.classroom_name,
                                    academic_grade.grade_id,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    employees.employees_id,
                                    employees.employees_nip,
                                    employees.employess_name,
                                    academic_guidance.guidance_entry_update,
                                    (SELECT COUNT(academic_classhistory.classhistory_id) AS FIELD_1 FROM academic_classhistory WHERE academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id) AS student_count,
                                    academic_period.period_id,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end,
                                    academic_semester.semester_name,
                                    academic_semester.semester_id,
                                    academic_classgroup.classgroup_id
                                  FROM
                                    academic_guidance
                                    INNER JOIN academic_classgroup ON (academic_guidance.guidance_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                                    INNER JOIN academic_period ON (academic_guidance.guidance_period = academic_period.period_id)
                                    INNER JOIN academic_semester ON (academic_guidance.guidance_semester = academic_semester.semester_id)
                                  WHERE
                                    academic_guidance.guidance_id = :teachingid AND 
                                    academic_guidance.guidance_teacher = :user_references
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teachingid', $teachingid);
        $sth->bindValue(':user_references', $user_references);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectStudentByClassGroupId($classgroupid) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_student.student_nis,
                                    academic_student.student_nisn,
                                    academic_student.student_name,
                                    public_gender.gender_title
                                FROM
                                    academic_classhistory
                                    INNER JOIN academic_student ON (academic_classhistory.classhistory_student = academic_student.student_nis)
                                    INNER JOIN public_gender ON (academic_student.student_gender = public_gender.gender_id)
                                WHERE
                                    academic_classhistory.classhistory_classgroup = :classgroupid
                                ORDER BY academic_student.student_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':classgroupid', $classgroupid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSocoreByScoreFilter($student, $teaching, $type) {
        $sth = $this->db->prepare('
                                      SELECT 
                                        academic_score.score_id,
                                        academic_score.score_student,
                                        academic_score.score_value
                                      FROM
                                        academic_score
                                      WHERE
                                        academic_score.score_student IN (' . $student . ') AND 
                                        academic_score.score_teaching = :teaching AND 
                                        academic_score.score_type = :type
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teaching', $teaching);
        $sth->bindValue(':type', $type);
        $sth->execute();
        return $sth->fetchAll();
    }
}