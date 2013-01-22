<?php

class PercentaseModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectPeriodById($period_id) {
        $sth = $this->db->prepare('
                              SELECT 
                                academic_period.period_id,
                                academic_period.period_years_start,
                                academic_period.period_years_end
                              FROM
                                academic_period
                              WHERE
                                academic_period.period_id = :period_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period_id', $period_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSemesterById($semester_id) {
        $sth = $this->db->prepare('
                              SELECT 
                                academic_semester.semester_id,
                                academic_semester.semester_name
                              FROM
                                academic_semester
                              WHERE
                                academic_semester.semester_id = :semester_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':semester_id', $semester_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectGradeById($grade_id) {
        $sth = $this->db->prepare('
                              SELECT 
                                academic_grade.grade_id,
                                academic_grade.grade_title,
                                academic_grade.grade_name
                              FROM
                                academic_grade
                              WHERE
                                academic_grade.grade_id = :grade_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':grade_id', $grade_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSubjectById($subject_id) {
        $sth = $this->db->prepare('
                              SELECT 
                                academic_subject.subject_id,
                                academic_subject.subject_name
                              FROM
                                academic_subject
                              WHERE
                                academic_subject.subject_id = :subject_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':subject_id', $subject_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSubjectTeaching($teacher_id, $periodid) {
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

    public function selectRecapType() {
        $sth = $this->db->prepare('
                                 SELECT 
                                    academic_recapitulation_type.recapitulation_type_id,
                                    academic_recapitulation_type.recapitulation_type_title,
                                    academic_recapitulation_type.recapitulation_type_reference,
                                    academic_recapitulation_type.recapitulation_type_entry,
                                    academic_recapitulation_type.recapitulation_type_entry_update
                                  FROM
                                    academic_recapitulation_type
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectPercentase($recap_type, $teacher, $subject, $grade, $period, $semester) {
        $sth = $this->db->prepare('
                                 SELECT 
                                    academic_score_percentase.score_percentase_id,
                                    academic_score_percentase.score_percentase_value,
                                    academic_score_percentase.score_percentase_entry_update
                                  FROM
                                    academic_score_percentase
                                  WHERE
                                    academic_score_percentase.score_percentase_recap = :recap_type AND 
                                    academic_score_percentase.score_percentase_teacher = :teacher AND 
                                    academic_score_percentase.score_percentase_subject = :subject AND 
                                    academic_score_percentase.score_percentase_grade = :grade AND 
                                    academic_score_percentase.score_percentase_period = :period AND 
                                    academic_score_percentase.score_percentase_semester = :semester
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':recap_type', $recap_type);
        $sth->bindValue(':teacher', $teacher);
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function savePercentase($recap_type, $teacher, $subject, $grade, $period, $semester, $value) {
        $sth = $this->db->prepare('
                                 INSERT INTO
                                    academic_score_percentase(
                                    score_percentase_id,
                                    score_percentase_recap,
                                    score_percentase_teacher,
                                    score_percentase_subject,
                                    score_percentase_grade,
                                    score_percentase_period,
                                    score_percentase_semester,
                                    score_percentase_value,
                                    score_percentase_entry,
                                    score_percentase_entry_update)
                                  VALUES(
                                    ( SELECT IF (
                                        (SELECT COUNT(e.score_percentase_id) FROM academic_score_percentase AS e 
                                                WHERE e.score_percentase_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_percentase_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.score_percentase_id + 1 ) FROM academic_score_percentase AS e 
                                                WHERE e.score_percentase_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_percentase_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0001")))
                                    ),
                                    :recap_type,
                                    :teacher,
                                    :subject,
                                    :grade,
                                    :period,
                                    :semester,
                                    :value,
                                    NOW(),
                                    NOW())
                          ');
        $sth->bindValue(':recap_type', $recap_type);
        $sth->bindValue(':teacher', $teacher);
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':value', $value);
        return $sth->execute();
    }
    
    public function updatePercentase($id, $value) {
        $sth = $this->db->prepare('
                                 UPDATE
                                    academic_score_percentase
                                  SET
                                    score_percentase_value = :value,
                                    score_percentase_entry_update = NOW()
                                  WHERE
                                    academic_score_percentase.score_percentase_id = :id
                          ');
        $sth->bindValue(':id', $id);
        $sth->bindValue(':value', $value);
        return $sth->execute();
    }

}