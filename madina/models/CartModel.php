<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CartModel
 *
 * @author WS
 */
class CartModel extends Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function selectKategori() {
        $sth = $this->db->prepare('SELECT 
                                    product_category.category_id,
                                    product_category.category_name,
                                    product_category.category_status,
                                    product_category.category_entry,
                                    product_category.category_entry_update
                                  FROM
                                    product_category');
        $sth->execute();
        return $sth->fetchAll();
    }
}

?>
