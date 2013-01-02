<?php

class TaskModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectTask($teacher_id, $subject_id, $grade_id, $period_id, $semester_id) {
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
                                  academic_task_description.task_description_subject = :subject_id AND 
                                  academic_task_description.task_description_teacher = :teacher_id AND 
                                  academic_task_description.task_description_period = :period_id AND 
                                  academic_task_description.task_description_semester = :semester_id AND 
                                  academic_task_description.task_description_garde = :grade_id
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

    public function saveTask($teacher_id) {

        $subject = $this->method->post('subject');
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $grade = $this->method->post('grade');
        $title = $this->method->post('title');
        $description = $this->method->post('description');
        $mlc = $this->method->post('mlc');

        $sth = $this->db->prepare('
                              INSERT INTO
                                academic_task_description(
                                task_description_id,
                                task_description_subject,
                                task_description_teacher,
                                task_description_period,
                                task_description_semester,
                                task_description_garde,
                                task_description_title,
                                task_description,
                                task_description_mlc,
                                task_description_entry,
                                task_description_entry_update)
                              VALUES(
                                ( SELECT IF (
                                    (SELECT COUNT(e.task_description_id) FROM academic_task_description AS e 
                                            WHERE e.task_description_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                            ORDER BY e.task_description_id DESC LIMIT 1
                                    ) > 0,
                                    (SELECT ( e.task_description_id + 1 ) FROM academic_task_description AS e 
                                            WHERE e.task_description_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                            ORDER BY e.task_description_id DESC LIMIT 1),
                                    (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                ),
                                :subject,
                                :teacher,
                                :period,
                                :semester,
                                :grade,
                                :title,
                                :description,
                                :mlc,
                                NOW(),
                                NOW())
                            ');
        
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':teacher', $teacher_id);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':semester', $semester);
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':title', $title);
        $sth->bindValue(':description', $description);
        $sth->bindValue(':mlc', $mlc);
        return $sth->execute();
    }

    public function updateTask($id, $teacher_id) {

        $title = $this->method->post('title');
        $description = $this->method->post('description');
        $mlc = $this->method->post('mlc');

        $sth = $this->db->prepare('
                              UPDATE
                                academic_task_description
                              SET
                                task_description_title = :title,
                                task_description = :description,
                                task_description_mlc = :mlc,
                                task_description_entry_update = NOW()
                              WHERE
                                academic_task_description.task_description_id = :id AND
                                academic_task_description.task_description_teacher = :teacher
                        ');
        $sth->bindValue(':title', $title);
        $sth->bindValue(':description', $description);
        $sth->bindValue(':mlc', $mlc);
        $sth->bindValue(':id', $id);
        $sth->bindValue(':teacher', $teacher_id);
        return $sth->execute();
    }

    public function deleteBaseCompetenceById($id, $teacher_id) {
        $sth = $this->db->prepare('
                                DELETE
                                FROM
                                  academic_task_description
                                WHERE
                                  academic_task_description.task_description_id = :id AND
                                  academic_task_description.task_description_teacher = :teacher
                        ');
        $sth->bindValue(':id', $id);
        $sth->bindValue(':teacher', $teacher_id);
        return $sth->execute();
    }

}