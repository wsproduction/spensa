<?php

class DataModel extends Model {

    public $fileNameAvatar;

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

    public function selecQuestion($page = 1) {

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

    public function delete() {
        $id = $this->method->post('id',0);
        $sth = $this->db->prepare('DELETE
                                    FROM
                                        hots_question
                                    WHERE
                                        hots_question.question_id IN (:id)');
        $sth->bindValue(':id', $id);
        return $sth->execute();
    }

}