<?php

class BasecompetenceModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectBaseCompetence($teacher_id, $subject_id, $grade_id, $period_id, $semester_id) {
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
                                academic_base_competence.base_competence_teacher = :teacher_id AND 
                                academic_base_competence.base_competence_grade = :grade_id AND 
                                academic_base_competence.base_competence_period = :period_id AND 
                                academic_base_competence.base_competence_semester = :semester_id AND 
                                academic_base_competence.base_competence_subject = :subject_id
                        ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':teacher_id', $teacher_id);
        $sth->bindValue(':grade_id', $grade_id);
        $sth->bindValue(':period_id', $period_id);
        $sth->bindValue(':semester_id', $semester_id);
        $sth->bindValue(':subject_id', $subject_id);

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

    public function saveBaseCompetence($teacher_id) {

        $subject = $this->method->post('subject');
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $grade = $this->method->post('grade');
        $title = $this->method->post('title');
        $mlc = $this->method->post('mlc');

        $sth = $this->db->prepare('
                              INSERT INTO
                                academic_base_competence(
                                base_competence_id,
                                base_competence_title,
                                base_competence_period,
                                base_competence_semester,
                                base_competence_teacher,
                                base_competence_subject,
                                base_competence_grade,
                                base_competence_mlc,
                                base_competence_entry,
                                base_competence_entry_update)
                              VALUES(
                                ( SELECT IF (
                                    (SELECT COUNT(e.base_competence_id) FROM academic_base_competence AS e 
                                            WHERE e.base_competence_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                            ORDER BY e.base_competence_id DESC LIMIT 1
                                    ) > 0,
                                    (SELECT ( e.base_competence_id + 1 ) FROM academic_base_competence AS e 
                                            WHERE e.base_competence_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                            ORDER BY e.base_competence_id DESC LIMIT 1),
                                    (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                ),
                                :title,
                                :period,
                                :semester,
                                :teacher,
                                :subject,
                                :grade,
                                :mlc,
                                NOW(),
                                NOW())
                        ');
        $sth->bindValue(':title', $title);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':teacher', $teacher_id);
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':mlc', $mlc);
        return $sth->execute();
    }

    public function updateBaseCompetence($id, $teacher_id) {

        $title = $this->method->post('title');
        $mlc = $this->method->post('mlc');

        $sth = $this->db->prepare('
                              UPDATE
                                academic_base_competence
                              SET
                                base_competence_title = :title,
                                base_competence_mlc = :mlc,
                                base_competence_entry_update = NOW()
                              WHERE
                                academic_base_competence.base_competence_id = :id AND
                                academic_base_competence.base_competence_teacher = :teacher
                        ');
        $sth->bindValue(':id', $id);
        $sth->bindValue(':title', $title);
        $sth->bindValue(':teacher', $teacher_id);
        $sth->bindValue(':mlc', $mlc);
        return $sth->execute();
    }

    public function deleteBaseCompetenceById($id) {
        $sth = $this->db->prepare('
                                DELETE
                                FROM
                                  academic_base_competence
                                WHERE
                                  academic_base_competence.base_competence_id = :id
                        ');
        $sth->bindValue(':id', $id);
        return $sth->execute();
    }

}