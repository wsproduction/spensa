<?php

class BorrowModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllLanguage($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            public_language.language_id,
            public_language.language_name,
            public_language.language_status,
            public_language.language_entry,
            public_language.language_entry_update";

        $prepare = 'SELECT ' . $listSelect . ' FROM public_language';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllLanguage() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(language_id) AS cnt FROM public_language';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                public_language.language_id,
                                public_language.language_name,
                                public_language.language_status,
                                public_language.language_entry,
                                public_language.language_entry_update
                            FROM
                                public_language
                            WHERE
                                public_language.language_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function createSave() {

        $title = $this->method->post('title');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('
                    INSERT INTO
                    public_language(
                        language_id,
                        language_name,
                        language_status,
                        language_entry,
                        language_entry_update)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(pl.language_id) 
                             FROM public_language AS pl) > 0, 
                                (SELECT pl.language_id 
                                 FROM public_language AS pl 
                                 ORDER BY pl.language_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :title,
                        :status,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':status', $status);

        return $sth->execute();
    }

    public function updateSave($id = 0) {

        $title = $this->method->post('title');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('
                    UPDATE
                        public_language
                    SET
                        language_name = :title,
                        language_status = :status,
                        language_entry_update = NOW()
                    WHERE
                        public_language.language_id = :id
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':status', $status);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM public_language WHERE public_language.language_id IN (' . $id . ')');
        return $sth->execute();
    }
    
    public function selectAllBorrowType() {
        $sth = $this->db->prepare(' SELECT 
                                        digilib_borrowed_type.borrowed_type_id,
                                        digilib_borrowed_type.borrowed_type_title
                                    FROM
                                        digilib_borrowed_type');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}