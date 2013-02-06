<?php

class RecapitulationModel extends Model {

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

    public function selectGuardianInformation($period = 0, $semester = 0, $teacherid = 0) {
        $sth = $this->db->prepare("
                                SELECT 
                                    academic_classroom.classroom_name,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    academic_classgroup.classgroup_id
                                  FROM
                                    academic_classgroup
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                  WHERE
                                    academic_classgroup.classgroup_period = :period_id AND 
                                    academic_classgroup.classgroup_semester = :semester_id AND 
                                    academic_classgroup.classgroup_guardian = :teacher_id
                                ");

        $sth->bindValue(':period_id', $period);
        $sth->bindValue(':semester_id', $semester);
        $sth->bindValue(':teacher_id', $teacherid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTeaching($teacherid, $periodid, $semesterid) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_classgroup.classgroup_id,
                                    academic_subject.subject_id,
                                    academic_subject.subject_name,
                                    academic_grade.grade_id,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    academic_classroom.classroom_id,
                                    academic_classroom.classroom_name,
                                    academic_subject_category.subject_category_title,
                                    SUM(academic_teaching.teaching_total_time) AS total_time,
                                    ( SELECT 
                                        COUNT(at.teaching_id) AS FIELD_1 
                                      FROM 
                                        academic_teaching AS at 
                                        INNER JOIN academic_classgroup ac ON (at.teaching_classgroup = ac.classgroup_id) 
                                      WHERE 
                                        at.teaching_teacher = academic_teaching.teaching_teacher AND 
                                        at.teaching_subject = academic_subject.subject_id AND 
                                        at.teaching_period = academic_teaching.teaching_period AND 
                                        at.teaching_semester = academic_teaching.teaching_semester AND 
                                        ac.classgroup_grade = academic_grade.grade_id
                                     ) AS total_class,
                                    ( SELECT 
                                        COUNT(academic_task_description.task_description_id) AS FIELD_1 
                                      FROM 
                                        academic_task_description 
                                      WHERE 
                                        academic_task_description.task_description_subject = academic_teaching.teaching_subject AND 
                                        academic_task_description.task_description_teacher = academic_teaching.teaching_teacher AND 
                                        academic_task_description.task_description_period = academic_teaching.teaching_period AND 
                                        academic_task_description.task_description_semester = academic_teaching.teaching_semester AND 
                                        academic_task_description.task_description_garde = academic_grade.grade_id
                                     ) AS total_task,
                                    ( SELECT 
                                        COUNT(academic_base_competence.base_competence_id) AS FIELD_1 
                                      FROM 
                                        academic_base_competence 
                                      WHERE 
                                        academic_base_competence.base_competence_subject = academic_teaching.teaching_subject AND 
                                        academic_base_competence.base_competence_period = academic_teaching.teaching_period AND 
                                        academic_base_competence.base_competence_semester = academic_teaching.teaching_semester AND 
                                        academic_base_competence.base_competence_teacher = academic_teaching.teaching_teacher AND 
                                        academic_base_competence.base_competence_grade = academic_grade.grade_id
                                    ) AS count_basecompete
                                  FROM
                                    academic_subject
                                    INNER JOIN academic_teaching ON (academic_subject.subject_id = academic_teaching.teaching_subject)
                                    INNER JOIN employees ON (academic_teaching.teaching_teacher = employees.employees_id)
                                    INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_subject_category ON (academic_subject.subject_category = academic_subject_category.subject_category_id)
                                  WHERE
                                    academic_teaching.teaching_teacher = :teacherid AND 
                                    academic_teaching.teaching_period = :periodid AND 
                                    academic_teaching.teaching_semester = :semesterid
                                  GROUP BY
                                    academic_subject.subject_name,
                                    academic_grade.grade_id
                          ');

        $sth->bindValue(':teacherid', $teacherid);
        $sth->bindValue(':periodid', $periodid);
        $sth->bindValue(':semesterid', $semesterid);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTeachingEkskul($teacher_id, $periodid) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_id,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_name,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_period,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_totaltime,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_entry,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_entry_update,
                                    academic_extracurricular.extracurricular_name,
                                    academic_extracurricular.extracurricular_id
                                  FROM
                                    academic_extracurricular_coach_history
                                    INNER JOIN academic_extracurricular ON (academic_extracurricular_coach_history.extracurricular_coach_history_field = academic_extracurricular.extracurricular_id)
                                  WHERE
                                    academic_extracurricular_coach_history.extracurricular_coach_history_period = :periodid AND 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_name = :teacherid
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

    public function selectClassEkskulListByTeachingId($teachingid, $user_references) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_id,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_name,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_period,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_totaltime,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_entry,
                                    academic_extracurricular_coach_history.extracurricular_coach_history_entry_update,
                                    academic_extracurricular.extracurricular_name,
                                    academic_extracurricular.extracurricular_id,
                                    academic_period.period_id,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end
                                  FROM
                                    academic_extracurricular_coach_history
                                    INNER JOIN academic_extracurricular ON (academic_extracurricular_coach_history.extracurricular_coach_history_field = academic_extracurricular.extracurricular_id)
                                    INNER JOIN academic_period ON (academic_extracurricular_coach_history.extracurricular_coach_history_period = academic_period.period_id)
                                  WHERE
                                    academic_extracurricular_coach_history.extracurricular_coach_history_id = :teachingid AND
                                    academic_extracurricular_coach_history.extracurricular_coach_history_name = :user_references
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

    public function selectBaseCompetence($period, $semester, $teacher, $subject, $grade) {
        $sth = $this->db->prepare('
                                SELECT 
                                    academic_base_competence.base_competence_id,
                                    academic_base_competence.base_competence_title,
                                    academic_base_competence.base_competence_period,
                                    academic_base_competence.base_competence_semester,
                                    academic_base_competence.base_competence_teacher,
                                    academic_base_competence.base_competence_subject,
                                    academic_base_competence.base_competence_grade,
                                    academic_base_competence.base_competence_mlc,
                                    academic_base_competence.base_competence_entry,
                                    academic_base_competence.base_competence_entry_update
                                  FROM
                                    academic_base_competence
                                  WHERE
                                    academic_base_competence.base_competence_period = :period AND 
                                    academic_base_competence.base_competence_semester = :semester AND 
                                    academic_base_competence.base_competence_teacher = :teacher AND 
                                    academic_base_competence.base_competence_subject = :subject AND 
                                    academic_base_competence.base_competence_grade = :grade
                          ');

        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':teacher', $teacher);
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':grade', $grade);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTaskDescription($subject, $teacher, $period, $semester, $grade) {
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
                                    academic_task_description.task_description_mlc,
                                    academic_task_description.task_description_entry,
                                    academic_task_description.task_description_entry_update
                                  FROM
                                    academic_task_description
                                  WHERE
                                    academic_task_description.task_description_subject = :subject AND 
                                    academic_task_description.task_description_teacher = :teacher AND 
                                    academic_task_description.task_description_period = :period AND 
                                    academic_task_description.task_description_semester = :semester AND 
                                    academic_task_description.task_description_garde = :grade
                          ');

        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':teacher', $teacher);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':grade', $grade);

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

    public function selectClassGroupByPeriodId($period_id) {
        $sth = $this->db->prepare('
                                  SELECT 
                                    academic_grade.grade_title,
                                    academic_classroom.classroom_name,
                                    academic_classgroup.classgroup_id,
                                    academic_grade.grade_name
                                  FROM
                                    academic_classgroup
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                  WHERE
                                    academic_classgroup.classgroup_period = :period_id
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period_id', $period_id);
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

    public function selectMyClass($teacher_id, $subject_id, $grade_id, $period_id, $semester_id) {
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
                                academic_classroom.classroom_name,
                                academic_grade.grade_title,
                                academic_grade.grade_name,
                                (SELECT COUNT(ch.classhistory_id) AS FIELD_1 FROM academic_classhistory ch WHERE ch.classhistory_classgroup = academic_teaching.teaching_classgroup) AS student_count,
                                employees.employees_id,
                                employees.employees_nip,
                                employees.employess_name
                              FROM
                                academic_teaching
                                INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                                INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                              WHERE
                                academic_teaching.teaching_teacher = :teacher_id AND 
                                academic_teaching.teaching_subject = :subject_id AND 
                                academic_classgroup.classgroup_grade = :grade_id AND 
                                academic_teaching.teaching_period = :period_id AND 
                                academic_teaching.teaching_semester = :semester_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teacher_id', $teacher_id);
        $sth->bindValue(':subject_id', $subject_id);
        $sth->bindValue(':grade_id', $grade_id);
        $sth->bindValue(':period_id', $period_id);
        $sth->bindValue(':semester_id', $semester_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAcademicMlc($subject_id, $period_id, $semester_id, $grade_id) {
        $sth = $this->db->prepare('
                              SELECT 
                                academic_mlc.mlc_id,
                                academic_mlc.mlc_subject,
                                academic_mlc.mlc_period,
                                academic_mlc.mlc_grade,
                                academic_mlc.mlc_value,
                                academic_mlc.mlc_entry,
                                academic_mlc.mlc_entry_update
                              FROM
                                academic_mlc
                              WHERE
                                academic_mlc.mlc_subject = :subject_id AND 
                                academic_mlc.mlc_period = :period_id AND 
                                academic_mlc.mlc_semester = :semester_id AND 
                                academic_mlc.mlc_grade = :grade_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':subject_id', $subject_id);
        $sth->bindValue(':period_id', $period_id);
        $sth->bindValue(':semester_id', $semester_id);
        $sth->bindValue(':grade_id', $grade_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectRecapList() {
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

    public function selectRecapDailyScore() {
        $sth = $this->db->prepare('
                              SELECT 
                                academic_base_competence.base_competence_id,
                                academic_base_competence.base_competence_title,
                                academic_base_competence.base_competence_period,
                                academic_base_competence.base_competence_semester,
                                academic_base_competence.base_competence_teacher,
                                academic_base_competence.base_competence_subject,
                                academic_base_competence.base_competence_grade,
                                academic_base_competence.base_competence_mlc,
                                academic_base_competence.base_competence_entry,
                                academic_base_competence.base_competence_entry_update
                              FROM
                                academic_base_competence
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}