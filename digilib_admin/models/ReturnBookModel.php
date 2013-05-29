<?php

class ReturnBookModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectBorrowTypeById($id) {
        $sth = $this->db->prepare(' SELECT 
                                        digilib_borrowed_type.borrowed_type_id,
                                        digilib_borrowed_type.borrowed_type_title,
                                        digilib_borrowed_type.borrowed_type_interval,
                                        digilib_borrowed_type.borrowed_type_max,
                                        digilib_borrowed_type.borrowed_type_entry,
                                        digilib_borrowed_type.borrowed_type_entry_update
                                    FROM
                                        digilib_borrowed_type
                                    WHERE digilib_borrowed_type.borrowed_type_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllBorrowed($page) {
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT 
                        digilib_borrowed_history.borrowed_history_id,
                        digilib_borrowed_history.borrowed_history_type,
                        digilib_borrowed_history.borrowed_history_members,
                        digilib_borrowed_history.borrowed_history_book,
                        digilib_borrowed_history.borrowed_history_star,
                        digilib_borrowed_history.borrowed_history_finish,
                        digilib_borrowed_history.borrowed_history_status,
                        digilib_borrowed_history.borrowed_history_return,
                        digilib_borrowed_history.borrowed_history_penalty,
                        digilib_book.book_id,
                        digilib_book.book_title,
                        digilib_book.book_foreign_title,
                        digilib_borrowed_type.borrowed_type_title,
                        digilib_members.members_name,
                        digilib_members.members_id,
                        digilib_ddc.ddc_classification_number,
                        digilib_publisher.publisher_name,
                        public_city.city_name,
                        digilib_book.book_publishing
                    FROM 
                        digilib_borrowed_history
                        INNER JOIN digilib_borrowed_type ON (digilib_borrowed_history.borrowed_history_type = digilib_borrowed_type.borrowed_type_id)
                        INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_members ON (digilib_borrowed_history.borrowed_history_members = digilib_members.members_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                    WHERE
                        digilib_borrowed_history.borrowed_history_status = 1 ';

        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllBorrowed() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(borrowed_history_id) AS cnt FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_status = 1 ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectBorrowedHistory($memberid, $page) {
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT
                        digilib_borrowed_history.borrowed_history_id,
                        digilib_borrowed_history.borrowed_history_type,
                        digilib_borrowed_history.borrowed_history_members,
                        digilib_borrowed_history.borrowed_history_book,
                        digilib_borrowed_history.borrowed_history_star,
                        digilib_borrowed_history.borrowed_history_finish,
                        digilib_borrowed_history.borrowed_history_status,
                        digilib_borrowed_history.borrowed_history_return,
                        digilib_book.book_id,
                        digilib_book.book_title,
                        digilib_borrowed_type.borrowed_type_title,
                        digilib_publisher.publisher_name,
                        public_city.city_name,
                        digilib_book.book_publishing,
                        digilib_book.book_foreign_title,
                        digilib_ddc.ddc_classification_number
                    FROM 
                        digilib_borrowed_history
                        INNER JOIN digilib_borrowed_type ON (digilib_borrowed_history.borrowed_history_type = digilib_borrowed_type.borrowed_type_id)
                        INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                    WHERE 
                        digilib_borrowed_history.borrowed_history_members = :memberid';

        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':memberid', $memberid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countBorrowedHistory($memberid) {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(borrowed_history_id) AS cnt FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_members = :memberid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':memberid', $memberid);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectReturnCart($memberid, $borrowtype, $page) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT
                        digilib_borrowed_return_temp.borrowed_return_temp_id,
                        digilib_borrowed_return_temp.borrowed_return_temp_history,
                        digilib_borrowed_return_temp.borrowed_return_temp_entry,
                        digilib_borrowed_history.borrowed_history_star,
                        digilib_borrowed_history.borrowed_history_finish,
                        digilib_book_register.book_register_id,
                        digilib_book.book_id,
                        digilib_book.book_title,
                        digilib_book.book_foreign_title,
                        digilib_publisher.publisher_name,
                        digilib_book.book_publishing,
                        public_city.city_name,
                        digilib_ddc.ddc_classification_number,
                        DATEDIFF(NOW(),digilib_borrowed_history.borrowed_history_finish) AS borrow_time
                    FROM 
                        digilib_borrowed_return_temp
                        INNER JOIN digilib_borrowed_history ON (digilib_borrowed_return_temp.borrowed_return_temp_history = digilib_borrowed_history.borrowed_history_id)
                        INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                    WHERE 
                        digilib_borrowed_history.borrowed_history_type = :borrowtype AND 
                        digilib_borrowed_history.borrowed_history_members = :memberid ';

        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':memberid', $memberid);
        $sth->bindValue(':borrowtype', $borrowtype);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countReturnCart($memberid, $borrowtype) {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(digilib_borrowed_return_temp.borrowed_return_temp_id) AS cnt 
                    FROM 
                        digilib_borrowed_return_temp
                        INNER JOIN digilib_borrowed_history ON (digilib_borrowed_return_temp.borrowed_return_temp_history = digilib_borrowed_history.borrowed_history_id)
                        INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                    WHERE 
                        digilib_borrowed_history.borrowed_history_type = :borrowtype AND 
                        digilib_borrowed_history.borrowed_history_members = :memberid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':memberid', $memberid);
        $sth->bindValue(':borrowtype', $borrowtype);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectMemberInfo($id) {
        $sth = $this->db->prepare(' SELECT 
                                        digilib_members.members_id,
                                        digilib_members.members_name,
                                        digilib_members.members_gender,
                                        digilib_members.members_birthplace,
                                        digilib_members.members_birthdate,
                                        digilib_members.members_address,
                                        digilib_members.members_phone1,
                                        digilib_members.members_phone2,
                                        digilib_members.members_email,
                                        digilib_members.members_photo,
                                        digilib_members.members_isa,
                                        digilib_members.members_desc,
                                        digilib_members.members_status,
                                        digilib_members.members_entry,
                                        digilib_members.members_entry_update,
                                        public_gender.gender_title,
                                        digilib_isa.isa_title
                                    FROM
                                        digilib_members
                                        INNER JOIN public_gender ON (digilib_members.members_gender = public_gender.gender_id)
                                        INNER JOIN digilib_isa ON (digilib_members.members_isa = digilib_isa.isa_id)
                                    WHERE
                                        digilib_members.members_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectBookInfo($id, $type, $memberid) {
        $sth = $this->db->prepare(' SELECT 
                                        digilib_borrowed_history.borrowed_history_id,
                                        digilib_borrowed_history.borrowed_history_type,
                                        digilib_borrowed_history.borrowed_history_members,
                                        digilib_borrowed_history.borrowed_history_book,
                                        digilib_borrowed_history.borrowed_history_star,
                                        digilib_borrowed_history.borrowed_history_finish,
                                        digilib_borrowed_history.borrowed_history_status,
                                        digilib_borrowed_history.borrowed_history_return
                                    FROM
                                        digilib_borrowed_history
                                    WHERE
                                        digilib_borrowed_history.borrowed_history_status = 0 AND
                                        digilib_borrowed_history.borrowed_history_book = :id AND 
                                        digilib_borrowed_history.borrowed_history_members = :memberid AND 
                                        digilib_borrowed_history.borrowed_history_type = :type ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->bindValue(':memberid', $memberid);
        $sth->bindValue(':type', $type);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function clearReturnCart($id) {

        $borrowingcart = $this->selectReturnCartByMemberId($id);
        $tempid = '0';
        foreach ($borrowingcart as $value) {
            $tempid .= ',' . $value['borrowed_return_temp_id'];
        }

        $sth = $this->db->prepare('DELETE
                                    FROM
                                        digilib_borrowed_return_temp
                                    WHERE
                                        digilib_borrowed_return_temp.borrowed_return_temp_id IN (' . $tempid . ')');
        return $sth->execute();
    }

    public function deleteBorrowHistory() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function deleteReturnCart() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE
                                    FROM
                                        digilib_borrowed_return_temp
                                    WHERE
                                        digilib_borrowed_return_temp.borrowed_return_temp_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function saveAddBookCart($borrowid) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_borrowed_return_temp(
                        borrowed_return_temp_id,
                        borrowed_return_temp_history,
                        borrowed_return_temp_entry)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dbrt.borrowed_return_temp_id) 
                             FROM digilib_borrowed_return_temp AS dbrt) > 0, 
                                (SELECT dbrt.borrowed_return_temp_id 
                                 FROM digilib_borrowed_return_temp AS dbrt 
                                 ORDER BY dbrt.borrowed_return_temp_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :borrowid,
                        NOW()
                  )');
        $sth->bindValue(':borrowid', $borrowid);
        $sth->execute();
    }

    public function countCartListByBookRegister($bookregister) {
        $prepare = 'SELECT COUNT(borrowed_temp_book) AS cnt FROM digilib_borrowed_temp WHERE digilib_borrowed_temp.borrowed_temp_book = :bookregister ';
        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':bookregister', $bookregister);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectReturnCartByMemberId($memberid) {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_borrowed_return_temp.borrowed_return_temp_id,
                                    digilib_borrowed_history.borrowed_history_book,
                                    digilib_borrowed_history.borrowed_history_id,
                                    digilib_borrowed_history.borrowed_history_members,
                                    digilib_borrowed_history.borrowed_history_type,
                                    digilib_borrowed_history.borrowed_history_star,
                                    digilib_borrowed_history.borrowed_history_finish,
                                    digilib_book.book_title,
                                    DATEDIFF(NOW(), digilib_borrowed_history.borrowed_history_finish) AS borrow_time,
                                    digilib_book.book_foreign_title,
                                    digilib_book.book_publishing,
                                    digilib_ddc.ddc_classification_number,
                                    digilib_book.book_id,
                                    digilib_publisher.publisher_name,
                                    public_city.city_name,
                                    DATEDIFF(NOW(),digilib_borrowed_history.borrowed_history_finish) AS borrow_time
                                  FROM
                                    digilib_borrowed_return_temp
                                    INNER JOIN digilib_borrowed_history ON (digilib_borrowed_return_temp.borrowed_return_temp_history = digilib_borrowed_history.borrowed_history_id)
                                    INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id)
                                    INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                                    INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                                    INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                                    INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                                    INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                                  WHERE
                                    digilib_borrowed_history.borrowed_history_members =  :memberid
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':memberid', $memberid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveReturnCart($id = 0, $pinalty = 0) {
        $sth = $this->db->prepare('UPDATE
                                        digilib_borrowed_history
                                    SET
                                        borrowed_history_status = 1,
                                        borrowed_history_penalty = :pinalty,
                                        borrowed_history_return = NOW()
                                    WHERE
                                        digilib_borrowed_history.borrowed_history_id = :id
                                  ');
        $sth->bindValue(':pinalty', $pinalty);
        $sth->bindValue(':id', $id);
        return $sth->execute();
    }

    public function deleteSave() {
        $id = $this->method->post('id');
        $sth = $this->db->prepare('UPDATE
                                        digilib_borrowed_history
                                    SET
                                        borrowed_history_status = 0
                                    WHERE
                                        digilib_borrowed_history.borrowed_history_id IN (' . $id . ')
                                  ');
        return $sth->execute();
    }

}