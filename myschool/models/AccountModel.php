<?php

class AccountModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function savePassword() {
        Session::init();

        $user_id = Session::get('user_id');
        $password = $this->method->post('new_password');

        $sth = $this->db->prepare('UPDATE
                                    myschool_user
                                  SET
                                    user_password = PASSWORD(:password)
                                  WHERE
                                    myschool_user.user_id = :user_id ');

        $sth->bindValue(':password', $password);
        $sth->bindValue(':user_id', $user_id);

        return $sth->execute();
    }

    public function checkOldPassword() {
        Session::init();

        $user_id = Session::get('user_id');
        $password = $this->method->post('old_password');

        $sth = $this->db->prepare('SELECT *
                                    FROM
                                      myschool_user
                                    WHERE
                                      myschool_user.user_id = :user_id AND 
                                      myschool_user.user_password = PASSWORD(:password)');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':user_id', $user_id);
        $sth->bindValue(':password', $password);
        $sth->execute();
        return $sth->rowCount();
    }

}