<?php

class SigninModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {

        $nis = $this->method->post('nis');
        $password = $this->method->post('password');

        $sth = $this->db->prepare('
                                    SELECT 
                                        public_student.student_id,
                                        public_student.student_register_number,
                                        public_student.student_full_name
                                    FROM
                                        public_student
                                    WHERE
                                        public_student.student_register_number = :nis AND 
                                        public_student.student_password = MD5(:password)
                                ');
        $sth->bindValue(':nis', $nis);
        $sth->bindValue(':password', $password);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        if ($sth->execute()) {
            if ($sth->rowCount() > 0) {
                $data = $sth->fetchAll();
                return array(1, $data);
            } else {
                return array(0);
            }
        } else {
            return array(0);
        }
    }

}