<?php

class ItemproductModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllProduct($param) {
        $prepare = ' SELECT 
                        pruduct_item.item_id,
                        pruduct_item.item_product,
                        pruduct_item.item_size,
                        pruduct_item.item_stock,
                        pruduct_item.item_price,
                        pruduct_item.item_discount,
                        pruduct_item.item_status,
                        pruduct_item.item_entry,
                        pruduct_item.item_entry_update,
                        product.product_type,
                        product.product_code,
                        product.product_name,
                        product.product_description,
                        product_type.type_code,
                        product_type.type_name,
                        product_category.category_name,
                        product_size.size_description
                      FROM
                        pruduct_item
                        INNER JOIN product ON (pruduct_item.item_product = product.product_id)
                        INNER JOIN product_type_aggregation ON (product.product_type = product_type_aggregation.aggregation_id)
                        INNER JOIN product_type ON (product_type_aggregation.aggregation_type = product_type.type_id)
                        INNER JOIN product_category ON (product_type_aggregation.aggregation_category = product_category.category_id)
                        INNER JOIN product_size_aggregation ON (pruduct_item.item_size = product_size_aggregation.aggregation_id)
                        INNER JOIN product_size ON (product_size_aggregation.aggregation_size = product_size.size_id)';

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

    public function selectSizeByCategory($category_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                product_size_aggregation.aggregation_id,
                                product_size.size_description
                              FROM
                                product_size_aggregation
                                INNER JOIN product_size ON (product_size_aggregation.aggregation_size = product_size.size_id)
                              WHERE
                                product_size_aggregation.aggregation_category = :category_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':category_id', $category_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectProductByType($type_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                product.product_id,
                                product_type.type_code,
                                product.product_code,
                                product.product_name
                              FROM
                                product
                                INNER JOIN product_type_aggregation ON (product.product_type = product_type_aggregation.aggregation_id)
                                INNER JOIN product_type ON (product_type_aggregation.aggregation_type = product_type.type_id) 
                              WHERE
                                product.product_type = :type_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':type_id', $type_id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveItemProduct($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        pruduct_item(
                        item_id,
                        item_product,
                        item_size,
                        item_stock,
                        item_price,
                        item_discount,
                        item_status,
                        item_entry,
                        item_entry_update)
                      VALUES(
                        (SELECT IF (
                            (SELECT COUNT(e.item_id) FROM pruduct_item AS e 
                                    WHERE e.item_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.item_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.item_id + 1 ) FROM pruduct_item AS e 
                                    WHERE e.item_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.item_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"0001")))
                        ),
                        :product,
                        :size,
                        :stock,
                        :price,
                        :discount,
                        :status,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':product', $param['product']);
        $sth->bindValue(':size', $param['size']);
        $sth->bindValue(':stock', $param['stock']);
        $sth->bindValue(':price', $param['price']);
        $sth->bindValue(':discount', $param['discount']);
        $sth->bindValue(':status', $param['status']);

        return $sth->execute();
    }

    public function updateProduct($param) {

        $sth = $this->db->prepare('
                      UPDATE
                        pruduct_item
                      SET
                        item_stock = :stock,
                        item_price = :price,
                        item_discount = :discount,
                        item_status = :status,
                        item_entry_update = NOW()
                      WHERE
                        pruduct_item.item_id = :id
                ');

        $sth->bindValue(':stock', $param['stock']);
        $sth->bindValue(':price', $param['price']);
        $sth->bindValue(':discount', $param['discount']);
        $sth->bindValue(':status', $param['status']);
        $sth->bindValue(':id', $param['id']);

        return $sth->execute();
    }

    public function deleteItemProduct($param) {
        $sth = $this->db->prepare('DELETE FROM pruduct_item WHERE pruduct_item.item_id IN (' . $param['id'] . ')');
        return $sth->execute();
    }

    public function selectItemProductById($product_id) {
        $sth = $this->db->prepare('
                             SELECT 
                                pruduct_item.item_id,
                                pruduct_item.item_product,
                                pruduct_item.item_size,
                                pruduct_item.item_stock,
                                pruduct_item.item_price,
                                pruduct_item.item_discount,
                                pruduct_item.item_status,
                                pruduct_item.item_entry,
                                pruduct_item.item_entry_update,
                                product.product_type,
                                product.product_code,
                                product.product_name,
                                product.product_description,
                                product_type.type_code,
                                product_type.type_name,
                                product_category.category_name,
                                product_size.size_description,
                                product_category.category_id,
                                product.product_id,
                                product_size_aggregation.aggregation_id AS size_id
                              FROM
                                pruduct_item
                                INNER JOIN product ON (pruduct_item.item_product = product.product_id)
                                INNER JOIN product_type_aggregation ON (product.product_type = product_type_aggregation.aggregation_id)
                                INNER JOIN product_type ON (product_type_aggregation.aggregation_type = product_type.type_id)
                                INNER JOIN product_category ON (product_type_aggregation.aggregation_category = product_category.category_id)
                                INNER JOIN product_size_aggregation ON (pruduct_item.item_size = product_size_aggregation.aggregation_id)
                                INNER JOIN product_size ON (product_size_aggregation.aggregation_size = product_size.size_id)
                              WHERE
                                pruduct_item.item_id = :product_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':product_id', $product_id);
        $sth->execute();
        return $sth->fetchAll();
    }

}