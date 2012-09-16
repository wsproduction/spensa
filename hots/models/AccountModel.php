<?php

class AccountModel extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function selectAllProject($start = 1, $count = 100) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        hots_answer.answer_id,
                                        hots_answer.student_id,
                                        hots_answer.question_id,
                                        hots_answer.answer_content,
                                        hots_answer.answer_file,
                                        hots_answer.answer_date,
                                        hots_answer.answer_score,
                                        hots_answer_status.answer_status,
                                        hots_question.question_start_date,
                                        hots_question.question_end_date,
                                        hots_subject.subject_title
                                    FROM
                                        hots_answer
                                    INNER JOIN hots_answer_status ON (hots_answer.answer_status = hots_answer_status.answer_status_id)
                                    INNER JOIN hots_question ON (hots_answer.question_id = hots_question.question_id)
                                    INNER JOIN hots_subject ON (hots_question.question_subject = hots_subject.subject_id)
                                    WHERE
                                        hots_answer.student_id = :id
                                    ORDER BY hots_answer.answer_id DESC');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => Session::get('id')));
        return $sth->fetchAll();
    }

    public function countAllProject() {
        $sth = $this->db->prepare('SELECT * FROM hots_answer WHERE hots_answer.student_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => Session::get('id')));
        return $sth->rowCount();
    }

    public function cekPassword() {
        Session::init();
        $id = Session::get('id');
        $old_password = $this->method->post('old_password');

        $sth_cek = $this->db->prepare('SELECT * FROM public_student WHERE student_id=:id AND student_password=MD5(:password)');
        $sth_cek->bindValue(':id', $id);
        $sth_cek->bindValue(':password', $old_password);
        $sth_cek->execute();

        if ($sth_cek->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function saveChangePassword() {
        Session::init();
        $id = Session::get('id');
        $conf_password = $this->method->post('conf_password');

        $sth = $this->db->prepare('UPDATE
                                        public_student
                                    SET
                                        student_password = MD5(:password)
                                    WHERE
                                        student_id = :id');
        $sth->bindValue(':id', $id);
        $sth->bindValue(':password', $conf_password);
        if ($sth->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function saveAvatar() {
        
    }

}