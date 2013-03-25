<?php

class GuardianModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectGuardianInformation($classgroup_id = 0, $teacher_id = 0) {
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
                                academic_classgroup.classgroup_entry_update,
                                academic_period.period_years_start,
                                academic_period.period_years_end,
                                academic_period.period_id,
                                academic_classroom.classroom_name,
                                academic_grade.grade_title,
                                academic_grade.grade_name,
                                academic_semester.semester_name,
                                (SELECT COUNT(ac.classhistory_id) AS FIELD_1 FROM academic_classhistory ac WHERE ac.classhistory_classgroup = academic_classgroup.classgroup_id) AS student_count
                              FROM
                                academic_classgroup
                                INNER JOIN academic_period ON (academic_classgroup.classgroup_period = academic_period.period_id)
                                INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                INNER JOIN academic_semester ON (academic_classgroup.classgroup_semester = academic_semester.semester_id)
                              WHERE
                                academic_classgroup.classgroup_id = :classgroup_id AND 
                                academic_classgroup.classgroup_guardian = :teacher_id
                        ");
        $sth->bindValue(':classgroup_id', $classgroup_id);
        $sth->bindValue(':teacher_id', $teacher_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSubjectByStudentId($student_id = 0, $grade = 0, $period = 0, $semester = 0) {
        $sth = $this->db->prepare("
                        SELECT 
                            academic_grade.grade_title,
                            academic_classroom.classroom_name,
                            academic_classgroup.classgroup_id,
                            academic_teaching.teaching_id,
                            academic_subject.subject_name,
                            academic_subject.subject_id,
                            employees.employees_id,
                            employees.employees_nip,
                            employees.employess_name,
                            academic_subject.subject_category,
                            (SELECT 
                                COUNT(academic_score.score_id) AS cnt
                              FROM
                                academic_score
                              WHERE
                                academic_score.score_teaching = academic_teaching.teaching_id AND 
                                academic_score.score_type = 1 AND 
                                academic_score.score_student IN (" . $student_id . ")
                            ) AS midscore_count,
                            (SELECT 
                                COUNT(academic_score.score_id) AS cnt
                              FROM
                                academic_score
                              WHERE
                                academic_score.score_teaching = academic_teaching.teaching_id AND 
                                academic_score.score_type = 2 AND 
                                academic_score.score_student IN (" . $student_id . ")
                            ) AS finalscore_count,
                            (SELECT 
                                COUNT(academic_classhistory.classhistory_id) AS cnt
                              FROM
                                academic_classhistory
                              WHERE
                                academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id AND 
                                academic_classhistory.classhistory_student IN (" . $student_id . ")
                              ) AS student_count
                          FROM
                            academic_classhistory
                            INNER JOIN academic_student ON (academic_classhistory.classhistory_student = academic_student.student_nis)
                            INNER JOIN academic_classgroup ON (academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id)
                            INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                            INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                            INNER JOIN academic_teaching ON (academic_classgroup.classgroup_id = academic_teaching.teaching_classgroup)
                            INNER JOIN academic_subject ON (academic_teaching.teaching_subject = academic_subject.subject_id)
                            INNER JOIN employees ON (academic_teaching.teaching_teacher = employees.employees_id)
                          WHERE
                            academic_student.student_nis IN (" . $student_id . ") AND
                            academic_classgroup.classgroup_grade  = :grade AND 
                            academic_classgroup.classgroup_period = :period AND 
                            academic_classgroup.classgroup_semester = :semester
                          GROUP BY
                            subject_id,
                            employees.employees_id,
                            classgroup_id
                          ");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSubjectByClassGroup($classgroup_id = 0) {
        $sth = $this->db->prepare("
                        SELECT *
                          FROM
                            academic_classhistory
                            INNER JOIN academic_student ON (academic_classhistory.classhistory_student = academic_student.student_nis)
                          WHERE
                            academic_classhistory.classhistory_classgroup = :classgroup_id
                          ");

        $sth->bindValue(':classgroup_id', $classgroup_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    
    public function selectExtracuriculerByStudentId($student_id = 0, $grade = 0, $period = 0, $semester = 0) {
        $sth = $this->db->prepare("
                        SELECT 
                            academic_extracurricular.extracurricular_name,
                            employees.employess_name,
                            academic_extracurricular_coach_history.extracurricular_coach_history_id,
                            (SELECT 
                                COUNT(academic_score_extracurricular.score_extracurricular_id) AS cnt 
                             FROM 
                                academic_score_extracurricular 
                             WHERE 
                                academic_score_extracurricular.score_extracurricular_student IN (" . $student_id . ") AND 
                                academic_score_extracurricular.score_extracurricular_type = 1 AND 
                                academic_score_extracurricular.score_extracurricular = academic_extracurricular_coach_history.extracurricular_coach_history_id
                            ) AS midscore_count,
                            (SELECT 
                                COUNT(academic_score_extracurricular.score_extracurricular_id) AS cnt 
                             FROM 
                                academic_score_extracurricular 
                             WHERE 
                                academic_score_extracurricular.score_extracurricular_student IN (" . $student_id . ") AND 
                                academic_score_extracurricular.score_extracurricular_type = 2 AND 
                                academic_score_extracurricular.score_extracurricular = academic_extracurricular_coach_history.extracurricular_coach_history_id
                            ) AS finalscore_count,
                            (SELECT 
                                COUNT(academic_extracurricular_participant.extracurricular_participant_id) AS cnt
                              FROM
                                academic_extracurricular_participant
                              WHERE
                                academic_extracurricular_participant.extracurricular_participant_name IN (" . $student_id . ")  AND 
                                academic_extracurricular_participant.extracurricular_participant_activity = academic_extracurricular_coach_history.extracurricular_coach_history_id) AS student_count
                          FROM
                            academic_extracurricular_participant
                            INNER JOIN academic_extracurricular_coach_history ON (academic_extracurricular_participant.extracurricular_participant_activity = academic_extracurricular_coach_history.extracurricular_coach_history_id)
                            INNER JOIN academic_extracurricular ON (academic_extracurricular_coach_history.extracurricular_coach_history_field = academic_extracurricular.extracurricular_id)
                            INNER JOIN employees ON (academic_extracurricular_coach_history.extracurricular_coach_history_name = employees.employees_id)
                          WHERE
                            academic_extracurricular_participant.extracurricular_participant_name IN (" . $student_id . ") AND
                            academic_extracurricular_coach_history.extracurricular_coach_history_period = :period AND 
                            academic_extracurricular_coach_history.extracurricular_coach_history_semester = :semester
                          GROUP BY
                            academic_extracurricular.extracurricular_name,
                            employees.employess_name
                          ");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->execute();
        return $sth->fetchAll();
    }

}