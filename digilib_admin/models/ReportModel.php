<?php

class ReportModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function selectPinaltyByPeriod($period = 0) {
        $sth = $this->db->prepare("SELECT 
                            digilib_members.members_id,
                            digilib_members.members_name,
                            digilib_members.members_gender,
                            digilib_members.members_desc,
                            digilib_isa.isa_title,
                            (SELECT COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1 FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_penalty > 0 AND digilib_borrowed_history.borrowed_history_members = digilib_members.members_id AND DATE_FORMAT(digilib_borrowed_history.borrowed_history_return, '%m%Y') = :period) AS pinalty_count,
                            (SELECT SUM(digilib_borrowed_history.borrowed_history_penalty) AS FIELD_1 FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_penalty > 0 AND digilib_borrowed_history.borrowed_history_members = digilib_members.members_id AND DATE_FORMAT(digilib_borrowed_history.borrowed_history_return, '%m%Y') = :period) AS pinalty_total
                          FROM
                            digilib_borrowed_history
                            INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                            INNER JOIN digilib_isa ON (digilib_members.members_isa = digilib_isa.isa_id)
                          WHERE
                            digilib_borrowed_history.borrowed_history_penalty > 0 AND
                            digilib_borrowed_history.borrowed_history_status = 1 AND
                            DATE_FORMAT(digilib_borrowed_history.borrowed_history_return, '%m%Y') = :period
                          GROUP BY
                            digilib_members.members_id
                          ORDER BY 
                            digilib_members.members_name");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period',$period);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectBorrowerByPeriod($period = 0) {
        $sth = $this->db->prepare("SELECT 
                            digilib_members.members_id,
                            digilib_members.members_name,
                            digilib_members.members_gender,
                            digilib_members.members_desc,
                            digilib_isa.isa_title,
                            (SELECT COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1 FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_members = digilib_members.members_id AND DATE_FORMAT(digilib_borrowed_history.borrowed_history_return, '%m%Y') = :period) AS borrow_count
                          FROM
                            digilib_borrowed_history
                            INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                            INNER JOIN digilib_isa ON (digilib_members.members_isa = digilib_isa.isa_id)
                          WHERE
                            DATE_FORMAT(digilib_borrowed_history.borrowed_history_return, '%m%Y') = :period
                          GROUP BY
                            digilib_members.members_id
                          ORDER BY 
                            borrow_count");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period',$period);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectBorrowByPeriod($period = 0) {
        $sth = $this->db->prepare("SELECT 
                                    digilib_book.book_id,
                                    digilib_book.book_title,
                                    digilib_book.book_foreign_title,
                                    digilib_book.book_publishing
                                  FROM
                                    digilib_book_register
                                    INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                                    INNER JOIN digilib_borrowed_history ON (digilib_book_register.book_register_id = digilib_borrowed_history.borrowed_history_book)
                                  GROUP BY
                                    digilib_book.book_id");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period',$period);
        $sth->execute();
        return $sth->fetchAll();
    }
}