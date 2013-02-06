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

    public function selectMidSocoreByScoreFilter($student_id, $subject, $period, $semester) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        academic_score_mid.score_mid_id,
                                        academic_score_mid.score_mid_value,
                                        academic_score_mid.score_mid_student,
                                        academic_score_mid.score_mid_period,
                                        academic_score_mid.score_mid_semester,
                                        academic_score_mid.score_mid_subject,
                                        academic_score_mid.score_mid_entry,
                                        academic_score_mid.score_mid_entry_update
                                      FROM
                                        academic_score_mid
                                      WHERE
                                        academic_score_mid.score_mid_student IN (' . $student_id . ') AND 
                                        academic_score_mid.score_mid_period = :period AND 
                                        academic_score_mid.score_mid_semester = :semester  AND 
                                        academic_score_mid.score_mid_subject = :subject
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':subject', $subject);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectFinalSocoreByScoreFilter($student_id, $subject, $period, $semester) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        academic_score_final.score_final_id,
                                        academic_score_final.score_final_student,
                                        academic_score_final.score_final_subject,
                                        academic_score_final.score_final_period,
                                        academic_score_final.score_final_semester,
                                        academic_score_final.score_final_value,
                                        academic_score_final.score_final_entry,
                                        academic_score_final.score_final_entry_update
                                      FROM
                                        academic_score_final
                                      WHERE
                                        academic_score_final.score_final_student  IN (' . $student_id . ') AND 
                                        academic_score_final.score_final_subject = :subject AND 
                                        academic_score_final.score_final_period = :period AND 
                                        academic_score_final.score_final_semester = :semester
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':subject', $subject);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function updateMidScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_score_mid
                                SET
                                    score_mid_value = :score,
                                    score_mid_entry_update = NOW()
                                WHERE
                                    academic_score_mid.score_mid_id = :scoreid ;
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function saveMidScore($student_id, $score, $subject_id, $peiod_id, $semester_id) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_score_mid(
                                    score_mid_id,
                                    score_mid_value,
                                    score_mid_student,
                                    score_mid_period,
                                    score_mid_semester,
                                    score_mid_subject,
                                    score_mid_entry,
                                    score_mid_entry_update)
                                  VALUES(
                                    ( SELECT IF (
                                        (SELECT COUNT(e.score_mid_id) FROM academic_score_mid AS e 
                                                WHERE e.score_mid_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_mid_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.score_mid_id + 1 ) FROM academic_score_mid AS e 
                                                WHERE e.score_mid_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_mid_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0001")))
                                    ),
                                    :score,
                                    :student_id,
                                    :period_id,
                                    :semester_id,
                                    :subject_id,
                                    NOW(),
                                    NOW());
                          ');
        $sth->bindValue(':student_id', $student_id);
        $sth->bindValue(':score', $score);
        $sth->bindValue(':period_id', $peiod_id);
        $sth->bindValue(':semester_id', $semester_id);
        $sth->bindValue(':subject_id', $subject_id);
        return $sth->execute();
    }

    public function updateFinalScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_score_final
                                SET
                                    score_final_value = :score,
                                    score_final_entry_update = NOW()
                                WHERE
                                    academic_score_final.score_final_id = :scoreid;
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function saveFinalScore($student_id, $score, $subject_id, $peiod_id, $semester_id) {
        $sth = $this->db->prepare('
                            INSERT INTO
                                academic_score_final(
                                score_final_id,
                                score_final_student,
                                score_final_subject,
                                score_final_period,
                                score_final_semester,
                                score_final_value,
                                score_final_entry,
                                score_final_entry_update)
                              VALUES(
                                ( SELECT IF (
                                    (SELECT COUNT(e.score_final_id) FROM academic_score_final AS e 
                                            WHERE e.score_final_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                            ORDER BY e.score_final_id DESC LIMIT 1
                                    ) > 0,
                                    (SELECT ( e.score_final_id + 1 ) FROM academic_score_final AS e 
                                            WHERE e.score_final_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                            ORDER BY e.score_final_id DESC LIMIT 1),
                                    (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0001")))
                                ),
                                :student_id,
                                :subject_id,
                                :period_id,
                                :semester_id,
                                :score,
                                NOW(),
                                NOW());
                          ');
        $sth->bindValue(':student_id', $student_id);
        $sth->bindValue(':score', $score);
        $sth->bindValue(':period_id', $peiod_id);
        $sth->bindValue(':semester_id', $semester_id);
        $sth->bindValue(':subject_id', $subject_id);
        return $sth->execute();
    }

}