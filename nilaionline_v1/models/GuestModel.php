<?php

class GuestModel extends Model {

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
 
    public function countTeacher() {
        $sth = $this->db->prepare('SELECT COUNT(*) cnt FROM
                                    (SELECT 
                                     academic_teaching.teaching_teacher
                                   FROM
                                     academic_teaching
                                   GROUP BY
                                     academic_teaching.teaching_teacher) dd');
        $sth->setFetchMode(PDO::FETCH_ASSOC);        
        $sth->execute();
        return $sth->fetchAll();
    }
 
    public function saveTestimony() {
        
        Session::init();
        $user_references = Session::get('user_id');
        $content = $this->method->post('testimony');
        
        $sth = $this->db->prepare('INSERT INTO
                                    myschool_testimony(
                                        testimony_id,
                                        testimony_user,
                                        testimony_content,
                                        testimony_entry)
                                  VALUES(
                                    (SELECT IF (
                                        (SELECT COUNT(e.testimony_id) FROM myschool_testimony AS e 
                                                WHERE e.testimony_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.testimony_id DESC LIMIT 1
                                        ) > 0,
                                        (SELECT ( e.testimony_id + 1 ) FROM myschool_testimony AS e 
                                                WHERE e.testimony_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"%")) 
                                                ORDER BY e.testimony_id DESC LIMIT 1),
                                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%Y%m%d"),"0001")))
                                    ),
                                    :user,
                                    :content,
                                    NOW())');
        
        $sth->bindValue(':user', $user_references);
        $sth->bindValue(':content', $content);
        
        return $sth->execute();
    }
    
}