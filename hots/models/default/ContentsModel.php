<?php

class ContentsModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectMenu($web = 0, $group = 0) {
        $sth = $this->db->prepare('SELECT *
                                   FROM
                                        public_menu
                                   WHERE
                                        public_menu.web_id = :web AND 
                                        public_menu.menu_group = :group AND 
                                        public_menu.is_active = 1
                                   ORDER BY 
                                        public_menu.menu_order ASC
                                   ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':web' => $web, ':group' => $group));
        return $sth->fetchAll();
    }

    public function selectAllSubject() {
        $sth = $this->db->prepare('SELECT 
                                        hots_subject.subject_id,
                                        hots_subject.subject_title,
                                        hots_subject.subject_description,
                                        (SELECT COUNT(question_id) FROM hots_question WHERE hots_question.question_status = 1 AND hots_question.question_subject = hots_subject.subject_id) AS count_question
                                    FROM
                                        hots_subject
                                   ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}