<?php

class ContentsModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectMenu($web = 0, $group = 0) {
        $sth = $this->db->prepare('SELECT *
                                    FROM
                                   public_menu
                                    WHERE
                                   public_menu.web_id = :web AND 
                                   public_menu.menu_group = :group AND 
                                   public_menu.is_active = 1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':web' => $web, ':group' => $group));
        return $sth->fetchAll();
    }

}