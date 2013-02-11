<?php

class AppsModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAppsByAlias($alias) {
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
                                        myschool_apps.apps_alias = :alias AND 
                                        myschool_apps.apps_status = 1
                                    LIMIT 1
                                ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':alias', $alias);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAppsMenuByAlias($apps_id) {
        $sth = $this->db->prepare('
                            SELECT 
                                myschool_apps_menu.menu_id,
                                myschool_apps_menu.menu_apps,
                                myschool_apps_menu.menu_title,
                                myschool_apps_menu.menu_link,
                                myschool_apps_menu.menu_level,
                                myschool_apps_menu.menu_parent,
                                myschool_apps_menu.menu_icons,
                                myschool_apps_menu.menu_status,
                                myschool_apps_menu.menu_entry,
                                myschool_apps_menu.menu_entry_update
                            FROM
                                myschool_apps_menu
                            WHERE
                                myschool_apps_menu.menu_status = 1 AND 
                                myschool_apps_menu.menu_apps = :apps_id
                        ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':apps_id', $apps_id);
        $sth->execute();
        return $sth->fetchAll();
    }

}