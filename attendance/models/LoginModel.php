<?php

class LoginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $username = $this->method->post('username');
        $password = md5($this->method->post('password'));

        $sth = $this->db->prepare("
                            SELECT * FROM USERAPP WHERE USERNAME = :username AND PASSWORD = :password
                        ");

        $sth->bindValue(':username', $username);
        $sth->bindValue(':password', $password);

        if ($sth->execute()) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $data = $sth->fetchAll();
            if (count($data) > 0) {
                return array(1, $data);
            } else {
                return array(0);
            }
        } else {
            return array(0);
        }
    }

}