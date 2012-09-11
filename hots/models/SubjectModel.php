<?php

class SubjectModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectSubjectById($id = 0) {
        $sth = $this->db->prepare('SELECT * FROM hots_subject WHERE subject_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->fetchAll();
    }

    public function selectAllQuestion($id = 0, $start = 1, $count = 100) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        hots_question.question_id,
                                        hots_question.question_subject,
                                        hots_question.question_title,
                                        hots_question.question_description,
                                        hots_question.question_start_date,
                                        hots_question.question_end_date,
                                        hots_question.question_status,
                                        DATEDIFF(hots_question.question_end_date,NOW()) AS range_date 
                                    FROM 
                                        hots_question 
                                    WHERE 
                                        question_subject = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->fetchAll();
    }

    public function countAllQuestion($id = 0) {
        $sth = $this->db->prepare('SELECT * FROM hots_question WHERE question_subject = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->rowCount();
    }

    public function selectDataQuestionByID($id = 0) {
        $sth = $this->db->prepare('SELECT 
                                        hots_question.question_id,
                                        hots_question.question_subject,
                                        hots_question.question_title,
                                        hots_question.question_description,
                                        hots_question.question_start_date,
                                        hots_question.question_end_date,
                                        hots_question.question_status,
                                        DATEDIFF(hots_question.question_end_date,NOW()) AS range_date 
                                    FROM 
                                        hots_question 
                                    WHERE question_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->fetchAll();
    }

    public function countFollowers($id = 0) {
        $sth = $this->db->prepare('SELECT * FROM hots_answer WHERE question_id = :id AND answer_status NOT IN (1,5);');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->rowCount();
    }

    public function answerSave() {
        
        $upload = Src::plugin()->PHPUploader();
        if ($this->method->files('file_answer', 'tmp_name')) {
            $upload->SetFileName($this->method->files('file_answer', 'name'));
            $upload->ChangeFileName('answer_' . date('Ymd') . time());
            $upload->SetTempName($this->method->files('file_answer', 'tmp_name'));
            $upload->SetUploadDirectory(Web::path() . 'asset/upload/file/'); //Upload directory, this should be writable
            if ($upload->UploadFile()) {
                //$this->saveCover($lastBookID, $upload->GetFileName());
            }
        }
    }

}