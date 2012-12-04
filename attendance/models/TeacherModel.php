<?php

class TeacherModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectUserByDeptId($deptid = 0) {

        $sth = $this->db->prepare("
                            SELECT * FROM USERINFO WHERE DEFAULTDEPTID = :deptid ORDER BY Name
                        ");

        $sth->bindValue(':deptid', $deptid);

        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }
    
    public function selectAllCheckTime($sdate, $fdate) {
        $name = $this->method->post('name', 0);
        $nameid = $this->method->post('nameid', 0);

        $newfdate = new DateTime(date('Y-m-d', strtotime($fdate)));
        $newfdate = $newfdate->modify('+1 day');
        $fdate = $newfdate->format('m/d/Y');

        $in = $name;
        if (empty($name)) {
            $in = $nameid;
        }

        $sth = $this->db->prepare("
                            SELECT 
                                CHECKINOUT.USERID,
                                CHECKINOUT.CHECKTIME
                            FROM 
                                CHECKINOUT
                            WHERE
                                CHECKINOUT.USERID IN(" . $in . ") AND
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

    public function selectUserInfo() {
        $name = $this->method->post('name', 0);
        $nameid = $this->method->post('nameid', 0);

        $in = $name;
        if (empty($name)) {
            $in = $nameid;
        }

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
                                USERINFO.USERID IN(" . $in . ") 
                            ORDER BY USERINFO.Name
                        ");
        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

}