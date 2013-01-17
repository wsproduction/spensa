<?php

class ReportModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function selectPinaltyByPeriod($period = 0) {
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
}