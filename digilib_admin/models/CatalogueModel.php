<?php

class CatalogueModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllCatalogue($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT 
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
                        (SELECT COUNT(digilib_book_register.book_register_id) AS FIELD_1 FROM digilib_book_register WHERE digilib_book_register.book_id = digilib_book.book_id) AS book_quantity,
                        (SELECT digilib_book_fund.book_fund_title FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id = digilib_book.book_fund) AS fund,
                        (SELECT digilib_book_resource.book_resource_title FROM digilib_book_resource WHERE digilib_book_resource.book_resource_id = digilib_book.book_resource) AS resource,
                        (SELECT COUNT(digilib_book_register.book_id) AS FIELD_1 FROM digilib_borrowed_history INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id) WHERE digilib_book_register.book_id = digilib_book.book_id) AS count_borrowed,
                        digilib_publisher.publisher_name,
                        public_city.city_name
                      FROM
                        digilib_book
                        INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                        INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)';
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
                                (SELECT COUNT(digilib_book_register.book_register_id) AS FIELD_1 FROM digilib_book_register WHERE digilib_book_register.book_id = digilib_book.book_id) AS book_quantity,
                                (SELECT digilib_book_fund.book_fund_title FROM digilib_book_fund WHERE digilib_book_fund.book_fund_id = digilib_book.book_fund) AS fund,
                                (SELECT digilib_book_resource.book_resource_title FROM digilib_book_resource WHERE digilib_book_resource.book_resource_id = digilib_book.book_resource) AS resource,
                                (SELECT COUNT(digilib_book_register.book_id) AS FIELD_1 FROM digilib_borrowed_history INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id) WHERE digilib_book_register.book_id = digilib_book.book_id) AS count_borrowed,
                                digilib_publisher.publisher_name,
                                public_city.city_name,
                                public_city.city_id,
                                public_province.province_id,
                                public_country.country_id,
                                digilib_ddc.ddc_id AS ddc_idl3,
                                digilib_ddc1.ddc_id AS ddc_idl2,
                                digilib_ddc2.ddc_id AS ddc_idl1
                            FROM
                                digilib_book
                                INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                                INNER JOIN digilib_ddc digilib_ddc1 ON (digilib_ddc.ddc_parent = digilib_ddc1.ddc_id)
                                INNER JOIN digilib_ddc digilib_ddc2 ON (digilib_ddc1.ddc_parent = digilib_ddc2.ddc_id)
                                INNER JOIN digilib_publisher_office ON (digilib_book.book_publisher = digilib_publisher_office.publisher_office_id)
                                INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                                INNER JOIN public_city ON (digilib_publisher_office.publisher_office_city = public_city.city_id)
                                INNER JOIN public_province ON (public_city.city_province = public_province.province_id)
                                INNER JOIN public_country ON (public_province.province_country = public_country.country_id)
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
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

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

    public function createSave() {

        Session::init();

        $title = $this->method->post('title');
        $foreign_title = $this->method->post('foreign_title');
        $publisher = $this->method->post('publisher');
        $year = $this->method->post('year');
        $edition = $this->method->post('edition');
        $print_out = $this->method->post('print_out');
        $isbn = $this->method->post('isbn');
        $roman_count = $this->method->post('roman_count');
        $page_count = $this->method->post('page_count');
        $bibliography = $this->method->post('bibliography');
        $ilustration = $this->method->post('ilustration', 0);
        $index = $this->method->post('index', 0);
        $width = $this->method->post('width');
        $height = $this->method->post('height');
        $weight = $this->method->post('weight');
        $quantity = $this->method->post('quantity');
        $accounting_symbol = $this->method->post('accounting_symbol');
        $price = $this->method->post('price');
        $resource = $this->method->post('resource');
        $fund = $this->method->post('fund');
        $reviews = $this->method->post('reviews');
        $classification = $this->method->post('ddcid');

        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_book(
                            book_id,
                            book_title,
                            book_foreign_title,
                            book_publisher,
                            book_publishing,
                            book_edition,
                            book_copy,
                            book_isbn,
                            book_roman_number,
                            book_pages_number,
                            book_bibliography,
                            book_ilustration,
                            book_index,
                            book_width,
                            book_height,
                            book_weight,
                            book_accounting_symbol,
                            book_price,
                            book_resource,
                            book_fund,
                            book_review,
                            book_classification,
                            book_cover,
                            book_file,
                            book_entry,
                            book_entry_update
                        )
                    VALUES(
                        ( SELECT IF (
                        (SELECT COUNT(cdm . book_id) FROM digilib_book AS cdm 
                                WHERE cdm . book_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                ORDER BY cdm . book_id DESC LIMIT 1
                        ) > 0,
                        (SELECT ( dm.book_id + 1 ) FROM digilib_book AS dm 
                                WHERE dm . book_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),DATE_FORMAT(CURDATE(),"%m%d"),"%")) 
                                ORDER BY dm . book_id DESC LIMIT 1),
                        (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y"),DATE_FORMAT(CURDATE(),"%m%d"),"001"))) AS dd ),
                        :title,
                        :foreign_title,
                        :publisher,
                        :publishing,
                        :edition,
                        :copy,
                        :isbn,
                        :roman_number,
                        :pages_number,
                        :bibliography,
                        :ilustration,
                        :index,
                        :width,
                        :height,
                        :weight,
                        :accounting_symbol,
                        :price,
                        :resource,
                        :fund,
                        :review,
                        :classification_number,
                        NULL,
                        NULL,
                        NOW(),
                        NOW());
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':foreign_title', $foreign_title);
        $sth->bindValue(':publisher', $publisher);
        $sth->bindValue(':publishing', $year);
        $sth->bindValue(':edition', $edition);
        $sth->bindValue(':copy', $print_out);
        $sth->bindValue(':isbn', $isbn);
        $sth->bindValue(':roman_number', $roman_count);
        $sth->bindValue(':pages_number', $page_count);
        $sth->bindValue(':bibliography', $bibliography);
        $sth->bindValue(':ilustration', $ilustration);
        $sth->bindValue(':index', $index);
        $sth->bindValue(':width', $width);
        $sth->bindValue(':height', $height);
        $sth->bindValue(':weight', $weight);
        $sth->bindValue(':accounting_symbol', $accounting_symbol, PDO::PARAM_NULL);
        $sth->bindValue(':price', str_replace(',', '', $price));
        $sth->bindValue(':resource', $resource, PDO::PARAM_NULL);
        $sth->bindValue(':fund', $fund, PDO::PARAM_NULL);
        $sth->bindValue(':review', $reviews);
        $sth->bindValue(':classification_number', $classification);

        if ($sth->execute()) {

            $lastBookID = $this->db->lastInsID('book_id', 'digilib_book');

            $this->saveRegisterBook($quantity, $lastBookID);
            $this->saveLanguageBook($lastBookID);
            $this->saveAuthorBook($lastBookID);
            $this->updateAuthorStatus();

            $this->clearAuthorTemp();
            $this->clearLanguageTemp();

            $upload = Src::plugin()->PHPUploader();
            if ($this->method->files('cover', 'tmp_name')) {
                $upload->SetFileName($this->method->files('cover', 'name'));
                $upload->ChangeFileName('cover_' . date('Ymd') . time());
                $upload->SetTempName($this->method->files('cover', 'tmp_name'));
                $upload->SetUploadDirectory(Web::path() . 'asset/upload/images/'); //Upload directory, this should be writable
                if ($upload->UploadFile()) {
                    $this->saveCover($lastBookID, $upload->GetFileName());
                }
            }

            if ($this->method->files('file', 'tmp_name')) {
                $upload->SetFileName($this->method->files('file', 'name'));
                $upload->ChangeFileName('ebook_' . date('Ymd') . time());
                $upload->SetTempName($this->method->files('file', 'tmp_name'));
                $upload->SetUploadDirectory(Web::path() . 'asset/upload/file/'); //Upload directory, this should be writable
                if ($upload->UploadFile()) {
                    $this->saveFile($lastBookID, $upload->GetFileName());
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function saveLanguageBook($bookid) {
        $languagetemp = explode(',',$this->method->post('language_hide'));
        if (count($languagetemp)) {
            $prepare = '';
            foreach ($languagetemp as $rowlanguage) {
                $prepare .= '
                        INSERT INTO
                            digilib_book_language(
                            book_language_id,
                            book_id,
                            book_language)
                        VALUES (
                            (SELECT IF(
                                (SELECT COUNT(dbl.book_language_id) 
                                    FROM digilib_book_language AS dbl) > 0, 
                                        (SELECT dbl.book_language_id  
                                        FROM digilib_book_language AS dbl 
                                        ORDER BY dbl.book_language_id DESC LIMIT 1) + 1,
                                1)
                            ),
                            "' . $bookid . '",
                            "' . $rowlanguage . '"
                         );';
            }
            $sth = $this->db->prepare($prepare);
            $sth->execute();
        }
    }

    public function saveAuthorBook($bookid) {
        $authortemp = $this->selectAuthorTempBySession();
        if ($authortemp) {
            $prepare = '';
            foreach ($authortemp as $rowauthor) {
                $prepare .= '
                        INSERT INTO
                            digilib_book_aurthor(
                            book_aurthor_id,
                            book_aurthor_book,
                            book_aurthor_name,
                            book_aurthor_primary)
                        VALUES(
                            (SELECT IF(
                                (SELECT COUNT(dba.book_aurthor_id) 
                                    FROM digilib_book_aurthor AS dba) > 0, 
                                        (SELECT dba.book_aurthor_id  
                                        FROM digilib_book_aurthor AS dba 
                                        ORDER BY dba.book_aurthor_id DESC LIMIT 1) + 1,
                                1)
                            ),
                            "' . $bookid . '",
                            "' . $rowauthor['book_author_temp_name'] . '",
                            "' . $rowauthor['book_author_temp_primary'] . '");';
            }
            $sth = $this->db->prepare($prepare);
            if ($sth->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function updateAuthorStatus() {
        $authortemp = $this->selectAuthorTempBySession();
        if ($authortemp) {
            $authorid = '0';
            foreach ($authortemp as $rowauthor) {
                $authorid .= ',' . $rowauthor['book_author_temp_name'];
            }
            $sth = $this->db->prepare('
                                UPDATE
                                    digilib_author
                                SET
                                    author_status = 1
                                WHERE
                                    digilib_author.author_id IN (' . $authorid . ')
                            ');

            if ($sth->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function saveRegisterBook($ekemplar, $book_id) {

        if ($ekemplar > 0) {
            $sql = '';
            for ($idx = 0; $idx < $ekemplar; $idx++) {
                $sql .= 'INSERT INTO
                            digilib_book_register(
                            book_register_id,
                            book_id,
                            book_condition,
                            book_entry)
                        VALUES(
                            (SELECT IF (
                            (SELECT COUNT(cdm.book_register_id) FROM digilib_book_register AS cdm WHERE cdm.book_register_id  LIKE  "' . $book_id . '%") > 0,
                            (SELECT ( dm.book_register_id + 1 ) FROM digilib_book_register AS dm WHERE dm.book_register_id  LIKE  "' . $book_id . '%" ORDER BY dm.book_register_id DESC LIMIT 1), "' . $book_id . '001")),
                            "' . $book_id . '",
                            1,
                            NOW());';
            }
        }

        $sth = $this->db->prepare($sql);
        $sth->execute();
    }

    public function updateSave($id = 0) {
        $sth = $this->db->prepare('
                    UPDATE
                        digilib_writer
                    SET
                        writer_name = :name,
                        writer_profile = :profile
                    WHERE
                        digilib_writer.writer_id = :id
                ');

        $name = trim($_POST['name']);
        $address = trim($_POST['profile']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':profile' => $address,
                    ':id' => $id
        ));
    }

    public function saveCover($id, $cover) {
        $sth = $this->db->prepare('UPDATE
                                    digilib_book
                                SET
                                    book_cover = :cover
                                WHERE
                                    book_id = :id');
        $sth->bindValue(':cover', $cover);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

    public function saveFile($id, $cover) {
        $sth = $this->db->prepare('UPDATE
                                    digilib_book
                                SET
                                    book_file = :cover
                                WHERE
                                    book_id = :id');
        $sth->bindValue(':cover', $cover);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

    public function delete() {
        $delete_id = $_POST['val'];
        $sth = $this->db->prepare('DELETE FROM digilib_book WHERE book_id = :id');

        try {
            foreach ($delete_id as $id) {
                $sth->execute(array(':id' => $id));
            }
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
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

    public function listYear() {
        $y = array();
        for ($idx = date('Y'); $idx >= 1970; $idx--) {
            $y[$idx] = $idx;
        }
        return $y;
    }

    public function selectLanguage() {
        $sth = $this->db->prepare('SELECT * FROM public_language ORDER BY language_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectAccountingSymbol() {
        $sth = $this->db->prepare('SELECT * FROM public_accounting_symbol');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectBookResource() {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_book_resource.book_resource_id,
                                    digilib_book_resource.book_resource_title
                                FROM
                                    digilib_book_resource
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectBookFund() {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_book_fund.book_fund_id,
                                    digilib_book_fund.book_fund_title,
                                    digilib_book_fund.book_fund_status,
                                    digilib_book_fund.book_fund_entry,
                                    digilib_book_fund.book_fund_entry_update
                                FROM
                                    digilib_book_fund
                                ORDER BY book_fund_title
                            ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectAllPublisher($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $cityid = $this->method->post('city', 0);

        $listSelect = "
            digilib_publisher_office.publisher_office_id,
            digilib_publisher_office.publisher_office_address,
            digilib_publisher_office.publisher_office_city,
            digilib_publisher_office.publisher_office_zipcode,
            digilib_publisher_office.publisher_office_phone,
            digilib_publisher_office.publisher_office_fax,
            digilib_publisher_office.publisher_office_email,
            digilib_publisher_office.publisher_office_website,
            digilib_publisher_office.publisher_office_department,
            digilib_publisher_office.publisher_office_entry,
            digilib_publisher_office.publisher_office_entry_update,
            digilib_publisher.publisher_name,
            digilib_publisher.publisher_description,
            digilib_publisher_office_department.publisher_office_department_name";

        $prepare = 'SELECT ' . $listSelect . ' 
                    FROM
                        digilib_publisher_office
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN digilib_publisher_office_department ON (digilib_publisher_office.publisher_office_department = digilib_publisher_office_department.publisher_office_department_id)
                    WHERE
                        digilib_publisher_office.publisher_office_city = :city ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':city', $cityid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllPublisher() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $cityid = $this->method->post('city', 0);

        $prepare = 'SELECT COUNT(publisher_office_id) AS cnt 
                    FROM
                        digilib_publisher_office
                        INNER JOIN digilib_publisher ON (digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id)
                        INNER JOIN digilib_publisher_office_department ON (digilib_publisher_office.publisher_office_department = digilib_publisher_office_department.publisher_office_department_id)
                    WHERE
                        digilib_publisher_office.publisher_office_city = :city ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':city', $cityid);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectDdcByLevel($level = 0) {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_ddc.ddc_id,
                                    digilib_ddc.ddc_classification_number,
                                    digilib_ddc.ddc_title,
                                    digilib_ddc.ddc_description,
                                    digilib_ddc.ddc_level,
                                    digilib_ddc.ddc_parent
                                FROM
                                    digilib_ddc
                                WHERE
                                    digilib_ddc.ddc_level = :level
                            ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':level' => $level));
        return $sth->fetchAll();
    }

    public function selectDdcByParentId($parentid) {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_ddc.ddc_id,
                                    digilib_ddc.ddc_classification_number,
                                    digilib_ddc.ddc_title,
                                    digilib_ddc.ddc_description,
                                    digilib_ddc.ddc_level,
                                    digilib_ddc.ddc_parent
                                FROM
                                    digilib_ddc
                                WHERE
                                    digilib_ddc.ddc_parent = :parentid
                            ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':parentid' => $parentid));
        return $sth->fetchAll();
    }

    public function selectAllDdcByLevel($level = 0, $start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=:level ORDER BY ddc_classification_number LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':level' => $level));
        return $sth->fetchAll();
    }

    public function countAllDdcByLevel($level = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=:level');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':level' => $level));
        return $sth->rowCount();
    }

    public function selectAllDdcByParent($parent = 0, $start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_parent=:parent ORDER BY ddc_classification_number LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':parent' => $parent));
        return $sth->fetchAll();
    }

    public function countAllDdcByParent($parent = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_parent=:parent');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':parent' => $parent));
        return $sth->rowCount();
    }

    public function selectAllAuthorDescription() {
        $sth = $this->db->prepare('
                              SELECT 
                                digilib_author_description.author_description_id,
                                digilib_author_description.author_description_title,
                                digilib_author_description.author_description_level,
                                digilib_author_description.author_description_entry,
                                digilib_author_description.author_description_entry_update
                              FROM
                                digilib_author_description
                              ORDER BY digilib_author_description.author_description_level');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllAuthor() {
        $sth = $this->db->prepare('SELECT * FROM digilib_author');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectWriterTempBySession($sid = 0) {
        $sth = $this->db->prepare('SELECT *
                                   FROM
                                        digilib_author_temp
                                   WHERE
                                        digilib_author_temp.session_id = :session AND
                                        digilib_author_temp.author_description = 1
                                   ORDER BY digilib_author_temp.author_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':session' => $sid));
        return $sth->fetchAll();
    }

    public function selectCatalogueById($id) {
        $sth = $this->db->prepare('SELECT 
                                        digilib_book.book_title,
                                        digilib_book.book_sub_title,
                                        (SELECT digilib_ddc.ddc_classification_number FROM digilib_ddc WHERE digilib_ddc.ddc_id = digilib_book.book_classification) AS class_number
                                    FROM
                                        digilib_book
                                    WHERE
                                        digilib_book.book_id=:id');
        $sth->bindValue(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllCollectionByBookId($id = 0) {
        $sth = $this->db->prepare('SELECT 
                                        dbr.book_register_id,
                                        dbr.book_id,
                                        (SELECT dbc.book_condition FROM digilib_book_condition AS dbc WHERE dbc.book_condition_id = dbr.book_condition) AS book_con,
                                        dbr.entry_date,
                                        dbr.last_borrow,
                                        dbr.borrow_status
                                   FROM
                                        digilib_book_register AS dbr
                                   WHERE
                                        dbr.book_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectLanguageTemp($page = 1) {
        Session::init();
        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_book_language_temp.book_language_temp_id,
            digilib_book_language_temp.book_language_temp_session,
            digilib_book_language_temp.book_language,
            public_language.language_name";

        $prepare = 'SELECT ' . $listSelect . ' 
                    FROM 
                        digilib_book_language_temp 
                        INNER JOIN public_language ON (digilib_book_language_temp.book_language = public_language.language_id)                        
                    WHERE digilib_book_language_temp.book_language_temp_session = :sessoion';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':sessoion', Session::id());
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countLanguageTemp() {
        Session::init();
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(book_language_temp_id) AS cnt FROM digilib_book_language_temp WHERE digilib_book_language_temp.book_language_temp_session = :sessoion';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':sessoion', Session::id());
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function clearLanguageTemp() {
        Session::init();
        $sth = $this->db->prepare('DELETE FROM digilib_book_language_temp WHERE digilib_book_language_temp.book_language_temp_session = :sessoion');
        $sth->bindValue(':sessoion', Session::id());
        $sth->execute();
    }

    public function selectLanguageByName($name) {
        $sth = $this->db->prepare(' SELECT 
                                        public_language.language_id,
                                        public_language.language_name,
                                        public_language.language_status,
                                        public_language.language_entry,
                                        public_language.language_entry_update
                                    FROM
                                        public_language
                                    WHERE
                                        public_language.language_name = :name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':name', $name);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveLanguage($name) {
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
                        0,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':title', $name);

        return $sth->execute();
    }

    public function saveLanguageTemp($lang) {
        Session::init();
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_book_language_temp(
                        book_language_temp_id,
                        book_language_temp_session,
                        book_language)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dblt.book_language_temp_id) 
                             FROM digilib_book_language_temp AS dblt) > 0, 
                                (SELECT dblt.book_language_temp_id 
                                 FROM digilib_book_language_temp AS dblt 
                                 ORDER BY dblt.book_language_temp_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :session,
                        :language)
                ');

        $sth->bindValue(':session', Session::id());
        $sth->bindValue(':language', $lang);

        return $sth->execute();
    }

    public function lastLanguageId() {
        return $this->db->lastInsID('language_id', 'public_language');
    }

    public function deleteLanguageTemp() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_book_language_temp WHERE digilib_book_language_temp.book_language_temp_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function deleteLanguage($id) {
        $sth = $this->db->prepare('
            DELETE
            FROM
                public_language
            WHERE
                public_language.language_id  IN (' . $id . ') AND 
                public_language.language_status = 0
            ');
        return $sth->execute();
    }

    public function selectLanguageTempById() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('
            SELECT * FROM digilib_book_language_temp WHERE digilib_book_language_temp.book_language_temp_id IN (' . $id . ')');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectCountry() {
        $sth = $this->db->prepare('SELECT * FROM public_country ORDER BY country_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectProvinceByCountryId($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                public_province.province_id,
                                public_province.province_name,
                                public_province.province_country,
                                public_province.province_status,
                                public_province.province_entry,
                                public_province.province_entry_update
                            FROM
                                public_province
                            WHERE
                                public_province.province_country = :id
                            ORDER BY public_province.province_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectCityByProvinceId($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                public_city.city_id,
                                public_city.city_name,
                                public_city.city_province,
                                public_city.city_status,
                                public_city.city_entry,
                                public_city.city_entry_update
                            FROM
                                public_city
                            WHERE
                                public_city.city_province = :id
                            ORDER BY public_city.city_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAuthorByDescrtiptionId($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_author.author_id,
                                CONCAT_WS(" ",
                                    digilib_author.author_front_degree,
                                    digilib_author.author_firstname,
                                    digilib_author.author_lastname,
                                    digilib_author.author_back_degree
                                    ) AS author_name,
                                digilib_author.author_entry,
                                digilib_author.author_entry_update,
                                digilib_author.author_status,
                                digilib_author.author_description
                            FROM
                                digilib_author
                            WHERE
                                digilib_author.author_description = :id
                            ORDER BY author_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveAuthorTemp($author) {
        Session::init();
        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_book_author_temp(
                        book_author_temp_id,
                        book_author_temp_session,
                        book_author_temp_name,
                        book_author_temp_primary)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dbat.book_author_temp_id) 
                             FROM digilib_book_author_temp AS dbat) > 0, 
                                (SELECT dbat.book_author_temp_id 
                                 FROM digilib_book_author_temp AS dbat 
                                 ORDER BY dbat.book_author_temp_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :session,
                        :author,
                        0)
                ');

        $sth->bindValue(':session', Session::id());
        $sth->bindValue(':author', $author);

        return $sth->execute();
    }

    public function selectAllAuthorTemp($page = 1) {
        Session::init();

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_book_author_temp.book_author_temp_id,
            digilib_book_author_temp.book_author_temp_session,
            digilib_book_author_temp.book_author_temp_name,
            digilib_book_author_temp.book_author_temp_primary,
            CONCAT_WS(' ',
                digilib_author.author_front_degree,
                digilib_author.author_firstname,
                digilib_author.author_lastname,
                digilib_author.author_back_degree
            ) AS author_name,
            digilib_author_description.author_description_title,
            digilib_author_description.author_description_level";

        $prepare = 'SELECT ' . $listSelect . ' 
                    FROM
                        digilib_book_author_temp
                        INNER JOIN digilib_author ON (digilib_book_author_temp.book_author_temp_name = digilib_author.author_id)
                        INNER JOIN digilib_author_description ON (digilib_author.author_description = digilib_author_description.author_description_id)
                    WHERE
                        digilib_book_author_temp.book_author_temp_session = :session ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':session', Session::id());
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllAuthorTemp() {
        Session::init();

        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(book_author_temp_id) AS cnt 
                    FROM
                        digilib_book_author_temp
                    WHERE
                        digilib_book_author_temp.book_author_temp_session = :session ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':session', Session::id());
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function deleteAuthorTemp($id) {
        $sth = $this->db->prepare('DELETE FROM digilib_book_author_temp WHERE digilib_book_author_temp.book_author_temp_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function deleteAuthor($id) {
        $sth = $this->db->prepare('
                            DELETE
                            FROM
                                digilib_author
                            WHERE
                                digilib_author.author_id IN (' . $id . ') AND 
                                digilib_author.author_status = 0');
        return $sth->execute();
    }

    public function clearAuthorTemp() {
        Session::init();
        $sth = $this->db->prepare('DELETE FROM digilib_book_author_temp WHERE digilib_book_author_temp.book_author_temp_session = :sessoion');
        $sth->bindValue(':sessoion', Session::id());
        $sth->execute();
    }

    public function saveAuthor() {
        $first_name = $this->method->post('first_name');
        $last_name = $this->method->post('last_name');
        $front_degree = $this->method->post('front_degree');
        $back_degree = $this->method->post('back_degree');
        $desc_author = $this->method->post('desc_author');
        $sth = $this->db->prepare('
                            INSERT INTO
                                digilib_author(
                                author_id,
                                author_firstname,
                                author_lastname,
                                author_front_degree,
                                author_back_degree,
                                author_entry,
                                author_entry_update,
                                author_status,
                                author_description)
                            VALUES(
                                (SELECT IF(
                                    (SELECT COUNT(da.author_id) 
                                    FROM digilib_author AS da) > 0, 
                                        (SELECT da.author_id 
                                        FROM digilib_author AS da 
                                        ORDER BY da.author_id DESC LIMIT 1) + 1,
                                    1)
                                ),
                                :first_name,
                                :last_name,
                                :front_degree,
                                :back_degree,
                                NOW(),
                                NOW(),
                                0,
                                :desc_author)
                        ');

        $sth->bindValue(':first_name', $first_name);
        $sth->bindValue(':last_name', $last_name);
        $sth->bindValue(':front_degree', $front_degree);
        $sth->bindValue(':back_degree', $back_degree);
        $sth->bindValue(':desc_author', $desc_author);

        return $sth->execute();
    }

    public function lastAuthorId() {
        return $this->db->lastInsID('author_id', 'digilib_author');
    }

    public function selectAuthorByNameAndAuthorDescription() {

        $first_name = $this->method->post('first_name');
        $last_name = $this->method->post('last_name');
        $front_degree = $this->method->post('front_degree');
        $back_degree = $this->method->post('back_degree');
        $desc_author = $this->method->post('desc_author');

        $author_name = '';

        if (!empty($front_degree))
            $author_name .= $front_degree . ' ';

        if (!empty($first_name))
            $author_name .= $first_name . ' ';

        if (!empty($last_name))
            $author_name .= $last_name . ' ';

        if (!empty($back_degree))
            $author_name .= $back_degree . ' ';

        $sth = $this->db->prepare('
                            SELECT 
                                digilib_author.author_id,
                                CONCAT_WS(" ", 
                                    digilib_author.author_front_degree, 
                                    digilib_author.author_firstname, 
                                    digilib_author.author_lastname, 
                                    digilib_author.author_back_degree
                                ),
                                digilib_author.author_entry,
                                digilib_author.author_entry_update,
                                digilib_author.author_status,
                                digilib_author.author_description
                            FROM
                                digilib_author
                            WHERE
                                CONCAT_WS(" ", 
                                    digilib_author.author_front_degree, 
                                    digilib_author.author_firstname, 
                                    digilib_author.author_lastname, 
                                    digilib_author.author_back_degree
                                ) = :author_name AND
                                digilib_author.author_description = :author_desc
                        ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':author_name', $author_name);
        $sth->bindValue(':author_desc', $desc_author);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAuthorTempByID($id) {

        $sth = $this->db->prepare('
                            SELECT 
                                digilib_book_author_temp.book_author_temp_id,
                                digilib_book_author_temp.book_author_temp_session,
                                digilib_book_author_temp.book_author_temp_name,
                                digilib_book_author_temp.book_author_temp_primary
                            FROM
                                digilib_book_author_temp
                            WHERE
                                digilib_book_author_temp.book_author_temp_id IN (' . $id . ')
                        ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAuthorTempBySession() {
        Session::init();
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_book_author_temp.book_author_temp_id,
                                digilib_book_author_temp.book_author_temp_session,
                                digilib_book_author_temp.book_author_temp_name,
                                digilib_book_author_temp.book_author_temp_primary,
                                digilib_author.author_firstname,
                                digilib_author.author_lastname
                            FROM
                                digilib_book_author_temp
                                INNER JOIN digilib_author ON (digilib_book_author_temp.book_author_temp_name = digilib_author.author_id)
                            WHERE
                                digilib_book_author_temp.book_author_temp_session = :session
                        ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':session', Session::id());
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAuthorPrimaryTemp() {
        Session::init();
        $sth = $this->db->prepare('
                              SELECT 
                                digilib_author.author_firstname,
                                digilib_author.author_lastname,
                                digilib_author_description.author_description_title,
                                digilib_book_author_temp.book_author_temp_primary
                              FROM
                                digilib_book_author_temp
                                INNER JOIN digilib_author ON (digilib_book_author_temp.book_author_temp_name = digilib_author.author_id)
                                INNER JOIN digilib_author_description ON (digilib_author.author_description = digilib_author_description.author_description_id)
                              WHERE
                                digilib_author_description.author_description_id = 1 AND 
                                digilib_book_author_temp.book_author_temp_session = :session
                              ORDER BY
                                digilib_author_description.author_description_level,
                                digilib_book_author_temp.book_author_temp_id
                        ');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':session', Session::id());
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllDdc($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('ddckeyword', false);
        $qtype = $this->method->post('keyword_categories', false);

        $parentid = $this->method->post('ddcLevel2', -1);

        $listSelect = "
            digilib_ddc.ddc_id,
            digilib_ddc.ddc_classification_number,
            digilib_ddc.ddc_title,
            digilib_ddc.ddc_description,
            digilib_ddc.ddc_level,
            digilib_ddc.ddc_parent";

        $prepare = 'SELECT ' . $listSelect . ' 
                    FROM
                        digilib_ddc
                    WHERE
                        digilib_ddc.ddc_parent = :parentid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':parentid', $parentid);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllDdc() {
        $query = $this->method->post('ddckeyword', false);
        $qtype = $this->method->post('keyword_categories', false);

        $parentid = $this->method->post('ddcLevel2', -1);

        $prepare = 'SELECT COUNT(ddc_id) AS cnt 
                    FROM
                        digilib_ddc
                    WHERE
                        digilib_ddc.ddc_parent = :parentid ';
        if ($query)
            $prepare .= ' AND ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':parentid', $parentid);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function saveSetPrimaryAuthor($conditon, $id, $isprimary) {

        $setprimary = 0;
        if ($isprimary)
            $setprimary = 1;

        $sth = $this->db->prepare('
                                UPDATE
                                    digilib_book_author_temp
                                SET
                                    book_author_temp_primary = :setprimary
                                WHERE
                                    digilib_book_author_temp.book_author_temp_id ' . $conditon . ' (' . $id . ')
                          ');
        $sth->bindValue(':setprimary', $setprimary);
        return $sth->execute();
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
                                (SELECT COUNT(digilib_book_register.book_id) AS FIELD_1 FROM digilib_borrowed_history INNER JOIN digilib_book_register ON (digilib_borrowed_history.borrowed_history_book = digilib_book_register.book_register_id) WHERE digilib_book_register.book_id = digilib_book.book_id) AS count_borrowed,
                                digilib_ddc.ddc_id AS ddc_idl3,
                                digilib_ddc1.ddc_id AS ddc_idl2,
                                digilib_ddc2.ddc_id AS ddc_idl1
                              FROM
                                digilib_book
                                INNER JOIN digilib_ddc ON (digilib_book.book_classification = digilib_ddc.ddc_id)
                                INNER JOIN digilib_ddc digilib_ddc1 ON (digilib_ddc.ddc_parent = digilib_ddc1.ddc_id)
                                INNER JOIN digilib_ddc digilib_ddc2 ON (digilib_ddc1.ddc_parent = digilib_ddc2.ddc_id)
                            WHERE
                                digilib_book.book_id IN (' . $id . ')
                        ');

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
                        digilib_book.book_title
                      FROM
                        digilib_book_temp_barcodeprint
                        INNER JOIN digilib_book_register ON (digilib_book_temp_barcodeprint.book_temp_barcodeprint_register = digilib_book_register.book_register_id)
                        INNER JOIN digilib_book ON (digilib_book_register.book_id = digilib_book.book_id)
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

    public function deletePrintListBarcode() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_book_temp_barcodeprint WHERE digilib_book_temp_barcodeprint.book_temp_barcodeprint IN (' . $id . ')');
        return $sth->execute();
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

    public function selectBookLanguageByBookId($bookid = 0) {
        $prepare = 'SELECT 
                        digilib_book_language.book_language,
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

    public function selectPositionRowPublisher($office_id, $city_id) {
        $prepare = ' SELECT x.publisher_office_id, 
                            x.position,
                            (SELECT COUNT(c.publisher_office_id) FROM  digilib_publisher_office c WHERE c.publisher_office_city = :city_id) AS count_publisher
                     FROM (SELECT dpo.publisher_office_id,
                                  @rownum := @rownum + 1 AS position
                           FROM digilib_publisher_office dpo
                           JOIN (SELECT @rownum := 0) r
                           WHERE dpo.publisher_office_city = :city_id
                           ORDER BY dpo.publisher_office_id) x
                      WHERE x.publisher_office_id = :office_id';

        $sth = $this->db->prepare($prepare);
        
        $sth->bindValue(':city_id', $city_id);
        $sth->bindValue(':office_id', $office_id);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectPositionRowDdc($ddc_idl3, $ddc_idl2) {
        $prepare = ' SELECT x.ddc_id, 
                            x.position,
                            (SELECT COUNT(c.ddc_id) FROM  digilib_ddc c WHERE c.ddc_parent = :ddc_idl2) AS count_ddc
                     FROM (SELECT dpo.ddc_id,
                                  @rownum := @rownum + 1 AS position
                           FROM digilib_ddc dpo
                           JOIN (SELECT @rownum := 0) r
                           WHERE dpo.ddc_parent = :ddc_idl2
                           ORDER BY dpo.ddc_id) x
                      WHERE x.ddc_id = :ddc_idl3';

        $sth = $this->db->prepare($prepare);
        
        $sth->bindValue(':ddc_idl3', $ddc_idl3);
        $sth->bindValue(':ddc_idl2', $ddc_idl2);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}