<?php

class AuthorDescriptionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllAuthorDescription($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_author_description.author_description_id,
            digilib_author_description.author_description_title,
            digilib_author_description.author_description_level,
            digilib_author_description.author_description_entry,
            digilib_author_description.author_description_entry_update";

        $prepare = 'SELECT ' . $listSelect . ' FROM digilib_author_description';
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

    public function countAllAuthorDescription() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(author_description_id) AS cnt FROM digilib_author_description';
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
                                author_description_id,
                                author_description_title,
                                author_description_level,
                                author_description_entry,
                                author_description_entry_update
                            FROM
                                digilib_author_description
                            WHERE
                                digilib_author_description.author_description_id = :id');
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
        $level = $this->method->post('level');

        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_author_description(
                        author_description_id,
                        author_description_title,
                        author_description_level,
                        author_description_entry,
                        author_description_entry_update)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dad.author_description_id) 
                             FROM digilib_author_description AS dad) > 0, 
                                (SELECT dad.author_description_id 
                                 FROM digilib_author_description AS dad 
                                 ORDER BY dad.author_description_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :title,
                        :level,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':level', $level);

        return $sth->execute();
    }

    public function updateSave($id = 0) {

        $title = $this->method->post('title');
        $level = $this->method->post('level');

        $sth = $this->db->prepare('
                    UPDATE
                        digilib_author_description
                    SET
                        author_description_title = :title,
                        author_description_level = :level,
                        author_description_entry_update = NOW()
                    WHERE
                        digilib_author_description.author_description_id = :id
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':level', $level);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_author_description WHERE digilib_author_description.author_description_id IN (' . $id . ')');
        return $sth->execute();
    }

}