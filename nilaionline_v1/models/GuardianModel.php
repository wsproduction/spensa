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

    public function selectSubjectByStudentId($student_id = 0) {
        $sth = $this->db->prepare("
                        SELECT 
                            academic_teaching.teaching_id,
                            employees.employees_nip,
                            employees.employess_name,
                            academic_subject.subject_name,
                            academic_subject.subject_category,
                            (SELECT 
                                COUNT(academic_score.score_id) AS cnt
                              FROM
                                academic_score
                              WHERE
                                academic_score.score_teaching = academic_teaching.teaching_id AND 
                                academic_score.score_type = 1 AND 
                                academic_score.score_student IN (" . $student_id . ")
                            ) AS midscore_count
                          FROM
                            academic_classhistory
                            INNER JOIN academic_student ON (academic_classhistory.classhistory_student = academic_student.student_nis)
                            INNER JOIN academic_classgroup ON (academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id)
                            INNER JOIN academic_teaching ON (academic_classgroup.classgroup_id = academic_teaching.teaching_classgroup)
                            INNER JOIN employees ON (academic_teaching.teaching_teacher = employees.employees_id)
                            INNER JOIN academic_subject ON (academic_teaching.teaching_subject = academic_subject.subject_id)
                          WHERE
                            academic_student.student_nis IN (" . $student_id . ")
                          GROUP BY
                            academic_teaching.teaching_id
                          ORDER BY
                            academic_subject.subject_order
                          ");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
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

}