<?php

class TeachingModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectTeaching($teacher_id, $periodid) {
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
                                WHERE
                                    academic_teaching.teaching_teacher = :teacherid AND
                                    academic_classgroup.classgroup_period = :periodid
                          ');
        
        $sth->bindValue(':teacherid', $teacher_id);
        $sth->bindValue(':periodid', $periodid);
        
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

    public function selectClassListByTeachingId($teachingid, $user_references) {
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

    public function selectBaseCompetence($period, $semester) {
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
                                WHERE
                                    academic_base_competence.base_competence_period = :period AND
                                    academic_base_competence.base_competence_semester = :semester
                          ');
        
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTaskDescription($period, $semester) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_task_description.task_description_id,
                                    academic_task_description.task_description_subject,
                                    academic_task_description.task_description_teacher,
                                    academic_task_description.task_description_period,
                                    academic_task_description.task_description_semester,
                                    academic_task_description.task_description_garde,
                                    academic_task_description.task_description_title,
                                    academic_task_description.task_description,
                                    academic_task_description.task_description_entry,
                                    academic_task_description.task_description_entry_update
                                  FROM
                                    academic_task_description
                                  WHERE
                                    academic_task_description.task_description_period = :period AND
                                    academic_task_description.task_description_semester = :semester
                          ');
        
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTaskDescriptionById($task_description_id) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_task_description.task_description_id,
                                    academic_task_description.task_description_subject,
                                    academic_task_description.task_description_teacher,
                                    academic_task_description.task_description_period,
                                    academic_task_description.task_description_semester,
                                    academic_task_description.task_description_garde,
                                    academic_task_description.task_description_title,
                                    academic_task_description.task_description,
                                    academic_task_description.task_description_entry,
                                    academic_task_description.task_description_entry_update
                                  FROM
                                    academic_task_description
                                  WHERE
                                    academic_task_description.task_description_id = :task_description_id
                          ');
        
        $sth->bindValue(':task_description_id', $task_description_id);
        
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

    public function selectTaskSocoreByScoreFilter($student_id, $periode, $semester, $task_description) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_score_task.score_task_id,
                                    academic_score_task.score_task_value,
                                    academic_score_task.score_task_student,
                                    academic_score_task.score_task_description,
                                    academic_score_task.score_task_entry,
                                    academic_score_task.score_task_entry_update
                                  FROM
                                    academic_score_task
                                  WHERE
                                    academic_score_task.score_task_student IN (' . $student_id . ') AND 
                                    academic_score_task.score_task_description = :task_description
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':task_description', $task_description);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAttitudeSocoreByScoreFilter($student_id, $subject, $period, $semester) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_score_attitude.score_attitude_id,
                                    academic_score_attitude.score_attitude_value,
                                    academic_score_attitude.score_attitude_student,
                                    academic_score_attitude.score_attitude_period,
                                    academic_score_attitude.score_attitude_semester,
                                    academic_score_attitude.score_attitude_subject,
                                    academic_score_attitude.score_attitude_entry,
                                    academic_score_attitude.score_attitude_entry_update
                                  FROM
                                    academic_score_attitude
                                  WHERE
                                    academic_score_attitude.score_attitude_student IN (' . $student_id . ') AND 
                                    academic_score_attitude.score_attitude_period = :period AND 
                                    academic_score_attitude.score_attitude_semester = :semester AND 
                                    academic_score_attitude.score_attitude_subject = :subject
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':subject', $subject);
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
                                    score_daily_entry_update = NOW()
                                WHERE
                                    academic_score_daily.score_daily_id = :scoreid ;
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }
    
    public function saveTaskScore($student_id, $score, $task_description) {
        $sth = $this->db->prepare('
                                  INSERT INTO
                                    academic_score_task(
                                    score_task_id,
                                    score_task_value,
                                    score_task_student,
                                    score_task_description,
                                    score_task_entry,
                                    score_task_entry_update)
                                  VALUES(
                                    ( SELECT IF (
                                        (SELECT COUNT(e.score_task_id) FROM academic_score_task AS e 
                                                WHERE e.score_task_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_task_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.score_task_id + 1 ) FROM academic_score_task AS e 
                                                WHERE e.score_task_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_task_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"0001")))
                                    ),
                                    :score,
                                    :student_id,
                                    :task_description,
                                    NOW(),
                                    NOW());
                          ');
        $sth->bindValue(':student_id', $student_id);
        $sth->bindValue(':score', $score);
        $sth->bindValue(':task_description', $task_description);
        return $sth->execute();
    }
    
    public function updateTaskScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_score_task
                                SET
                                    score_task_value = :score,
                                    score_task_entry_update = NOW()
                                WHERE
                                    academic_score_task.score_task_id = :scoreid ;
                          ');
        $sth->bindValue(':scoreid', $scoreid);
        $sth->bindValue(':score', $score);
        return $sth->execute();
    }
    
    public function saveAttitudeScore($student_id, $score, $subject_id, $peiod_id, $semester_id) {
        $sth = $this->db->prepare('
                                INSERT INTO
                                    academic_score_attitude(
                                    score_attitude_id,
                                    score_attitude_value,
                                    score_attitude_student,
                                    score_attitude_period,
                                    score_attitude_semester,
                                    score_attitude_subject,
                                    score_attitude_entry,
                                    score_attitude_entry_update)
                                  VALUES(
                                    ( SELECT IF (
                                        (SELECT COUNT(e.score_attitude_id) FROM academic_score_attitude AS e 
                                                WHERE e.score_attitude_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_attitude_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.score_attitude_id + 1 ) FROM academic_score_attitude AS e 
                                                WHERE e.score_attitude_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                                ORDER BY e.score_attitude_id DESC LIMIT 1),
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
    
    public function updateAttitudeScore($scoreid, $score) {
        $sth = $this->db->prepare('
                                UPDATE
                                    academic_score_attitude
                                SET
                                    score_attitude_value = :score,
                                    score_attitude_entry_update = NOW()
                                WHERE
                                    academic_score_attitude.score_attitude_id = :scoreid ;
                          ');
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

}