<?php

class UserModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllGender() {
        $sth = $this->db->prepare('SELECT * FROM public_gender');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectMyProfile() {
        Session::init();
        $sth = $this->db->prepare('SELECT 
                                    digilib_user.user_id,
                                    digilib_user.username,
                                    digilib_user.password,
                                    digilib_user.user_group_id,
                                    digilib_user.full_name,
                                    digilib_user.address,
                                    digilib_user.gender,
                                    digilib_user.phone_1,
                                    digilib_user.phone_2,
                                    digilib_user.email,
                                    digilib_user.photo,
                                    digilib_user.entry_date,
                                    digilib_user.entry_update
                                  FROM
                                    digilib_user
                                  WHERE
                                    digilib_user.user_id = :user_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':user_id', Session::get('user_id'));
        $sth->execute();
        return $sth->fetchAll();
    }

}