<?php

class OrdersModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllProduct($param) {
        $prepare = ' SELECT 
                        orders.order_id,
                        orders.order_note,
                        orders.order_status,
                        orders.order_entry,
                        orders.order_entry_update,
                        orders.payment_status,
                        orders.payment_note,
                        orders.shipping_status,
                        orders.shipping_address,
                        orders.shipping_date,
                        orders.shipping_courier,
                        orders.shipping_cost,
                        members.members_id,
                        members.members_name,
                        payment_type.payment_type_name,
                        payment_type.payment_type_id,
                        ( SELECT 
                            AVG(order_detail.detail_price - (order_detail.detail_price * (order_detail.detail_discount/100))) AS a
                          FROM
                            order_detail
                          WHERE
                            order_detail.detail_order = orders.order_id ) AS invoice
                      FROM
                        orders
                        INNER JOIN members ON (orders.order_members = members.members_id)
                        INNER JOIN payment_type ON (orders.payment_type = payment_type.payment_type_id)';

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

    public function selectAllCart($param) {
        $sth = $this->db->prepare('
                             SELECT 
                                order_detail.detail_id,
                                order_detail.detail_order,
                                order_detail.detail_item,
                                order_detail.detail_price,
                                order_detail.detail_discount,
                                order_detail.detail_order_quantity,
                                order_detail.detail_ready_quantity,
                                order_detail.detail_status,
                                product.product_code,
                                product.product_name,
                                product.product_description,
                                product_size.size_description,
                                product_type.type_code,
                                product_type.type_name
                              FROM
                                order_detail
                                INNER JOIN pruduct_item ON (order_detail.detail_item = pruduct_item.item_id)
                                INNER JOIN product ON (pruduct_item.item_product = product.product_id)
                                INNER JOIN product_type_aggregation ON (product.product_type = product_type_aggregation.aggregation_id)
                                INNER JOIN product_size_aggregation ON (pruduct_item.item_size = product_size_aggregation.aggregation_id)
                                INNER JOIN product_size ON (product_size_aggregation.aggregation_size = product_size.size_id)
                                INNER JOIN product_type ON (product_type_aggregation.aggregation_type = product_type.type_id)
                              WHERE
                                order_detail.detail_order = :order_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':order_id', $param['order_id']);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectOrderById($id) {
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
                                product.product_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }
}