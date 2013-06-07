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
                                    digilib_user.birthplace,
                                    digilib_user.birthdate,
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

    public function selectCurentPasswrod() {
        Session::init();
        $curent_password = $this->method->post('curent_password');
        $sth = $this->db->prepare('SELECT 
                                    digilib_user.user_id,
                                    digilib_user.password
                                  FROM
                                    digilib_user
                                  WHERE
                                    digilib_user.user_id = :user_id AND 
                                    digilib_user.password = MD5(:password)');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':user_id', Session::get('user_id'));
        $sth->bindValue(':password', $curent_password);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function updateProfileSave() {
        Session::init();

        $name = $this->method->post('full_name');
        $gender = $this->method->post('gender');
        $birthplace = $this->method->post('birthplace');
        $birthdate = $this->method->post('birth_years') . '-' . $this->method->post('birth_month') . '-' . $this->method->post('birth_day');
        $address = $this->method->post('address');
        $phone1 = $this->method->post('phone1');
        $phone2 = $this->method->post('phone2');
        $email = $this->method->post('email');

        $sth = $this->db->prepare('UPDATE
                                    digilib_user
                                  SET
                                    full_name = :full_name,
                                    address = :address,
                                    gender = :gender,
                                    birthplace = :birthplace,
                                    birthdate = :birthdate,
                                    phone_1 = :phone1,
                                    phone_2 = :phone2,
                                    email = :email,
                                    entry_update = NOW()
                                  WHERE
                                    digilib_user.user_id = :user_id');

        $sth->bindValue(':user_id', Session::get('user_id'));
        $sth->bindValue(':full_name', $name);
        $sth->bindValue(':address', $address);
        $sth->bindValue(':gender', $gender);
        $sth->bindValue(':birthplace', $birthplace);
        $sth->bindValue(':birthdate', $birthdate);
        $sth->bindValue(':phone1', $phone1);
        $sth->bindValue(':phone2', $phone2);
        $sth->bindValue(':email', $email);

        return $sth->execute();
    }

    public function updateAccountSave() {
        Session::init();
        $curent_password = $this->method->post('curent_password');
        $new_password = $this->method->post('confirm_new_password');
        $sth = $this->db->prepare('UPDATE
                                    digilib_user
                                  SET
                                    password =  MD5(:new_password)
                                  WHERE
                                    digilib_user.user_id = :user_id AND 
                                    digilib_user.password = MD5(:curent_password)');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':user_id', Session::get('user_id'));
        $sth->bindValue(':new_password', $new_password);
        $sth->bindValue(':curent_password', $curent_password);
        return $sth->execute();
    }

}