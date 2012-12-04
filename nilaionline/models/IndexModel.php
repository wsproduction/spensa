<?php

class IndexModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectChart($grade = 0, $mothYear=array()) {
        $sth = $this->db->prepare('
                                SELECT
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year0 ) AS "jul",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year1 ) AS "aug",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year2 ) AS "sep",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year3 ) AS "okt",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year4 ) AS "nov",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year5 ) AS "des",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year6 ) AS "jan",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year7 ) AS "feb",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year8 ) AS "mar",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year9 ) AS "apr",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year10 ) AS "may",
                                    ( SELECT 
                                        COUNT(hots_answer.answer_id)
                                      FROM
                                        hots_answer
                                        INNER JOIN public_student ON (hots_answer.student_id = public_student.student_id)
                                        INNER JOIN public_class_history ON (public_student.student_id = public_class_history.student_id)
                                        INNER JOIN public_school_year ON (public_class_history.school_year = public_school_year.school_year_id)
                                        INNER JOIN public_class ON (public_class_history.class_id = public_class.class_id)
                                      WHERE
                                        public_school_year.school_year_status = 1 AND 
                                        public_class.class_grade = :grade AND 
                                        DATE_FORMAT(hots_answer.answer_date, "%m%Y") = :moth_year11 ) AS "jun"
                                ');
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        
        $sth->bindValue(':grade', $grade);
        foreach ($mothYear as $key=>$value) {
            $sth->bindValue(':moth_year' . $key, $value);
        }
        
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllSubject() {
        $sth = $this->db->prepare('SELECT * FROM hots_subject');
        $sth->setFetchMode(PDO::FETCH_ASSOC);        
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectWinnersBySubjectId($id) {
        $sth = $this->db->prepare('SELECT 
                                        hots_winners.winner_id,
                                        hots_winners.winner_name,
                                        hots_winners.winners_question,
                                        hots_winners.entry_date,
                                        public_student.student_full_name,
                                        public_student.student_picture
                                    FROM
                                        hots_winners
                                        INNER JOIN hots_question ON (hots_winners.winners_question = hots_question.question_id)
                                        INNER JOIN public_student ON (hots_winners.winner_name = public_student.student_id)
                                    WHERE
                                        hots_question.question_subject = :id
                                    ORDER BY 
                                        hots_winners.entry_date DESC
                                    LIMIT 1');
        $sth->bindValue(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);        
        $sth->execute();
        return $sth->fetchAll();
    }
    
}