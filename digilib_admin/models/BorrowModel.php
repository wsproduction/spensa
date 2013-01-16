<?php

class BorrowModel extends Model {

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
                        digilib_borrowed_history.borrowed_history_status = 0
                    ';        
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

        $prepare = 'SELECT 
                        COUNT(borrowed_history_id) AS cnt 
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
                        digilib_borrowed_history.borrowed_history_status = 0';
        
        
        if ($qtype=='book_title')
            $qtype = 'digilib_book.book_title';
        
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

    public function selectBorrowedCart($memberid, $borrowtype, $page) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = ' SELECT 
                        digilib_borrowed_temp.borrowed_temp_id,
                        digilib_borrowed_temp.borrowed_temp_type,
                        digilib_borrowed_temp.borrowed_temp_book,
                        digilib_borrowed_temp.borrowed_temp_member,
                        digilib_borrowed_temp.borrowed_temp_start,
                        digilib_borrowed_temp.borrowed_temp_finish,
                        digilib_book.book_id,
                        digilib_book.book_title,
                        digilib_book.book_foreign_title,
                        digilib_publisher.publisher_name,
                        digilib_book.book_publisher,
                        public_city.city_name,
                        digilib_book.book_publishing,
                        digilib_ddc.ddc_classification_number
                      FROM
                        digilib_borrowed_temp
                        INNER JOIN digilib_book_register ON (digilib_borrowed_temp.borrowed_temp_book = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                     WHERE 
                        digilib_borrowed_temp.borrowed_temp_member = :memberid AND 
                        digilib_borrowed_temp.borrowed_temp_type = :borrowtype ';

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

    public function countBorrowedCart($memberid, $borrowtype) {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(digilib_borrowed_temp.borrowed_temp_id) AS cnt 
                    FROM 
                        digilib_borrowed_temp
                        INNER JOIN digilib_book_register ON (digilib_borrowed_temp.borrowed_temp_book = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                    WHERE digilib_borrowed_temp.borrowed_temp_member = :memberid AND digilib_borrowed_temp.borrowed_temp_type = :borrowtype ';
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
                                        digilib_isa.isa_title,
                                        (SELECT COUNT(dbh.borrowed_history_id) FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_type = 1 AND dbh.borrowed_history_status = 0 AND dbh.borrowed_history_members = digilib_members.members_id) AS temporer_status
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

    public function selectBookInfo($id) {
        $sth = $this->db->prepare(' SELECT 
                                        digilib_book_register.book_register_id,
                                        digilib_book_register.book_id,
                                        digilib_book_register.book_condition,
                                        digilib_book_register.book_entry
                                    FROM
                                        digilib_book_register
                                    WHERE
                                        digilib_book_register.book_register_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function clearBorrowedCart($id) {
        $sth = $this->db->prepare('DELETE FROM digilib_borrowed_temp WHERE digilib_borrowed_temp.borrowed_temp_member = :memberid');
        $sth->bindValue(':memberid', $id);
        return $sth->execute();
    }

    public function deleteBorrowHistory() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_borrowed_history WHERE digilib_borrowed_history.borrowed_history_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function deleteBorrowCart() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_borrowed_temp WHERE digilib_borrowed_temp.borrowed_temp_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function saveAddBookCart($interval) {
        $bookregister = $this->method->post('bookregister');
        $borrowedtype = $this->method->post('borrowedtype');
        $memberidtemp = $this->method->post('memberidtemp');
        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_borrowed_temp(
                        borrowed_temp_id,
                        borrowed_temp_type,
                        borrowed_temp_book,
                        borrowed_temp_member,
                        borrowed_temp_start,
                        borrowed_temp_finish
                        )
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dbt.borrowed_temp_id) 
                             FROM digilib_borrowed_temp AS dbt) > 0, 
                                (SELECT dbt.borrowed_temp_id 
                                 FROM digilib_borrowed_temp AS dbt 
                                 ORDER BY dbt.borrowed_temp_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :borrowedtype,
                        :bookregister,
                        :memberid,
                        NOW(),
                        DATE_ADD(NOW(),INTERVAL ' . $interval . ' DAY)
                )');
        $sth->bindValue(':borrowedtype', $borrowedtype);
        $sth->bindValue(':bookregister', $bookregister);
        $sth->bindValue(':memberid', $memberidtemp);
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

    public function selectBorrowingCartByMemberId($memberid) {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_borrowed_temp.borrowed_temp_id,
                                    digilib_borrowed_temp.borrowed_temp_type,
                                    digilib_borrowed_temp.borrowed_temp_book,
                                    digilib_borrowed_temp.borrowed_temp_member,
                                    digilib_borrowed_temp.borrowed_temp_start,
                                    digilib_borrowed_temp.borrowed_temp_finish,
                                    digilib_book.book_id,
                                    digilib_book.book_title,
                                    digilib_book.book_foreign_title,
                                    digilib_book.book_publishing,
                                    digilib_publisher.publisher_name,
                                    public_city.city_name,
                                    digilib_ddc.ddc_classification_number
                                FROM
                                    digilib_borrowed_temp
                                    INNER JOIN digilib_book_register ON (digilib_borrowed_temp.borrowed_temp_book = digilib_book_register.book_register_id)
                                    INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                                    INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                                    INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                                    INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                                    INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                                WHERE
                                    digilib_borrowed_temp.borrowed_temp_member = :memberid
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':memberid', $memberid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveBorrowingCart($cart) {
        $prepare = '
                    INSERT INTO
                        digilib_borrowed_history(
                        borrowed_history_id,
                        borrowed_history_type,
                        borrowed_history_members,
                        borrowed_history_book,
                        borrowed_history_star,
                        borrowed_history_finish,
                        borrowed_history_status,
                        borrowed_history_return)
                    VALUES';
        $idx = count($cart);
        foreach ($cart as $rowcart) {
            $prepare .= '(  (SELECT IF(
                                (SELECT COUNT(dbh.borrowed_history_id) 
                                FROM digilib_borrowed_history AS dbh) > 0, 
                                    (SELECT dbh.borrowed_history_id 
                                    FROM digilib_borrowed_history AS dbh 
                                    ORDER BY dbh.borrowed_history_id DESC LIMIT 1) + 1,
                                1)
                            ),
                            "' . $rowcart['borrowed_temp_type'] . '",
                            "' . $rowcart['borrowed_temp_member'] . '",
                            "' . $rowcart['borrowed_temp_book'] . '",
                            "' . $rowcart['borrowed_temp_start'] . '",
                            "' . $rowcart['borrowed_temp_finish'] . '",
                            0,
                            NULL)';

            $idx--;
            if ($idx != 0) {
                $prepare .= ',';
            }
        }
        $sth = $this->db->prepare($prepare);
        return $sth->execute();
    }
    
    public function selectBookBorrowedStatus($bookregister = 0) {
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
                                        digilib_borrowed_history.borrowed_history_book = :bookregister AND 
                                        digilib_borrowed_history.borrowed_history_status = 0');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':bookregister', $bookregister);
        $sth->execute();
        return $sth->fetchAll();
    }

}