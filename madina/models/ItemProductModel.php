<?php

class ItemProductModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllProduct($param) {
        $prepare = ' SELECT 
                        product.product_id,
                        product.product_type,
                        product.product_code,
                        product.product_name,
                        product.product_description,
                        product.product_status,
                        product.product_entry,
                        product.product_entry_update,
                        product_type.type_code,
                        product_type.type_name,
                        product_category.category_name
                      FROM
                        product
                        INNER JOIN product_type_aggregation ON (product.product_type = product_type_aggregation.aggregation_id)
                        INNER JOIN product_type ON (product_type_aggregation.aggregation_type = product_type.type_id)
                        INNER JOIN product_category ON (product_type_aggregation.aggregation_category = product_category.category_id)';

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

    public function saveProduct($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        product(
                        product_id,
                        product_type,
                        product_code,
                        product_name,
                        product_description,
                        product_status,
                        product_entry,
                        product_entry_update)
                      VALUES(
                        (SELECT IF (
                            (SELECT COUNT(e.product_id) FROM product AS e 
                                    WHERE e.product_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),"%")) 
                                    ORDER BY e.product_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.product_id + 1 ) FROM product AS e 
                                    WHERE e.product_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),"%")) 
                                    ORDER BY e.product_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),"0001")))
                        ),
                        :type,
                        (SELECT IF (
                            (SELECT COUNT(e.product_type) FROM product AS e 
                                    WHERE e.product_type  = :type
                                    ORDER BY e.product_type DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.product_code + 1 ) FROM product AS e 
                                    WHERE  e.product_type  = :type 
                                    ORDER BY e.product_code DESC LIMIT 1), "001")
                        ),
                        :name,
                        :description,
                        :status,
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