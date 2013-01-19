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
                                        public_menu.is_active = 1
                                   ORDER BY 
                                        public_menu.menu_order ASC
                                   ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':web' => $web, ':group' => $group));
        return $sth->fetchAll();
    }
    
    public function selectAuthorByBookID($bookid = 0) {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_author.author_firstname,
                                digilib_author.author_lastname,
                                digilib_author_description.author_description_title,
                                digilib_author_description.author_description_id
                              FROM
                                digilib_book_aurthor
                                INNER JOIN digilib_author ON (digilib_book_aurthor.book_aurthor_name = digilib_author.author_id)
                                INNER JOIN digilib_author_description ON (digilib_author.author_description = digilib_author_description.author_description_id)
                              WHERE
                                digilib_book_aurthor.book_aurthor_book = :bookid
                              ORDER BY
                                digilib_author_description.author_description_level');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':bookid', $bookid);
        $sth->execute();
        return $sth->fetchAll();
    }
}