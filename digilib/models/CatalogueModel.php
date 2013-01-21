<?php

class CatalogueModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllCatalogue($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'book_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT 
                        digilib_book.book_id,
                        CONCAT_WS(" / ", digilib_book.book_title, digilib_book.book_foreign_title) AS book_title,
                        digilib_book.book_publisher,
                        digilib_book.book_publishing,
                        digilib_book.book_edition,
                        digilib_book.book_copy,
                        digilib_book.book_isbn,
                        digilib_book.book_roman_number,
                        digilib_book.book_pages_number,
                        digilib_book.book_bibliography,
                        digilib_book.book_ilustration,
                        digilib_book.book_index,
                        digilib_book.book_width,
                        digilib_book.book_height,
                        digilib_book.book_weight,
                        digilib_book.book_accounting_symbol,
                        digilib_book.book_price,
                        digilib_book.book_resource,
                        digilib_book.book_fund,
                        digilib_book.book_review,
                        digilib_book.book_classification,
                        digilib_book.book_cover,
                        digilib_book.book_file,
                        digilib_book.book_entry,
                        digilib_book.book_entry_update,
                        digilib_ddc.ddc_classification_number,
                        (SELECT COUNT(digilib_book_register.book_register_id) AS FIELD_1 FROM digilib_book_register WHERE digilib_book_register.book_id = digilib_book.book_id) AS book_quantity,
                        (SELECT digilib_book_fund.book_fund_title FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id = digilib_book.book_fund) AS fund,
                        (SELECT digilib_book_resource.book_resource_title FROM digilib_book_resource WHERE digilib_book_resource.book_resource_id = digilib_book.book_resource) AS resource,
                        (SELECT COUNT(digilib_book_register.book_id) AS FIELD_1 FROM digilib_borrowed_history INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id) WHERE digilib_book_register.book_id = digilib_book.book_id) AS count_borrowed,
                        digilib_publisher.publisher_name,
                        public_city.city_name,
                        (SELECT 
                                        COUNT(digilib_book_register.book_register_id) AS FIELD_1
                                      FROM
                                        digilib_borrowed_history
                                        INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id)
                                      WHERE
                                        digilib_book_register.book_id = digilib_book.book_id
                        ) AS borrow_count
                      FROM
                        digilib_book
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)';

        if ($query) {
            $prepare .= $this->condition($qtype, $query);
        }

        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllCollection($id = 0, $page = 1) {

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
                        (SELECT COUNT(dbh.borrowed_history_id) FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_book = digilib_book_register.book_register_id) AS total_borrowed,
                        (SELECT dbh.borrowed_history_star FROM digilib_borrowed_history dbh WHERE dbh.borrowed_history_book = digilib_book_register.book_register_id ORDER BY dbh.borrowed_history_star DESC LIMIT 1) AS last_borrowed
                    FROM 
                        digilib_book_register
                        INNER JOIN digilib_book_condition ON (digilib_book_register.book_condition = digilib_book_condition.book_condition_id) 
                    WHERE
                        digilib_book_register.book_id = :id ';

        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':id', $id);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT *
                            FROM
                                digilib_book
                            WHERE
                                digilib_book.book_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function countAllCatalogue() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT
                        COUNT(book_id) AS cnt 
                    FROM 
                        digilib_book
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)';
        if ($query)
            $prepare .= $this->condition($qtype, $query);

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function countAllCollection($id = 0) {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(book_register_id) AS cnt FROM digilib_book_register WHERE digilib_book_register.book_id = :id ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':id', $id);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function condition($qtype, $query) {
        switch ($qtype) {
            case 'book_title':
                $new_condition = ' WHERE book_title LIKE "%' . $query . '%" ' . ' OR book_foreign_title LIKE "%' . $query . '%" ';
                break;

            default:
                $new_condition = '';
                break;
        }
        return $new_condition;
    }
    
    public function selectBookById($id = 0) {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_book.book_id,
                                digilib_book.book_title,
                                digilib_book.book_foreign_title,
                                digilib_book.book_publisher,
                                digilib_book.book_publishing,
                                digilib_book.book_edition,
                                digilib_book.book_copy,
                                digilib_book.book_isbn,
                                digilib_book.book_roman_number,
                                digilib_book.book_pages_number,
                                digilib_book.book_bibliography,
                                digilib_book.book_ilustration,
                                digilib_book.book_index,
                                digilib_book.book_width,
                                digilib_book.book_height,
                                digilib_book.book_weight,
                                digilib_book.book_accounting_symbol,
                                digilib_book.book_price,
                                digilib_book.book_resource,
                                digilib_book.book_fund,
                                digilib_book.book_review,
                                digilib_book.book_classification,
                                digilib_book.book_cover,
                                digilib_book.book_file,
                                digilib_book.book_entry,
                                digilib_book.book_entry_update,
                                digilib_ddc.ddc_classification_number,
                                digilib_ddc.ddc_title,
                                digilib_ddc.ddc_parent,
                                (SELECT pas.accounting_symbol FROM public_accounting_symbol pas WHERE pas.accounting_symbol_id = digilib_book.book_accounting_symbol) AS accounting_symbol,
                                (SELECT COUNT(digilib_book_register.book_register_id) AS FIELD_1 FROM digilib_book_register WHERE digilib_book_register.book_id = digilib_book.book_id) AS book_quantity,
                                (SELECT digilib_book_fund.book_fund_title FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id = digilib_book.book_fund) AS fund,
                                (SELECT digilib_book_resource.book_resource_title FROM digilib_book_resource WHERE digilib_book_resource.book_resource_id = digilib_book.book_resource) AS resource,
                                (SELECT COUNT(digilib_book_register.book_id) AS FIELD_1 FROM digilib_borrowed_history INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id) WHERE digilib_book_register.book_id = digilib_book.book_id) AS count_borrowed
                              FROM
                                digilib_book
                                INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                            WHERE
                                digilib_book.book_id IN (' . $id . ')
                        ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectBookLanguageByBookId($bookid = 0) {
        $prepare = 'SELECT 
                        public_language.language_name
                      FROM
                        digilib_book_language
                        INNER JOIN public_language ON (digilib_book_language.book_language = public_language.language_id)
                      WHERE
                        digilib_book_language.book_id = :bookid ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':bookid', $bookid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectDdcParent($ddcid = 0) {
        $prepare = ' SELECT 
                        ddc2.ddc_classification_number AS cn2,
                        ddc2.ddc_title AS sub_class,
                        (SELECT ddc1.ddc_classification_number FROM digilib_ddc ddc1 WHERE ddc1.ddc_id = ddc2.ddc_parent) AS cn1,
                        (SELECT ddc1.ddc_title FROM digilib_ddc ddc1 WHERE ddc1.ddc_id = ddc2.ddc_parent) AS main_class
                      FROM
                        digilib_ddc ddc2
                      WHERE
                      ddc2.ddc_id = :ddcid ';

        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':ddcid', $ddcid);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}