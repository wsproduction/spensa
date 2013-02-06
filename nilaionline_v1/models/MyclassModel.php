<?php

class MyclassModel extends Model {

    public function __construct() {
        parent::__construct();
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

}