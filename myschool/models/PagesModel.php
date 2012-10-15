<?php

class PagesModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectPagesByAlias($alias) {
        $sth = $this->db->prepare('SELECT 
                                        myschool_page.page_name,
                                        myschool_page.page_alias,
                                        myschool_page.page_short_description
                                    FROM
                                        myschool_page
                                    WHERE
                                        myschool_page.page_status = 1 AND
                                        myschool_page.page_alias = :alias
                                    ORDER BY
                                        myschool_page.page_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':alias', $alias);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectPagesMenuByAlias($alias) {
        $sth = $this->db->prepare('SELECT 
                                        myschool_menu.menu_id,
                                        myschool_menu.menu_pages,
                                        myschool_menu.menu_title,
                                        myschool_menu.menu_link,
                                        myschool_menu.menu_level,
                                        myschool_menu.menu_parent,
                                        myschool_menu.menu_status,
                                        myschool_menu.menu_entry,
                                        myschool_menu.menu_entry_update
                                    FROM
                                        myschool_menu
                                        INNER JOIN myschool_page ON (myschool_menu.menu_pages = myschool_page.page_id)
                                    WHERE
                                        myschool_menu.menu_status = 1 AND
                                        myschool_page.page_alias = :alias');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':alias', $alias);
        $sth->execute();
        return $sth->fetchAll();
    }

}