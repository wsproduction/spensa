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
                          ');
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

    public function selectExtracurricular($teacher_id, $periodid, $semesterid) {
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
                                    academic_extracurricular_coach_history.extracurricular_coach_history_semester = :semesterid AND 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_name = :teacherid
                          ');

        $sth->bindValue(':teacherid', $teacher_id);
        $sth->bindValue(':semesterid', $semesterid);
        $sth->bindValue(':periodid', $periodid);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}