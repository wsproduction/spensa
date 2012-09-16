<?php

class ProjectModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectSubjectById($id = 0) {
        $sth = $this->db->prepare('SELECT * FROM hots_subject WHERE subject_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->fetchAll();
    }

    public function selectAllQuestion($id = 0) {
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

    public function selectAnswerById($id = 0) {
        $sth = $this->db->prepare('
                                    SELECT 
                                        hots_answer.answer_id,
                                        hots_answer.student_id,
                                        hots_answer.question_id,
                                        hots_answer.answer_content,
                                        hots_answer.answer_file,
                                        hots_answer.answer_date,
                                        hots_answer.answer_score,
                                        hots_answer.answer_status
                                    FROM
                                        hots_answer
                                    WHERE
                                        hots_answer.answer_id = :id');
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

    public function answerUpdate() {
        
        $answer_id = $this->method->post('answer_id');
        $text_answer = $this->method->post('text_answer');

        $sth = $this->db->prepare('UPDATE
                                        hots_answer
                                    SET
                                        answer_content = :text_answer,
                                        answer_date = NOW()
                                    WHERE
                                        hots_answer.answer_id = :id');

        $sth->bindValue(':id', $answer_id, PDO::PARAM_NULL);
        $sth->bindValue(':text_answer', $text_answer, PDO::PARAM_NULL);

        if ($sth->execute()) {
            $lastAnswerID = $answer_id;

            $upload = Src::plugin()->PHPUploader();
            if ($this->method->files('file_answer', 'tmp_name')) {
                $upload->SetFileName($this->method->files('file_answer', 'name'));
                $upload->ChangeFileName('answer_' . date('Ymd') . time());
                $upload->SetTempName($this->method->files('file_answer', 'tmp_name'));
                $upload->SetUploadDirectory(Web::path() . 'asset/upload/file/'); //Upload directory, this should be writable
                if ($upload->UploadFile()) {
                    $this->saveFile($lastAnswerID, $upload->GetFileName());
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function saveFile($id, $fileName) {
        $sth = $this->db->prepare('UPDATE
                                        hots_answer
                                    SET
                                        answer_file = :file_name
                                    WHERE
                                        hots_answer.answer_id = :id');
        $sth->bindValue(':id', $id);
        $sth->bindValue(':file_name', $fileName);
        if ($sth->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteFile() {

        $filename = Web::path() . 'asset/upload/file/' . $this->method->post('file');
        $id = $this->method->post('id');

        $upload = Src::plugin()->PHPUploader();
        $upload->RemoveFile($filename);

        if (!file_exists($filename)) {
            $sth = $this->db->prepare('UPDATE
                                        hots_answer
                                    SET
                                        answer_file = NULL
                                    WHERE
                                        hots_answer.answer_id = :id');
            $sth->bindValue(':id', $id);
            if ($sth->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}