<?php

class BookSourceModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllBookFund($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_book_fund.book_fund_id,
            digilib_book_fund.book_fund_title,
            digilib_book_fund.book_fund_status,
            digilib_book_fund.book_fund_entry,
            digilib_book_fund.book_fund_entry_update";

        $prepare = 'SELECT ' . $listSelect . ' FROM digilib_book_fund';
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

    public function countAllBookFund() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(book_fund_id) AS cnt FROM digilib_book_fund';
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
                                digilib_book_fund.book_fund_id,
                                digilib_book_fund.book_fund_title,
                                digilib_book_fund.book_fund_status,
                                digilib_book_fund.book_fund_entry,
                                digilib_book_fund.book_fund_entry_update
                            FROM
                                digilib_book_fund
                            WHERE
                                digilib_book_fund.book_fund_id = :id');
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
                    digilib_book_fund(
                        book_fund_id,
                        book_fund_title,
                        book_fund_status,
                        book_fund_entry,
                        book_fund_entry_update)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dbf.book_fund_id) 
                             FROM digilib_book_fund AS dbf) > 0, 
                                (SELECT dbf.book_fund_id 
                                 FROM digilib_book_fund AS dbf 
                                 ORDER BY dbf.book_fund_id DESC LIMIT 1) + 1,
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
                        digilib_book_fund
                    SET
                        book_fund_title = :title,
                        book_fund_status = :status,
                        book_fund_entry_update = NOW()
                    WHERE
                        digilib_book_fund.book_fund_id = :id
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':status', $status);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id IN (' . $id . ')');
        return $sth->execute();
    }

}