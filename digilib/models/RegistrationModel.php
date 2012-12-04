<?php

class RegistrationModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getGender() {
        $enum = $this->db->enum('customer', 'gender');
        $out = array();
        foreach ($enum as $value) {
            $out[$value] = $value;
        }
        return $out;
    }

    public function dsCountry() {
        $obj = $this->getCountry();
        $dataList = array();
        if ($obj) {
            foreach ($obj as $value) {
                $dataList[$value->country_id] = $value->country_name;
            }
        }
        return $dataList;
    }

    protected function getCountry() {
        $sth = $this->db->prepare('SELECT * FROM country WHERE is_active = 1 ORDER BY country_name');
        $sth->execute();
        $res = $sth->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function getDistrict($province_id = null) {
        $sth = $this->db->prepare('SELECT * FROM district WHERE district.province_id = :province_id');
        $sth->execute(array(':province_id' => $province_id));
        $res = $sth->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function getEmail() {
        $sth = $this->db->prepare('SELECT email FROM customer WHERE email = :email');
        $sth->execute(array(':email' => $_POST['email']));
        if ($sth->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function runCustomer() {
        $sth = $this->db->prepare('INSERT INTO  customer (
                                            district_id,
                                            full_name,
                                            gender,
                                            address,
                                            zip_code,
                                            phone,
                                            email,
                                            password
                                        ) VALUES ( 
                                            :district_id,
                                            :full_name,
                                            :gender,
                                            :address,
                                            :zip_code,
                                            :phone,
                                            :email,
                                            md5(:password)
                                        )');
        $pro = $sth->execute(array(
                    ':district_id' => $_POST['district'],
                    ':full_name' => $_POST['full_name'],
                    ':gender' => $_POST['gender'],
                    ':address' => $_POST['address'],
                    ':zip_code' => $_POST['zip_code'],
                    ':phone' => $_POST['phone'],
                    ':email' => $_POST['email'],
                    ':password' => $_POST['password']
                ));
        
        if ($pro) {
            return true;
        } else {
            return false;
        }
    }

}