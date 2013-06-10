<?php

class AboutModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAbout() {
        $sth = $this->db->prepare('SELECT 
                                    digilib.digilib_id,
                                    digilib.digilib_name,
                                    digilib.digilib_email,
                                    digilib.digilib_website,
                                    digilib.digilib_agency_name,
                                    digilib.digilib_address,
                                    digilib.digilib_head_of_library,
                                    digilib.digilib_nip,
                                    digilib.digilib_vision,
                                    digilib.digilib_mision,
                                    digilib.digilib_rule_borrowing
                                  FROM
                                    digilib
                                  WHERE
                                    digilib.digilib_id = "240988"');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function updateSave() {
        
        $library_name = $this->method->post('library_name');
        $email = $this->method->post('email');
        $website = $this->method->post('website');
        $agency_name = $this->method->post('agency_name');
        $address = $this->method->post('address');
        $head_of_library = $this->method->post('head_of_library');
        $nip = $this->method->post('nip');
        $vision = $this->method->post('vision');
        $mission = $this->method->post('mission');
        $rule_borrowing = $this->method->post('rule_borrowing');
        
        $sth = $this->db->prepare('UPDATE
                                    digilib
                                  SET
                                    digilib_name = :library_name,
                                    digilib_email = :email,
                                    digilib_website = :website,
                                    digilib_agency_name = :agency_name,
                                    digilib_address = :address,
                                    digilib_head_of_library = :head_of_library,
                                    digilib_nip = :nip,
                                    digilib_vision = :vision,
                                    digilib_mision = :mission,
                                    digilib_rule_borrowing = :rule_borrowing
                                  WHERE
                                    digilib.digilib_id = "240988"');
        
        $sth->bindValue(':library_name', $library_name);
        $sth->bindValue(':email', $email);
        $sth->bindValue(':website', $website);
        $sth->bindValue(':agency_name', $agency_name);
        $sth->bindValue(':address', $address);
        $sth->bindValue(':head_of_library', $head_of_library);
        $sth->bindValue(':nip', $nip);
        $sth->bindValue(':vision', $vision);
        $sth->bindValue(':mission', $mission);
        $sth->bindValue(':rule_borrowing', $rule_borrowing);
        
        return $sth->execute();
    }

}