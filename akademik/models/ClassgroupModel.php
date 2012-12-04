<?php

class ClassgroupModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function saveCreate() {
        
        $period = $this->method->post('period');
        list($grade, $classroom) = explode('_', $this->method->post('class'));
        $room = -1;
        $guardian = $this->method->post('guardian');
        
        $sth = $this->db->prepare('
                            INSERT INTO
                                academic_classgroup(
                                    classgroup_id,
                                    classgroup_grade,
                                    classgroup_name,
                                    classgroup_room,
                                    classgroup_period,
                                    classgroup_guardian,
                                    classgroup_entry,
                                    classgroup_entry_update)
                            VALUES(
                                (SELECT IF(
                                    (SELECT COUNT(ac.classgroup_id) 
                                    FROM academic_classgroup AS ac) > 0, 
                                        (SELECT ac.classgroup_id 
                                        FROM academic_classgroup AS ac 
                                        ORDER BY ac.classgroup_id DESC LIMIT 1) + 1,
                                    1)
                                ),
                                :grade,
                                :name,
                                :room,
                                :period,
                                :guardian,
                                NOW(),
                                NOW())
                          ');
        $sth->bindValue(':grade', $grade);
        $sth->bindValue(':name', $classroom);
        $sth->bindValue(':room', $room);
        $sth->bindValue(':period', $period);
        $sth->bindValue(':guardian', $guardian);
        return $sth->execute();
    }
    
    public function selectAllGrade() {
        $sth = $this->db->prepare('
                            SELECT 
                                academic_grade.grade_id,
                                academic_grade.grade_title,
                                academic_grade.grade_name
                            FROM
                                academic_grade
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllClassRoom() {
        $sth = $this->db->prepare('
                            SELECT 
                                academic_classroom.classroom_id,
                                academic_classroom.classroom_name
                            FROM
                                academic_classroom
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllPeriod() {
        $sth = $this->db->prepare('
                            SELECT 
                                academic_period.period_id,
                                academic_period.period_years_start,
                                academic_period.period_years_end
                            FROM
                                academic_period
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllGuardian() {
        $sth = $this->db->prepare('
                            SELECT
                                employees.employees_id,
                                employees.employess_name
                            FROM
                                employees
                            ORDER BY employees.employess_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}