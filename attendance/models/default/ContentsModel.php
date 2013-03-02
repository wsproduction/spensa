<?php

class ContentsModel extends Model {

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

}