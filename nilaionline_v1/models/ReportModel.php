<?php

class ReportModel extends Model {

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

    public function selectSubjectByClassGroup($classgroup_id = 0) {
        $sth = $this->db->prepare("
                        SELECT 
                            academic_teaching.teaching_id,
                            academic_subject.subject_name,
                            academic_grade.grade_title,
                            academic_grade.grade_name,
                            academic_classroom.classroom_name,
                            employees.employees_nip,
                            employees.employess_name
                          FROM
                            academic_subject
                            INNER JOIN academic_teaching ON (academic_subject.subject_id = academic_teaching.teaching_subject)
                            INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                            INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                            INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                            INNER JOIN employees ON (academic_teaching.teaching_teacher = employees.employees_id)
                          WHERE
                            academic_teaching.teaching_classgroup = :classgroup_id
                          ORDER BY
                            academic_subject.subject_name
                            ");
        $sth->bindValue(':classgroup_id', $classgroup_id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectStudentByClassGroupId($classgroup_id = 0) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_student.student_nis,
                                    academic_student.student_name,
                                    academic_student.student_nisn
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

    public function selectStudentById($classgroup_id = 0, $nis = 0) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_student.student_nis,
                                    academic_student.student_name,
                                    academic_student.student_nisn,
                                    academic_classroom.classroom_name,
                                    academic_grade.grade_title,
                                    academic_grade.grade_name,
                                    academic_semester.semester_name,
                                    academic_period.period_years_start,
                                    academic_period.period_years_end,
                                    academic_semester.semester_id,
                                    academic_grade.grade_id,
                                    academic_period.period_id,
                                    employees.employees_nip,
                                    employees.employess_name
                                  FROM
                                    academic_classhistory
                                    INNER JOIN academic_student ON (academic_classhistory.classhistory_student = academic_student.student_nis)
                                    INNER JOIN academic_classgroup ON (academic_classhistory.classhistory_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_classroom ON (academic_classgroup.classgroup_name = academic_classroom.classroom_id)
                                    INNER JOIN academic_grade ON (academic_classgroup.classgroup_grade = academic_grade.grade_id)
                                    INNER JOIN academic_semester ON (academic_classgroup.classgroup_semester = academic_semester.semester_id)
                                    INNER JOIN academic_period ON (academic_classgroup.classgroup_period = academic_period.period_id)
                                    INNER JOIN employees ON (academic_classgroup.classgroup_guardian = employees.employees_id)
                                  WHERE
                                    academic_classhistory.classhistory_classgroup = :classgroup_id AND 
                                    academic_student.student_nis = :nis
                                 ");
        $sth->bindValue(':classgroup_id', $classgroup_id);
        $sth->bindValue(':nis', $nis);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectMustSubject($student, $period, $semester, $grade, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    a.subject_id,
                                    a.subject_name,
                                    a.subject_order,
                                    (SELECT 
                                        b.mlc_value 
                                     FROM 
                                        academic_mlc b 
                                     WHERE 
                                        b.mlc_subject = a.subject_id AND 
                                        b.mlc_period = :period AND 
                                        b.mlc_semester = :semester 
                                        AND b.mlc_grade = :grade 
                                    LIMIT 1) AS mlc_value,
                                    (SELECT 
                                        AVG(c.score_value) 
                                     FROM 
                                        academic_score c 
                                     WHERE 
                                        c.score_student = :student AND 
                                        c.score_subject = a.subject_id AND 
                                        c.score_period = :period AND 
                                        c.score_semester = :semester AND 
                                        c.score_type = :type
                                    ) AS score_value
                                  FROM
                                    academic_teaching d
                                    INNER JOIN academic_subject a ON (d.teaching_subject = a.subject_id)
                                  WHERE
                                    a.subject_category = 1
                                  GROUP BY
                                    a.subject_id
                                  ORDER BY
                                    a.subject_order
                                 ");
        $sth->bindValue(':student', $student);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':type', $type);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectChoiceSubject($student, $period, $semester, $grade, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                        a.subject_id,
                                        a.subject_name,
                                        a.subject_order
                                      FROM
                                        academic_teaching d
                                        INNER JOIN academic_subject a ON (d.teaching_subject = a.subject_id)
                                      WHERE
                                        a.subject_category = 2
                                      GROUP BY
                                        a.subject_id
                                 ");

        $sth->bindValue(':student', $student);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':type', $type);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectMulokSubject() {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_subject.subject_id,
                                    academic_subject.subject_name,
                                    academic_subject.subject_order,
                                    academic_subject.subject_entry,
                                    academic_subject.subject_entry_update
                                  FROM
                                    academic_subject
                                  WHERE
                                    academic_subject.subject_category = 3
                                  ORDER BY
                                    academic_subject.subject_order
                                 ");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectRepotType() {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_score_type.score_type_id,
                                    academic_score_type.score_type_description
                                  FROM
                                    academic_score_type
                                 ");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectReportPublishing($period, $semester, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_report_publishing.report_publishing_id,
                                    academic_report_publishing.report_publishing_date
                                  FROM
                                    academic_report_publishing
                                  WHERE
                                    academic_report_publishing.report_publishing_period = :period AND 
                                    academic_report_publishing.report_publishing_semester = :semester AND 
                                    academic_report_publishing.report_publishing_type = :type 
                                 ");

        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':type', $type);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}