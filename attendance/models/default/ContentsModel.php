<?php

class ContentsModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectUserByDeptId($deptid = 0) {
        $sth = $this->db->prepare("SELECT * FROM USERINFO WHERE DEFAULTDEPTID = :deptid ORDER BY Name");
        $sth->bindValue(':deptid', $deptid);
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectDescription() {
        $sth = $this->db->prepare("
                            SELECT LEAVECLASS.LEAVEID, LEAVECLASS.LEAVENAME
                            FROM LEAVECLASS
                        ");

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
                                CHECKINOUT.USERID IN (" . $nameid . ") AND
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
                                USERINFO.USERID IN (" . $nameid . ") 
                            ORDER BY USERINFO.Name
                        ");
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectSpeday($nameid, $sdate, $fdate) {
        $sth = $this->db->prepare("
                            SELECT 
                                USER_SPEDAY.USERID,
                                USER_SPEDAY.STARTSPECDAY, 
                                USER_SPEDAY.ENDSPECDAY, 
                                USER_SPEDAY.DATEID, 
                                USER_SPEDAY.YUANYING,
                                LEAVECLASS.LEAVENAME
                            FROM
                                USER_SPEDAY
                                INNER JOIN LEAVECLASS ON USER_SPEDAY.DATEID = LEAVECLASS.LEAVEID
                            WHERE (
                                USER_SPEDAY.USERID IN (" . $nameid . ")  AND (
                                ((:sdate)  BETWEEN Format (USER_SPEDAY.STARTSPECDAY,'mm/dd/yyyy') AND Format (USER_SPEDAY.ENDSPECDAY,'m/d/yyyy')) OR
                                ((:fdate)  BETWEEN Format (USER_SPEDAY.STARTSPECDAY,'mm/dd/yyyy') AND Format (USER_SPEDAY.ENDSPECDAY,'m/d/yyyy')) )  
                            )
                        ");
        $sth->bindValue(':sdate', $sdate);
        $sth->bindValue(':fdate', $fdate);
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectHolidays($sdate, $fdate) {

        $sth = $this->db->prepare("
                            SELECT 
                                HOLIDAYS.HOLIDAYID, 
                                HOLIDAYS.HOLIDAYNAME, 
                                HOLIDAYS.STARTTIME, 
                                DateAdd ('d', HOLIDAYS.DURATION-1, HOLIDAYS.STARTTIME) AS ENDTIME, 
                                HOLIDAYS.DURATION
                            FROM 
                                HOLIDAYS
                            WHERE (
                                ((:sdate) BETWEEN HOLIDAYS.STARTTIME AND DateAdd('d', HOLIDAYS.DURATION-1, HOLIDAYS.STARTTIME)) OR
                                ((:fdate) BETWEEN HOLIDAYS.STARTTIME AND DateAdd('d', HOLIDAYS.DURATION-1, HOLIDAYS.STARTTIME))
                            );
                        ");
        $sth->bindValue(':sdate', $sdate);
        $sth->bindValue(':fdate', $fdate);
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

}