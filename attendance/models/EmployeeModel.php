<?php

class EmployeeModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function addAttendanceSave() {
        try {

            $nameid2 = $this->method->post('nameid2');
            $dates = $this->method->post('dates');
            $hours = $this->method->post('hours');

            $checktime = date('Y-m-d', strtotime($dates)) . ' ' . date('h:i:s A', strtotime($hours));

            $this->db->beginTransaction();

            foreach (explode(',', $nameid2) as $userid) {
                $sth = $this->db->prepare("
                            INSERT INTO 
                                CHECKINOUT (
                                    USERID,
                                    CHECKTIME,
                                    CHECKTYPE,
                                    VERIFYCODE,
                                    SENSORID
                                )
                            VALUES (
                                :userid,
                                :checktime,
                                :checktype,
                                :verifycode,
                                :sensorid
                            )
                        ");
                $sth->bindValue(':userid', $userid);
                $sth->bindValue(':checktime', $checktime);
                $sth->bindValue(':checktype', 'I');
                $sth->bindValue(':verifycode', 1);
                $sth->bindValue(':sensorid', 1);
                $sth->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
    }

    public function editDescriptionSave() {
        try {
            $this->db->beginTransaction();
            
            $userid = $this->method->post('hide_tempid');
            $dates = $this->method->post('hide_dates');

            $startspecday = date('m/d/Y h:i:s', strtotime($dates));
            $endspecday = date('m/d/Y h:i:s', strtotime($dates));

            $dateid = $this->method->post('description');
            $yuanying = $this->method->post('reason');


            $sth = $this->db->prepare("
                            INSERT INTO 
                                USER_SPEDAY (
                                    USERID,
                                    STARTSPECDAY,
                                    ENDSPECDAY,
                                    DATEID,
                                    YUANYING
                                )
                            VALUES (
                                :userid,
                                :startspecday,
                                :endspecday,
                                :dateid,
                                :yuanying
                            )
                        ");

            $sth->bindValue(':userid', $userid);
            $sth->bindValue(':startspecday', $startspecday);
            $sth->bindValue(':endspecday', $endspecday);
            $sth->bindValue(':dateid', $dateid);
            $sth->bindValue(':yuanying', $yuanying);
            $sth->execute();

            $this->db->commit();
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
    }
    
    
}