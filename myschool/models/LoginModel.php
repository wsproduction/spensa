<?php

class LoginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $sth = $this->db->prepare(' SELECT 
                                        myschool_user.user_id,
                                        myschool_user.user_references,
                                        myschool_isa.isa_id,
                                        myschool_isa.isa_title,
                                        myschool_isa.isa_dbroot
                                    FROM
                                        myschool_user
                                        INNER JOIN myschool_isa ON (myschool_user.user_isa = myschool_isa.isa_id)
                                    WHERE
                                        myschool_user.user_name = (:username) AND 
                                        myschool_user.user_password = PASSWORD(:password)');
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