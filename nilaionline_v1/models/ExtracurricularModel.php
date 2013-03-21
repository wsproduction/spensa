<?php

class ExtracurricularModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectExtracurricularCoachById($coachid, $user_references) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_extracurricular.extracurricular_name,
                                    extracurricular_coach_history_totaltime,
                                    academic_period.period_id,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end,
                                    academic_semester.semester_id,
                                    academic_semester.semester_name
                                  FROM
                                    academic_extracurricular_coach_history
                                    INNER JOIN academic_extracurricular ON (academic_extracurricular_coach_history.extracurricular_coach_history_field = academic_extracurricular.extracurricular_id)
                                    INNER JOIN academic_period ON (academic_extracurricular_coach_history.extracurricular_coach_history_period = academic_period.period_id)
                                    INNER JOIN academic_semester ON (academic_extracurricular_coach_history.extracurricular_coach_history_semester = academic_semester.semester_id)
                                  WHERE
                                    academic_extracurricular_coach_history.extracurricular_coach_history_id = :coachid AND 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_name = :user_references
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':coachid', $coachid);
        $sth->bindValue(':user_references', $user_references);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectStudentByClassGroupId($classgroupid) {
        $sth = $this->db->prepare('
                                 SELECT 
                                    academic_student.student_nis,
                                    academic_student.student_nisn,
                                    academic_student.student_name
                                  FROM
                                    academic_extracurricular_participant
                                    INNER JOIN academic_student ON (academic_extracurricular_participant.extracurricular_participant_name = academic_student.student_nis)
                                  WHERE
                                    academic_extracurricular_participant.extracurricular_participant_activity = :classgroupid
                                  ORDER BY 
                                    academic_student.student_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':classgroupid', $classgroupid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSocoreByScoreFilter($student, $teaching, $type) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_score_extracurricular.score_extracurricular_id,
                                    academic_score_extracurricular.score_extracurricular_student,
                                    academic_score_extracurricular.score_extracurricular,
                                    academic_score_extracurricular.score_extracurricular_type,
                                    academic_score_extracurricular.score_extracurricular_value,
                                    academic_score_extracurricular.score_extracurricular_entry,
                                    academic_score_extracurricular.score_extracurricular_entry_update
                                  FROM
                                    academic_score_extracurricular
                                  WHERE
                                    academic_score_extracurricular.score_extracurricular_student IN (' . $student . ') AND 
                                    academic_score_extracurricular.score_extracurricular = :teaching AND 
                                    academic_score_extracurricular.score_extracurricular_type = :type
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
                                    academic_score_extracurricular
                                  SET
                                    score_extracurricular_value = :score,
                                    score_extracurricular_entry_update = NOW()
                                  WHERE
                                    academic_score_extracurricular.score_extracurricular_id = :scoreid
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }

    public function saveScore($student_id, $score, $teaching_id, $type_id) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_score_extracurricular(
                                        score_extracurricular_id,
                                        score_extracurricular_student,
                                        score_extracurricular,
                                        score_extracurricular_type,
                                        score_extracurricular_value,
                                        score_extracurricular_entry,
                                        score_extracurricular_entry_update)
                                  VALUES(
                                    (SELECT IF (
                                        (SELECT COUNT(e.score_extracurricular_id) FROM academic_score_extracurricular AS e 
                                                WHERE e.score_extracurricular_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.score_extracurricular_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.score_extracurricular_id + 1 ) FROM academic_score_extracurricular AS e 
                                                WHERE e.score_extracurricular_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.score_extracurricular_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :student,
                                    :teaching,
                                    :type,
                                    :score,
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