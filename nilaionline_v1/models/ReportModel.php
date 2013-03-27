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

    public function selectSubjectScore($student, $period, $semester, $grade, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    a.subject_id,
                                    a.subject_name,
                                    a.subject_order,
                                    a.subject_category,
                                    (SELECT 
                                        b.mlc_value 
                                     FROM 
                                        academic_mlc b 
                                     WHERE 
                                        b.mlc_subject = a.subject_id AND 
                                        b.mlc_period = :period AND 
                                        b.mlc_semester = :semester AND 
                                        b.mlc_grade = :grade
                                    LIMIT 1) AS mlc_value,
                                    (SELECT 
                                        AVG(c.score_value) A
                                     FROM
                                        academic_score c
                                        INNER JOIN academic_teaching ON (c.score_teaching = academic_teaching.teaching_id)
                                        INNER JOIN employees ON (academic_teaching.teaching_teacher = employees.employees_id)
                                        INNER JOIN academic_subject ON (academic_teaching.teaching_subject = academic_subject.subject_id)
                                        INNER JOIN academic_classgroup ON (academic_teaching.teaching_classgroup = academic_classgroup.classgroup_id)
                                      WHERE
                                        c.score_student = :student AND 
                                        academic_teaching.teaching_subject = a.subject_id AND
                                        academic_teaching.teaching_period = :period AND 
                                        academic_teaching.teaching_semester = :semester AND 
                                        academic_classgroup.classgroup_grade = :grade AND
                                        c.score_type = :type
                                    ) AS score_value
                                  FROM
                                    academic_teaching d
                                    INNER JOIN academic_subject a ON (d.teaching_subject = a.subject_id)
                                    INNER JOIN academic_classgroup ON (d.teaching_classgroup = academic_classgroup.classgroup_id)
                                    INNER JOIN academic_classhistory ON (academic_classgroup.classgroup_id = academic_classhistory.classhistory_classgroup)
                                  WHERE
                                    academic_classhistory.classhistory_student = :student AND
                                    academic_classgroup.classgroup_period = :period AND 
                                    academic_classgroup.classgroup_semester = :semester  AND 
                                    academic_classgroup.classgroup_grade = :grade
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

    public function selectExtracurricular($student, $period, $semester, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                        academic_extracurricular.extracurricular_name,
                                        academic_extracurricular_participant.extracurricular_participant_name,
                                        (   SELECT 
                                                academic_score_extracurricular.score_extracurricular_value
                                            FROM 
                                                 academic_score_extracurricular
                                            WHERE
                                                academic_score_extracurricular.score_extracurricular_student = academic_extracurricular_participant.extracurricular_participant_name AND
                                                academic_score_extracurricular.score_extracurricular = academic_extracurricular_coach_history.extracurricular_coach_history_id AND
                                                academic_score_extracurricular.score_extracurricular_type = :type
                                            LIMIT 1
                                        ) AS score_value
                                  FROM
                                    academic_extracurricular_coach_history
                                    INNER JOIN academic_extracurricular ON (academic_extracurricular_coach_history.extracurricular_coach_history_field = academic_extracurricular.extracurricular_id)
                                    INNER JOIN academic_extracurricular_participant ON (academic_extracurricular_coach_history.extracurricular_coach_history_id = academic_extracurricular_participant.extracurricular_participant_activity)
                                  WHERE
                                    academic_extracurricular_participant.extracurricular_participant_name = :student AND 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_period = :period AND 
                                    academic_extracurricular_coach_history.extracurricular_coach_history_semester = :semester
                                  LIMIT 3
                                 ");

        $sth->bindValue(':student', $student);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':type', $type);
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

    public function selectGuidanceScore($student, $period, $semester, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_student.student_nis,
                                    (SELECT 
                                    academic_score_guidance.score_guidance_value
                                  FROM
                                    academic_score_guidance
                                    INNER JOIN academic_guidance ON (academic_score_guidance.score_guidance_guidance = academic_guidance.guidance_id)
                                  WHERE
                                    academic_score_guidance.score_guidance_student = academic_student.student_nis AND 
                                    academic_guidance.guidance_period = :period AND 
                                    academic_guidance.guidance_semester = :semester AND 
                                    academic_score_guidance.score_guidance_desc = 1 AND 
                                    academic_score_guidance.score_guidance_type = :type
                                  LIMIT 1) AS attitude_score,
                                  (SELECT 
                                    academic_score_guidance.score_guidance_value
                                  FROM
                                    academic_score_guidance
                                    INNER JOIN academic_guidance ON (academic_score_guidance.score_guidance_guidance = academic_guidance.guidance_id)
                                  WHERE
                                    academic_score_guidance.score_guidance_student = academic_student.student_nis AND 
                                    academic_guidance.guidance_period = :period AND 
                                    academic_guidance.guidance_semester =  :semester AND 
                                    academic_score_guidance.score_guidance_desc = 2 AND 
                                    academic_score_guidance.score_guidance_type = :type
                                  LIMIT 1) AS personality_score
                                  FROM
                                    academic_student
                                  WHERE
                                    academic_student.student_nis = :student
                                 ");

        $sth->bindValue(':student', $student);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':type', $type);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAttendance($student, $period, $semester, $type) {
        $sth = $this->db->prepare("
                                  SELECT 
                                    academic_attendance.attendance_student,
                                    academic_attendance.attendance_sick,
                                    academic_attendance.attendance_leave,
                                    academic_attendance.attendance_alpha
                                  FROM
                                    academic_attendance
                                    INNER JOIN academic_guidance ON (academic_attendance.attendance_guidance = academic_guidance.guidance_id)
                                  WHERE
                                    academic_attendance.attendance_student = :student AND 
                                    academic_guidance.guidance_period = :period AND
                                    academic_guidance.guidance_semester = :semester AND 
                                    academic_attendance.attendance_score_type = :type
                                  LIMIT 1
                                 ");

        $sth->bindValue(':student', $student);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':type', $type);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}