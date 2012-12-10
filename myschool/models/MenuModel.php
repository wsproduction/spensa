<?php

class MenuModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectPage() {
        $sth = $this->db->prepare('
                                SELECT 
                                    myschool_apps.apps_id,
                                    myschool_apps.apps_alias,
                                    myschool_apps.apps_name,
                                    myschool_apps.apps_short_description,
                                    myschool_apps.apps_baner,
                                    myschool_apps.apps_status,
                                    myschool_apps.apps_entry,
                                    myschool_apps.apps_entry_update
                                FROM
                                    myschool_apps
                                WHERE
                                    myschool_apps.apps_status = 1
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}