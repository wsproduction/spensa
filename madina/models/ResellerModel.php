<?php

class ResellerModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllReseller($param) {
        $prepare = ' SELECT 
                        reseller.reseller_id,
                        reseller.reseller_name,
                        reseller.reseller_nickname,
                        reseller.reseller_gender,
                        reseller.reseller_address,
                        reseller.reseller_birthplace,
                        reseller.reseller_birthdate,
                        reseller.reseller_last_education,
                        reseller.reseller_jobs,
                        reseller.reseller_phone_number,
                        reseller.reseller_email,
                        reseller.reseller_facebook,
                        reseller.reseller_twitter,
                        reseller.reseller_status,
                        reseller.reseller_entry,
                        reseller.reseller_entry_update
                      FROM
                        reseller';

        if ($param['query'])
            $prepare .= ' WHERE ' . $param['qtype'] . ' LIKE "%' . $param['query'] . '%" ';

        $prepare .= ' ORDER BY ' . $param['sortname'] . ' ' . $param['sortorder'];

        $start = (($param['page'] - 1) * $param['rp']);
        $prepare .= ' LIMIT ' . $start . ',' . $param['rp'];

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllCategory() {
        $sth = $this->db->prepare('
                            SELECT 
                                product_category.category_id,
                                product_category.category_name,
                                product_category.category_status,
                                product_category.category_entry,
                                product_category.category_entry_update
                              FROM
                                product_category
                              WHERE
                                product_category.category_status = 1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectTypeByCategory($category_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                product_type_aggregation.aggregation_id,
                                product_type.type_code,
                                product_type.type_name
                              FROM
                                product_type_aggregation
                                INNER JOIN product_type ON (product_type_aggregation.aggregation_type = product_type.type_id)
                              WHERE
                                product_type_aggregation.aggregation_category = :category_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':category_id', $category_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveReseller($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        reseller(
                        reseller_id,
                        reseller_name,
                        reseller_nickname,
                        reseller_gender,
                        reseller_address,
                        reseller_birthplace,
                        reseller_birthdate,
                        reseller_last_education,
                        reseller_jobs,
                        reseller_phone_number,
                        reseller_email,
                        reseller_facebook,
                        reseller_twitter,
                        reseller_status,
                        reseller_entry,
                        reseller_entry_update)
                      VALUES(
                        (SELECT IF (
                            (SELECT COUNT(e.reseller_id) FROM reseller AS e 
                                    WHERE e.reseller_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m%d"),"%")) 
                                    ORDER BY e.reseller_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.reseller_id + 1 ) FROM reseller AS e 
                                    WHERE e.reseller_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m%d"),"%")) 
                                    ORDER BY e.reseller_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m%d"),"0001")))
                        ),
                        :fullname,
                        :nickname,
                        :gender,
                        :address,
                        :birthplace,
                        :birthdate,
                        :education,
                        :jobs,
                        :phone,
                        :email,
                        :facebook,
                        :twitter,
                        :status,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':fullname', $param['fullname']);
        $sth->bindValue(':nickname', $param['nickname']);
        $sth->bindValue(':gender', $param['gender']);
        $sth->bindValue(':address', $param['address']);
        $sth->bindValue(':birthplace', $param['birthplace']);
        $sth->bindValue(':birthdate', $param['birthdate']);
        $sth->bindValue(':education', $param['education']);
        $sth->bindValue(':jobs', $param['jobs']);
        $sth->bindValue(':phone', $param['phone']);
        $sth->bindValue(':email', $param['email']);
        $sth->bindValue(':facebook', $param['facebook']);
        $sth->bindValue(':twitter', $param['twitter']);
        $sth->bindValue(':status', $param['status']);

        return $sth->execute();
    }

    public function updateProduct($param) {

        $sth = $this->db->prepare('
                      UPDATE
                        reseller
                      SET
                        reseller_name = :fullname,
                        reseller_nickname = :nickname,
                        reseller_gender = :gender,
                        reseller_address = :address,
                        reseller_birthplace = :birthplace,
                        reseller_birthdate = :birthdate,
                        reseller_last_education = :education,
                        reseller_jobs = :jobs,
                        reseller_phone_number = :phone,
                        reseller_email = :email,
                        reseller_facebook = :facebook,
                        reseller_twitter = :twitter,
                        reseller_status = :status,
                        reseller_entry_update = NOW()
                      WHERE
                        reseller.reseller_id = :id
                ');

        $sth->bindValue(':fullname', $param['fullname']);
        $sth->bindValue(':nickname', $param['nickname']);
        $sth->bindValue(':gender', $param['gender']);
        $sth->bindValue(':address', $param['address']);
        $sth->bindValue(':birthplace', $param['birthplace']);
        $sth->bindValue(':birthdate', $param['birthdate']);
        $sth->bindValue(':education', $param['education']);
        $sth->bindValue(':jobs', $param['jobs']);
        $sth->bindValue(':phone', $param['phone']);
        $sth->bindValue(':email', $param['email']);
        $sth->bindValue(':facebook', $param['facebook']);
        $sth->bindValue(':twitter', $param['twitter']);
        $sth->bindValue(':status', $param['status']);
        $sth->bindValue(':id', $param['id']);

        return $sth->execute();
    }

    public function deleteProduct($param) {
        $sth = $this->db->prepare('DELETE FROM reseller WHERE reseller.reseller_id IN (' . $param['id'] . ')');
        return $sth->execute();
    }

    public function selectResellerById($reseller_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                reseller.reseller_id,
                                reseller.reseller_name,
                                reseller.reseller_nickname,
                                reseller.reseller_gender,
                                reseller.reseller_address,
                                reseller.reseller_birthplace,
                                reseller.reseller_birthdate,
                                reseller.reseller_last_education,
                                reseller.reseller_jobs,
                                reseller.reseller_phone_number,
                                reseller.reseller_email,
                                reseller.reseller_facebook,
                                reseller.reseller_twitter,
                                reseller.reseller_status,
                                reseller.reseller_entry,
                                reseller.reseller_entry_update
                              FROM
                                reseller
                              WHERE
                                reseller.reseller_id = :reseller_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':reseller_id', $reseller_id);
        $sth->execute();
        return $sth->fetchAll();
    }

}