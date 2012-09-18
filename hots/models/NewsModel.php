<?php

class NewsModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function selectAllNews() {
        $sth = $this->db->prepare('SELECT * FROM hots_news WHERE news_status=1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectNewsById($id) {
        $sth = $this->db->prepare('SELECT * FROM hots_news WHERE news_status=1 AND news_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function countAllNews() {
        $sth = $this->db->prepare('SELECT * FROM hots_news WHERE news_status=1');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }
    
}