<?php

class LoginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $sth = $this->db->prepare('SELECT *
                        FROM
                        digilib_user
                        INNER JOIN digilib_user_group ON (digilib_user.user_group_id = digilib_user_group.user_group_id)
                        WHERE username=:username AND password=MD5(:password)');
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