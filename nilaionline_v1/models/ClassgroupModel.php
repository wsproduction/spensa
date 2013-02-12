<?php

class ClassgroupModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function selectClassListByTeachingId($teachingid, $user_references) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_teaching.teaching_id,
                                    academic_teaching.teaching_teacher,
                                    academic_teaching.teaching_classgroup,
                                    academic_teaching.teaching_subject,
                                    academic_teaching.teaching_total_time,
                                    academic_teaching.teaching_period,
                                    academic_teaching.teaching_semester,
                                    academic_teaching.teaching_entry,
                                    academic_teaching.teaching_entry_update,
                                    academic_classgroup.classgroup_id,
                                    academic_classroom.classroom_name,
                                    academic_grade.grade_id,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    employees.employees_id,
                                    employees.employees_nip,
                                    employees.employess_name,
                                    academic_period.period_id,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end,
                                    academic_semester.semester_id,
                                    academic_semester.semester_name,
                                    academic_subject.subject_id,
                                    academic_subject.subject_name,
                                    academic_mlc.mlc_value
                                  FROM
                                    academic_teaching
                                    INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                                    INNER JOIN academic_period ON (academic_teaching.teaching_period = academic_period.period_id)
                                    INNER JOIN academic_semester ON (academic_teaching.teaching_semester = academic_semester.semester_id)
                                    INNER JOIN academic_subject ON (academic_teaching.teaching_subject = academic_subject.subject_id)
                                    INNER JOIN academic_mlc ON (academic_subject.subject_id = academic_mlc.mlc_subject)
                                    AND (academic_mlc.mlc_period = academic_period.period_id)
                                    AND (academic_mlc.mlc_grade = academic_grade.grade_id)
                                    AND (academic_mlc.mlc_semester = academic_semester.semester_id)
                                  WHERE
                                    academic_teaching.teaching_id = :teachingid AND 
                                    academic_teaching.teaching_teacher = :user_references
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

    public function updateScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_score
                                  SET
                                    score_value = :score,
                                    score_entry_update = NOW()
                                  WHERE
                                    academic_score.score_id = :scoreid
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function saveScore($student_id, $score, $teaching_id, $type_id) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_score(
                                    score_id,
                                    score_student,
                                    score_teaching,
                                    score_type,
                                    score_value,
                                    score_status,
                                    score_entry,
                                    score_entry_update)
                                  VALUES(
                                    (SELECT IF (
                                        (SELECT COUNT(e.score_id) FROM academic_score AS e 
                                                WHERE e.score_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.score_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.score_id + 1 ) FROM academic_score AS e 
                                                WHERE e.score_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.score_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :student,
                                    :teaching,
                                    :type,
                                    :score,
                                    1,
                                    NOW(),
                                    NOW())
                          ');
        $sth->bindValue(':student', $student_id);
        $sth->bindValue(':teaching', $teaching_id);
        $sth->bindValue(':type', $type_id);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

}