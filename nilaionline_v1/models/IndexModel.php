<?php

class IndexModel extends Model {

    public function __construct() {
        parent::__construct();
    }
 
    public function countStudent() {
        $sth = $this->db->prepare('SELECT COUNT(academic_student.student_nis) AS cnt FROM academic_student');
        $sth->setFetchMode(PDO::FETCH_ASSOC);        
        $sth->execute();
        return $sth->fetchAll();
    }
 
    public function countScore() {
        $sth = $this->db->prepare('SELECT COUNT(academic_score.score_id) AS cnt FROM academic_score');
        $sth->setFetchMode(PDO::FETCH_ASSOC);        
        $sth->execute();
        return $sth->fetchAll();
    }
    
}