<?php

class TeachingModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectTeaching() {
        $sth = $this->db->prepare('
                                SELECT
                                    academic_teaching.teaching_id,
                                    academic_teaching.teaching_total_time,
                                    academic_subject.subject_id,
                                    academic_subject.subject_name,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    academic_classroom.classroom_name,
                                    employees.employess_name
                                FROM
                                    academic_subject
                                    INNER JOIN academic_teaching ON (academic_subject.subject_id = academic_teaching.teaching_subject)
                                    INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                          ');
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

    public function selectClassListByTeachingId($teachingid) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_teaching.teaching_total_time,
                                    academic_classroom.classroom_name,
                                    academic_classgroup.classgroup_id,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    employees.employess_name,
                                    academic_subject.subject_id,
                                    academic_subject.subject_name,
                                    academic_period.period_id,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end,
                                    (SELECT academic_mlc.mlc_value FROM academic_mlc WHERE academic_mlc.mlc_subject = academic_subject.subject_id AND academic_mlc.mlc_period = academic_classgroup.classgroup_period AND academic_mlc.mlc_grade = academic_classgroup.classgroup_grade) AS mlc_value
                                FROM
                                    academic_teaching
                                    INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                                    INNER JOIN academic_subject ON (academic_teaching.teaching_subject = academic_subject.subject_id)
                                    INNER JOIN academic_period ON (academic_classgroup.classgroup_period = academic_period.period_id)
                                WHERE
                                    academic_teaching.teaching_id = :teachingid
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teachingid', $teachingid);
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

    public function selectBaseCompetence() {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_base_competence.base_competence_id,
                                    academic_base_competence.base_competence_title,
                                    academic_base_competence.base_competence_period,
                                    academic_base_competence.base_competence_semester,
                                    academic_base_competence.base_competence_subject,
                                    academic_base_competence.base_competence_grade,
                                    academic_base_competence.base_competence_entry,
                                    academic_base_competence.base_competence_entry_update,
                                    academic_base_competence_symbol.base_competence_symbol
                                FROM
                                    academic_base_competence
                                    INNER JOIN academic_base_competence_symbol ON (academic_base_competence.base_competence_symbol = academic_base_competence_symbol.base_competence_symbol_id)
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectScoreType() {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_score_type.score_type_id,
                                    academic_score_type.score_type_symbol,
                                    academic_score_type.score_type_description
                                FROM
                                    academic_score_type
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectDailySocoreByScoreFilter($student_id, $periode, $semester, $base_competence, $score_type) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_score_daily.score_daily_id,
                                    academic_score_daily.score_daily_student,
                                    academic_score_daily.score_daily_semester,
                                    academic_score_daily.score_daily_period,
                                    academic_score_daily.score_daily_value,
                                    academic_score_daily.score_daily_competence,
                                    academic_score_daily.score_daily_type
                                FROM
                                    academic_score_daily
                                WHERE
                                    academic_score_daily.score_daily_student IN (' . $student_id . ') AND 
                                    academic_score_daily.score_daily_period = :period AND 
                                    academic_score_daily.score_daily_semester = :semester AND 
                                    academic_score_daily.score_daily_competence = :base_competence AND 
                                    academic_score_daily.score_daily_type = :score_type
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period', $periode);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':base_competence', $base_competence);
        $sth->bindValue(':score_type', $score_type);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveDailyScore($student_id, $score, $periode, $semester, $base_competence, $score_type) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                academic_score_daily(
                                    score_daily_id,
                                    score_daily_student,
                                    score_daily_semester,
                                    score_daily_period,
                                    score_daily_value,
                                    score_daily_competence,
                                    score_daily_type,
                                    score_daily_entry,
                                    score_daily_entry_update)
                                VALUES(
                                ( SELECT IF (
                                    (SELECT COUNT(e.score_daily_id) FROM academic_score_daily AS e 
                                            WHERE e.score_daily_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                            ORDER BY e.score_daily_id DESC LIMIT 1
                                    ) > 0,
                                    (SELECT ( e.score_daily_id + 1 ) FROM academic_score_daily AS e 
                                            WHERE e.score_daily_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                            ORDER BY e.score_daily_id DESC LIMIT 1),
                                    (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0001")))
                                ),
                                :student_id,
                                :semester,
                                :period,
                                :score,
                                :base_competence,
                                :score_type,
                                NOW(),
                                NOW());
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':student_id', $student_id);
        $sth->bindValue(':score', $score);
        $sth->bindValue(':period', $periode);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':base_competence', $base_competence);
        $sth->bindValue(':score_type', $score_type);
        return $sth->execute();
    }

    public function updateDailyScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_score_daily
                                SET
                                    score_daily_value = :score,
                                    score_daily_entry = NOW()
                                WHERE
                                    academic_score_daily.score_daily_id = :scoreid ;
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function selectBaseCompetenceById($base_competence_id) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_base_competence.base_competence_title,
                                    academic_base_competence.base_competence_id,
                                    academic_base_competence.base_competence_period,
                                    academic_base_competence.base_competence_semester,
                                    academic_base_competence.base_competence_subject,
                                    academic_base_competence.base_competence_grade,
                                    academic_base_competence.base_competence_entry,
                                    academic_base_competence.base_competence_entry_update,
                                    academic_base_competence_symbol.base_competence_symbol,
                                    academic_base_competence_symbol.base_competence_symbol_id
                                FROM
                                    academic_base_competence
                                    INNER JOIN academic_base_competence_symbol ON (academic_base_competence.base_competence_symbol = academic_base_competence_symbol.base_competence_symbol_id)
                                WHERE
                                    academic_base_competence.base_competence_id = :base_competence_id
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':base_competence_id', $base_competence_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectScoreTypeById($score_type_id) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_score_type.score_type_id,
                                    academic_score_type.score_type_symbol,
                                    academic_score_type.score_type_description
                                FROM
                                    academic_score_type
                                WHERE
                                    academic_score_type.score_type_id = :score_type_id
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':score_type_id', $score_type_id);
        $sth->execute();
        return $sth->fetchAll();
    }

}