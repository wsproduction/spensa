<?php

class RecapitulationModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectClassListByTeachingId($teachingid, $user_references) {

        $query = 'SELECT 
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
                    academic_mlc.mlc_value,
                    ( SELECT 
                        employees.employess_name
                      FROM
                        academic_teaching at
                        INNER JOIN employees ON (at.teaching_teacher = employees.employees_id)
                      WHERE
                        at.teaching_id = academic_teaching.teaching_id
                      LIMIT 1
                    ) AS teacher_name
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
                    academic_teaching.teaching_id = :teachingid';

        if (!is_null($user_references))
            $query .= ' AND academic_teaching.teaching_teacher = :user_references ';

        $sth = $this->db->prepare($query);


        $sth->bindValue(':teachingid', $teachingid);
        if (!is_null($user_references))
            $sth->bindValue(':user_references', $user_references);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
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

    public function selectStudentByClassGroupIdAndStudentId($classgroupid, $nis) {
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
                                    academic_classhistory.classhistory_classgroup = :classgroupid AND
                                    academic_student.student_nis IN (' . $nis . ')
                                ORDER BY academic_student.student_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':classgroupid', $classgroupid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectSocoreByScoreFilter($student, $teaching) {
        $sth = $this->db->prepare('
                                      SELECT 
                                        academic_score.score_id,
                                        academic_score.score_student,
                                        academic_score.score_value,
                                        academic_score.score_type
                                      FROM
                                        academic_score
                                      WHERE
                                        academic_score.score_student IN (' . $student . ') AND 
                                        academic_score.score_teaching = :teaching
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teaching', $teaching);
        $sth->execute();
        return $sth->fetchAll();
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

}