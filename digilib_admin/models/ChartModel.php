<?php

class ChartModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function selectPeriod() {
        $sth = $this->db->prepare("SELECT 
                                    public_period.period_id,
                                    public_period.period_start,
                                    public_period.period_finish,
                                    public_period.period_status
                                  FROM
                                    public_period");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectPeriodById($periodid = 0) {
        $sth = $this->db->prepare("SELECT 
                                    public_period.period_id,
                                    public_period.period_start,
                                    public_period.period_finish,
                                    public_period.period_status
                                  FROM
                                    public_period
                                  WHERE
                                    public_period.period_id = :period_id");
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':period_id', $periodid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectChart($isa = 0, $mothYear = array()) {
        $sth = $this->db->prepare('
                                SELECT
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year0 ) AS "jul",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year1 ) AS "aug",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year2 ) AS "sep",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year3 ) AS "okt",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year4 ) AS "nov",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year5 ) AS "des",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year6 ) AS "jan",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year7 ) AS "feb",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year8 ) AS "mar",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year9 ) AS "apr",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year10 ) AS "may",
                                    ( SELECT 
                                        COUNT(digilib_borrowed_history.borrowed_history_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                                      WHERE
                                        digilib_members.members_isa = :isa AND 
                                        DATE_FORMAT(digilib_borrowed_history.borrowed_history_star, "%m%Y") = :moth_year11 ) AS "jun"
                                ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);

        $sth->bindValue(':isa', $isa);
        foreach ($mothYear as $key => $value) {
            $sth->bindValue(':moth_year' . $key, $value);
        }

        $sth->execute();
        return $sth->fetchAll();
    }

}