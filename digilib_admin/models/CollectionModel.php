<?php

class CollectionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllCollection($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT 
                        digilib_book_register.book_register_id,
                        digilib_book_register.book_id,
                        digilib_book_register.book_entry,
                        digilib_book_condition.book_condition,
                        digilib_book_register.book_count_barcode_print,
                        (SELECT COUNT(dbh.borrowed_history_id) AS FIELD_1 FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_book = digilib_book_register.book_register_id) AS total_borrowed,
                        (SELECT dbh.borrowed_history_star FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_book = digilib_book_register.book_register_id ORDER BY dbh.borrowed_history_star DESC LIMIT 1) AS last_borrowed,
                        digilib_book.book_title,
                        digilib_book.book_foreign_title,
                        digilib_book.book_publishing,
                        digilib_ddc.ddc_classification_number,
                        digilib_publisher.publisher_name,
                        public_city.city_name,
                        (SELECT digilib_book_fund.book_fund_title FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id = digilib_book.book_fund) AS fund,
                        (SELECT digilib_book_resource.book_resource_title FROM digilib_book_resource WHERE digilib_book_resource.book_resource_id = digilib_book.book_resource) AS resource
                      FROM
                        digilib_book_register
                        INNER JOIN digilib_book_condition ON (digilib_book_register.book_condition = digilib_book_condition.book_condition_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                    ';

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

    public function saveTempPrintBarcode($bookid = 0, $sessionid = 0) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_book_temp_barcodeprint(
                        book_temp_barcodeprint,
                        book_temp_barcodeprint_register,
                        book_temp_barcodeprint_session)
                      VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dbtb.book_temp_barcodeprint) 
                            FROM digilib_book_temp_barcodeprint AS dbtb) > 0, 
                                (SELECT dbtb.book_temp_barcodeprint 
                                FROM digilib_book_temp_barcodeprint AS dbtb 
                                ORDER BY dbtb.book_temp_barcodeprint DESC LIMIT 1) + 1,
                            1)
                        ),
                        :book_id,
                        :session_id)
                    ');
        $sth->bindValue(':book_id', $bookid);
        $sth->bindValue(':session_id', $sessionid);
        return $sth->execute();
    }

    public function countAllCollection() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT 
                        COUNT(book_register_id) AS cnt 
                    FROM 
                        digilib_book_register
                        INNER JOIN digilib_book_condition ON (digilib_book_register.book_condition = digilib_book_condition.book_condition_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectPrintListBarcode($page = 1) {
        Session::init();
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT 
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint,
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint_register,
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint_session,
                        digilib_book_register.book_register_id,
                        digilib_book_register.book_id,
                        digilib_book_register.book_entry,
                        digilib_book_condition.book_condition,
                        digilib_book_register.book_count_barcode_print,
                        (SELECT COUNT(dbh.borrowed_history_id) AS FIELD_1 FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_book = digilib_book_register.book_register_id) AS total_borrowed,
                        (SELECT dbh.borrowed_history_star FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_book = digilib_book_register.book_register_id ORDER BY dbh.borrowed_history_star DESC LIMIT 1) AS last_borrowed,
                        digilib_book.book_title,
                        digilib_book.book_foreign_title,
                        digilib_book.book_publishing,
                        digilib_ddc.ddc_classification_number,
                        digilib_publisher.publisher_name,
                        public_city.city_name,
                        (SELECT digilib_book_fund.book_fund_title FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id = digilib_book.book_fund) AS fund,
                        (SELECT digilib_book_resource.book_resource_title FROM digilib_book_resource WHERE digilib_book_resource.book_resource_id = digilib_book.book_resource) AS resource
                      FROM
                        digilib_book_temp_barcodeprint
                        INNER JOIN digilib_book_register ON (digilib_book_temp_barcodeprint.book_temp_barcodeprint_register = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                        INNER JOIN digilib_book_condition ON (digilib_book_register.book_condition = digilib_book_condition.book_condition_id)
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                      WHERE
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint_session = :session ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':session', Session::id());
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countPrintListBarcode() {
        Session::init();
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(book_temp_barcodeprint) AS cnt FROM digilib_book_temp_barcodeprint WHERE digilib_book_temp_barcodeprint.book_temp_barcodeprint_session = :session';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':session', Session::id());
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function deletePrintListBarcodeAll() {
        Session::init();
        $sth = $this->db->prepare('DELETE FROM digilib_book_temp_barcodeprint WHERE digilib_book_temp_barcodeprint.book_temp_barcodeprint_session = :sessionid');
        $sth->bindValue(':sessionid', Session::id());
        return $sth->execute();
    }

    public function selectPrintBarcodeList() {
        Session::init();
        $prepare = 'SELECT 
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint,
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint_register,
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint_session,
                        digilib_book.book_title
                      FROM
                        digilib_book_temp_barcodeprint
                        INNER JOIN digilib_book_register ON (digilib_book_temp_barcodeprint.book_temp_barcodeprint_register = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
                      WHERE
                        digilib_book_temp_barcodeprint.book_temp_barcodeprint_session = :session ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':session', Session::id());
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function updateCountBarcodePrint($id) {
        Session::init();
        $prepare = 'UPDATE
                        digilib_book_register
                      SET
                        book_count_barcode_print = book_count_barcode_print + 1
                      WHERE
                        digilib_book_register.book_register_id IN (' . $id . ')';

        $sth = $this->db->prepare($prepare);
        return $sth->execute();
    }

}