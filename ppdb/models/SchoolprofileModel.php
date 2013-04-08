<?php

class SchoolprofileModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllSchool($param) {
        $prepare = ' SELECT 
                        ppdb_school_profile.school_id,
                        ppdb_school_profile.school_npsn,
                        ppdb_school_profile.school_name,
                        ppdb_school_profile.school_address,
                        ppdb_school_profile.school_rt,
                        ppdb_school_profile.school_rw,
                        ppdb_school_profile.school_village,
                        ppdb_school_profile.school_subdistric,
                        ppdb_school_profile.school_distric,
                        ppdb_school_profile.school_zipcode,
                        ppdb_school_profile.school_phone,
                        ppdb_school_profile.school_entry,
                        ppdb_school_profile.school_entry_update
                      FROM
                        ppdb_school_profile';

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

    public function saveSchoolProfile($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        ppdb_school_profile(
                        school_id,
                        school_npsn,
                        school_name,
                        school_address,
                        school_rt,
                        school_rw,
                        school_village,
                        school_subdistric,
                        school_distric,
                        school_zipcode,
                        school_phone,
                        school_entry,
                        school_entry_update)
                      VALUES(
                        (SELECT IF (
                            (SELECT COUNT(e.school_id) FROM ppdb_school_profile AS e 
                                    WHERE e.school_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.school_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.school_id + 1 ) FROM ppdb_school_profile AS e 
                                    WHERE e.school_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.school_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"0001")))
                        ),
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':type', $param['type']);
        $sth->bindValue(':name', $param['name']);
        $sth->bindValue(':description', $param['description']);
        $sth->bindValue(':status', $param['status']);

        return $sth->execute();
    }

    public function updateProduct($param) {

        $sth = $this->db->prepare('
                      UPDATE
                        product
                      SET
                        product_name = :name,
                        product_description = :description,
                        product_status = :status,
                        product_entry_update = NOW()
                      WHERE
                        product.product_id = :id
                ');

        $sth->bindValue(':name', $param['name']);
        $sth->bindValue(':description', $param['description']);
        $sth->bindValue(':status', $param['status']);
        $sth->bindValue(':id', $param['id']);
        
        return $sth->execute();
    }

    public function deleteProduct($param) {
        $sth = $this->db->prepare('DELETE FROM product WHERE product.product_id IN (' . $param['id'] . ')');
        return $sth->execute();
    }

    public function selectProductById($product_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                product.product_id,
                                product.product_type,
                                product.product_code,
                                product.product_name,
                                product.product_description,
                                product.product_status,
                                product.product_entry,
                                product.product_entry_update,
                                product_type_aggregation.aggregation_category
                              FROM
                                product
                                INNER JOIN product_type_aggregation ON (product.product_type = product_type_aggregation.aggregation_id)
                              WHERE
                                product.product_id = :product_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':product_id', $product_id);
        $sth->execute();
        return $sth->fetchAll();
    }

}