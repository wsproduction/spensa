<?php

class LoginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $sth = $this->db->prepare('SELECT 
                                        hots_user.user_id,
                                        hots_user.user_name,
                                        hots_user.user_email,
                                        hots_user.user_password
                                    FROM
                                        hots_user
                                    WHERE
                                        hots_user.user_email = :username AND 
                                        hots_user.user_password = PASSWORD(:password)');
        $sth->execute(array(':username' => $_POST['username'], ':password' => $_POST['password']));
        if ($sth->rowCount() > 0) {
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
            $data = $sth->fetchAll();
            return array(1, $data);
        } else {
            return array(0);
        }
    }

}