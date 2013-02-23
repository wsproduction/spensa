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

    public function deleteSave() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare("
                            DELETE 
                            FROM HOLIDAYS 
                            WHERE HOLIDAYS.HOLIDAYID IN (" . $id . ")
                        ");
        return $sth->execute();
    }

    public function createSave() {
        $description = $this->method->post('description', null);
        $sdate = $this->method->post('sdate', null);
        $fdate = $this->method->post('fdate', null);

        $datetime1 = new DateTime(date('Y-m-d', strtotime($sdate)));
        $datetime2 = new DateTime(date('Y-m-d', strtotime($fdate)));
        $datetime2->modify('+1 day');
        $interval = $datetime1->diff($datetime2);
        $duration = $interval->format('%a');

        $sth = $this->db->prepare("
                            INSERT INTO 
                                HOLIDAYS (
                                    HOLIDAYNAME,
                                    HOLIDAYDAY,
                                    STARTTIME,
                                    DURATION,
                                    DeptID
                                )
                            VALUES (
                                :holidayname,
                                :holidayday,
                                :starttime,
                                :duration,
                                :deptid
                            )
                        ");
        $sth->bindValue(':holidayname', $description);
        $sth->bindValue(':holidayday', 1);
        $sth->bindValue(':starttime', $sdate);
        $sth->bindValue(':duration', $duration);
        $sth->bindValue(':deptid', 0);
        return $sth->execute();
    }

}