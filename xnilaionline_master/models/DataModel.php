<?php

class DataModel extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function selectSubject() {
        $sth = $this->db->prepare('SELECT 
                                        hots_subject.subject_id,
                                        hots_subject.subject_title,
                                        hots_subject.subject_description
                                    FROM
                                        hots_subject');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectQuestionById($id = 0) {
        $sth = $this->db->prepare('SELECT 
                                        hots_question.question_id,
                                        hots_question.question_subject,
                                        hots_question.question_title,
                                        hots_question.question_description,
                                        hots_question.question_start_date,
                                        hots_question.question_end_date,
                                        hots_question.question_status,
                                        hots_question.question_entry,
                                        hots_subject.subject_id,
                                        hots_subject.subject_title,
                                        hots_subject.subject_description
                                    FROM
                                        hots_question
                                        INNER JOIN hots_subject ON (hots_question.question_subject = hots_subject.subject_id)
                                    WHERE
                                        hots_question.question_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectQuestion($page = 1) {

        $subject = $this->method->post('hots_subject', false);
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            hots_question.question_status,
            hots_question.question_id,
            hots_question.question_subject,
            hots_question.question_title,
            hots_question.question_description,
            hots_question.question_start_date,
            hots_question.question_end_date,
            hots_question.question_entry";

        if ($subject) {
            $prepare = 'SELECT ' . $listSelect . ' FROM hots_question WHERE hots_question.question_subject = "' . $subject . '"';
            if ($query)
                $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        } else {
            $prepare = 'SELECT ' . $listSelect . ' FROM hots_question';
            if ($query)
                $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';
        }

        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countQuestion() {

        $subject = $this->method->post('hots_subject', false);
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        if ($subject) {
            $prepare = 'SELECT COUNT(question_id) AS cnt FROM hots_question WHERE hots_question.question_subject = "' . $subject . '"';
            if ($query)
                $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        } else {
            $prepare = 'SELECT COUNT(question_id) AS cnt FROM hots_question';
            if ($query)
                $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';
        }

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectAnswer($page = 1) {

        $question = $this->method->post('tempQuestionId', 0);
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = '
            hots_answer.answer_id,
            hots_answer.student_id,
            (SELECT public_student.student_register_number FROM public_student WHERE public_student.student_id = hots_answer.student_id) AS nis,
            (SELECT public_student.student_full_name FROM public_student WHERE public_student.student_id = hots_answer.student_id) AS student_name,
            (SELECT 
                CONCAT(public_grade.grade_name, " ", public_class.class_name)
            FROM
                public_class_history
                INNER JOIN public_student ON (public_class_history.student_id = public_student.student_id)
                INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                INNER JOIN public_grade ON (public_class.class_grade = public_grade.grade_id)
            WHERE
                public_school_year.school_year_status = 1 AND 
                public_student.student_id = hots_answer.student_id) AS grade,
            hots_answer.question_id,
            hots_answer.answer_content,
            hots_answer.answer_file,
            hots_answer.answer_date,
            hots_answer.answer_score,
            hots_answer.answer_status,
            (SELECT 
                hots_answer_status.answer_status
            FROM
                hots_answer_status
            WHERE
                hots_answer_status.answer_status_id = hots_answer.answer_status) AS status';

        $prepare = 'SELECT ' . $listSelect . ' FROM hots_answer WHERE hots_answer.question_id = "' . $question . '"';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAnswer() {

        $question = $this->method->post('tempQuestionId', 0);
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(answer_id) AS cnt FROM hots_answer WHERE hots_answer.question_id = "' . $question . '"';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE
                                    FROM
                                        hots_question
                                    WHERE
                                        hots_question.question_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function selectAnswerByQuestionId($id) {
        $sth = $this->db->prepare('SELECT 
                                        hots_answer.answer_id,
                                        hots_answer.student_id,
                                        hots_answer.question_id,
                                        hots_answer.answer_content,
                                        hots_answer.answer_file,
                                        hots_answer.answer_date,
                                        hots_answer.answer_score,
                                        hots_answer.answer_status,
                                        public_student.student_register_number,
                                        public_student.student_full_name,
                                        public_class.class_name,
                                        public_grade.grade_name
                                    FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                        INNER JOIN public_grade ON (public_class.class_grade = public_grade.grade_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                    WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        hots_answer.question_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function createSave() {
        $subject = $this->method->post('subject');
        $title_question = $this->method->post('title_question');
        $content_question = $this->method->post('content_question');
        $start_date = $this->method->post('start_date');
        $end_date = $this->method->post('end_date');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('INSERT INTO
                                        hots_question(
                                        question_subject,
                                        question_title,
                                        question_description,
                                        question_start_date,
                                        question_end_date,
                                        question_status,
                                        question_entry)
                                    VALUES(
                                        :subject,
                                        :title_question,
                                        :content_question,
                                        :start_date,
                                        :end_date,
                                        :status,
                                        NOW())');
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':title_question', $title_question);
        $sth->bindValue(':content_question', $content_question);
        $sth->bindValue(':start_date', date('Y-m-d', strtotime($start_date)));
        $sth->bindValue(':end_date', date('Y-m-d', strtotime($end_date)));
        $sth->bindValue(':status', $status);

        return $sth->execute();
    }
    
    public function updateSave($id) {
        $subject = $this->method->post('subject');
        $title_question = $this->method->post('title_question');
        $content_question = $this->method->post('content_question');
        $start_date = $this->method->post('start_date');
        $end_date = $this->method->post('end_date');
        $status = $this->method->post('status');

        $sth = $this->db->prepare(' UPDATE
                                        hots_question
                                    SET
                                        question_subject = :subject,
                                        question_title = :title_question,
                                        question_description = :content_question,
                                        question_start_date = :start_date,
                                        question_end_date = :end_date,
                                        question_status = :status
                                    WHERE
                                        hots_question.question_id = :id ');
        $sth->bindValue(':subject', $subject);
        $sth->bindValue(':title_question', $title_question);
        $sth->bindValue(':content_question', $content_question);
        $sth->bindValue(':start_date', date('Y-m-d', strtotime($start_date)));
        $sth->bindValue(':end_date', date('Y-m-d', strtotime($end_date)));
        $sth->bindValue(':status', $status);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

}