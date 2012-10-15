<?php

class MenuModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectPage() {
        $sth = $this->db->prepare('SELECT 
                                        myschool_page.page_name,
                                        myschool_page.page_alias
                                    FROM
                                        myschool_page
                                    WHERE
                                        myschool_page.page_status = 1
                                    ORDER BY
                                        myschool_page.page_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}