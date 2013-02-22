<?php

class HolidaysModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectHolidays() {

        $years = $this->method->post('years', 0);

        $sth = $this->db->prepare("
                    SELECT HOLIDAYS.HOLIDAYID, HOLIDAYS.HOLIDAYNAME, HOLIDAYS.STARTTIME, DateAdd('d',[DURATION] - 1,[STARTTIME]) AS [INTERVAL]
                    FROM HOLIDAYS 
                    WHERE Format(HOLIDAYS.STARTTIME,'yyyy') = :years
                    ORDER BY HOLIDAYS.STARTTIME 
                ");

        $sth->bindValue(':years', $years);

        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectAllCheckTime($nameid, $sdate, $fdate) {
        $sth = $this->db->prepare("
                            SELECT 
                                CHECKINOUT.USERID,
                                CHECKINOUT.CHECKTIME
                            FROM 
                                CHECKINOUT
                            WHERE
                                CHECKINOUT.USERID IN(" . $nameid . ") AND
                                CHECKINOUT.CHECKTIME BETWEEN #" . $sdate . "# AND #" . $fdate . "#
                            ORDER BY CHECKINOUT.USERID;
                        ");
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectUserInfo($nameid) {

        $sth = $this->db->prepare("
                            SELECT 
                                USERINFO.USERID, 
                                USERINFO.Name, 
                                USERINFO.Gender, 
                                USERINFO.SSN, 
                                USERINFO.CardNo,
                                SCHCLASS.SCHNAME, 
                                SCHCLASS.STARTTIME, 
                                SCHCLASS.ENDTIME, 
                                SCHCLASS.LATEMINUTES, 
                                SCHCLASS.CHECKIN, 
                                SCHCLASS.CHECKOUT, 
                                SCHCLASS.CHECKINTIME1, 
                                SCHCLASS.CHECKINTIME2, 
                                SCHCLASS.CHECKOUTTIME1, 
                                SCHCLASS.CHECKOUTTIME2, 
                                SCHCLASS.WorkDay
                            FROM (
                                USERINFO 
                                INNER JOIN USER_OF_RUN ON USERINFO.USERID = USER_OF_RUN.USERID) 
                                INNER JOIN SCHCLASS ON USER_OF_RUN.NUM_OF_RUN_ID = SCHCLASS.SCHCLASSID
                            WHERE 
                                USERINFO.USERID IN(" . $nameid . ") 
                            ORDER BY USERINFO.Name
                        ");
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function deleteSave($id) {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare("
                            DELETE 
                            FROM HOLIDAYS 
                            WHERE HOLIDAYS.HOLIDAYID IN (" . $id . ")
                        ");
        return $sth->execute();
    }

}