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
    
}