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
                                WHERE
                                    academic_period.period_status <> 0 
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

    public function selectSocoreByScoreFilter($student, $teaching, $desc, $type) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        academic_score_guidance.score_guidance_id,
                                        academic_score_guidance.score_guidance_student,
                                        academic_score_guidance.score_guidance_value
                                      FROM
                                        academic_score_guidance
                                      WHERE
                                        academic_score_guidance.score_guidance_student IN (' . $student . ') AND 
                                        academic_score_guidance.score_guidance_guidance = :teaching AND 
                                        academic_score_guidance.score_guidance_desc = :desc AND 
                                        academic_score_guidance.score_guidance_type = :type
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teaching', $teaching);
        $sth->bindValue(':desc', $desc);
        $sth->bindValue(':type', $type);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function updateScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                 UPDATE
                                    academic_score_guidance
                                  SET
                                    score_guidance_value = :score,
                                    score_guidance_entry_update = NOW()
                                  WHERE
                                    score_guidance_id = :scoreid
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function saveScore($student_id, $score, $teaching_id, $desc, $type_id) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_score_guidance(
                                        score_guidance_id,
                                        score_guidance_student,
                                        score_guidance_guidance,
                                        score_guidance_value,
                                        score_guidance_desc,
                                        score_guidance_type,
                                        score_guidance_entry,
                                        score_guidance_entry_update)
                                  VALUES(
                                        (SELECT IF (
                                            (SELECT COUNT(e.score_guidance_id) FROM academic_score_guidance AS e 
                                                    WHERE e.score_guidance_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.score_guidance_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.score_guidance_id + 1 ) FROM academic_score_guidance AS e 
                                                    WHERE e.score_guidance_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.score_guidance_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                        ),
                                        :student,
                                        :teaching,
                                        :score,
                                        :desc,
                                        :type,
                                        NOW(),
                                        NOW())
                          ');
        $sth->bindValue(':student', $student_id);
        $sth->bindValue(':teaching', $teaching_id);
        $sth->bindValue(':desc', $desc);
        $sth->bindValue(':type', $type_id);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function selectAttendanceByScoreFilter($student, $teaching, $type) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        academic_attendance.attendance_id,
                                        academic_attendance.attendance_student,
                                        academic_attendance.attendance_sick,
                                        academic_attendance.attendance_leave,
                                        academic_attendance.attendance_alpha
                                      FROM
                                        academic_attendance
                                      WHERE
                                        academic_attendance.attendance_student IN (' . $student . ') AND 
                                        academic_attendance.attendance_guidance = :teaching  AND 
                                        academic_attendance.attendance_score_type = :type
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teaching', $teaching);
        $sth->bindValue(':type', $type);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function updateAttendance($scoreid, $s, $l, $a) {
        $sth = $this->db->prepare('
                                 UPDATE
                                    academic_attendance
                                  SET
                                    academic_attendance.attendance_sick  = :sick,
                                    academic_attendance.attendance_leave = :leave,
                                    academic_attendance.attendance_alpha = :alpha,
                                    attendance_entry_update = NOW()
                                  WHERE
                                    attendance_id = :scoreid
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':sick', $s);
        $sth->bindValue(':leave', $l);
        $sth->bindValue(':alpha', $a);
        return $sth->execute();
    }

    public function saveAttendance($student_id, $s, $l, $a, $teaching_id, $type_id) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_attendance(
                                        attendance_id,
                                        attendance_student,
                                        attendance_guidance,
                                        attendance_sick,
                                        attendance_leave,
                                        attendance_alpha,
                                        attendance_score_type,
                                        attendance_entry,
                                        attendance_entry_update)
                                  VALUES(
                                        (SELECT IF (
                                            (SELECT COUNT(e.attendance_id) FROM academic_attendance AS e 
                                                    WHERE e.attendance_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.attendance_id DESC LIMIT 1
                                            ) > 0,
                                            (SELECT ( e.attendance_id + 1 ) FROM academic_attendance AS e 
                                                    WHERE e.attendance_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                    ORDER BY e.attendance_id DESC LIMIT 1),
                                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                        ),
                                        :student,
                                        :teaching,
                                        :sick,
                                        :leave,
                                        :alpha,
                                        :type,
                                        NOW(),
                                        NOW())
                          ');
        $sth->bindValue(':student', $student_id);
        $sth->bindValue(':teaching', $teaching_id);
        $sth->bindValue(':type', $type_id);
        $sth->bindValue(':sick', $s);
        $sth->bindValue(':leave', $l);
        $sth->bindValue(':alpha', $a);
        return $sth->execute();
    }

}