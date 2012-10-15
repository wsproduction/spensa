<?php

class CatalogueModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAll($start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT 
                                    digilib_book.book_id,
                                    digilib_book.book_title,
                                    digilib_book.book_sub_title,
                                    (SELECT dp.publisher_name FROM digilib_publisher AS dp WHERE dp.publisher_id = digilib_book.book_publisher) AS publisher_name,
                                    (SELECT pc.city_name FROM public_city AS pc WHERE pc.city_id = digilib_book.book_city_launching) AS city_name,
                                    digilib_book.book_year_launching,
                                    digilib_book.book_language,
                                    digilib_book.book_edition,
                                    digilib_book.book_print,
                                    digilib_book.book_isbn,
                                    digilib_book.book_roman_number,
                                    digilib_book.book_pages_number,
                                    digilib_book.book_bibliography,
                                    digilib_book.book_ilustration,
                                    digilib_book.book_index,
                                    digilib_book.book_width,
                                    digilib_book.book_height,
                                    digilib_book.book_weight,
                                    digilib_book.book_quantity,
                                    digilib_book.book_accounting_symbol,
                                    digilib_book.book_price,
                                    (SELECT dr.resource_name FROM digilib_resource AS dr WHERE dr.resource_id = digilib_book.book_resource) AS resource_name,
                                    (SELECT dn.fund_name FROM digilib_fund AS dn WHERE dn.fund_id = digilib_book.book_fund ) AS fund_name,
                                    digilib_book.book_review,
                                    digilib_book.book_type,
                                    (SELECT dbbd.borrowed_title FROM digilib_book_borrowed_description AS dbbd WHERE dbbd.borrowed_description_id = digilib_book.book_length_borrowed) AS length_borrowed,
                                    digilib_book.book_status,
                                    (SELECT ddc.ddc_classification_number FROM digilib_ddc AS ddc WHERE ddc.ddc_id = digilib_book.book_classification ) AS classification_number,
                                    digilib_book.book_cover,
                                    digilib_book.book_entry_date
                                   FROM
                                    digilib_book
                                   ORDER BY digilib_book.book_id DESC LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllCollection($id = 0, $start = 0, $count = 100) {
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
                                        dbr.book_id = :id
                                   ORDER BY dbr.book_register_id LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
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

    public function countAll() {
        $sth = $this->db->prepare('SELECT * FROM digilib_book');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }
    
    public function countAllCollection($id = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_book_register WHERE book_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->rowCount();
    }

    public function createSave() {

        $title = $this->method->post('title');
        $sub_title = $this->method->post('sub_title');
        $foreign_title = $this->method->post('foreign_title');
        $desc_title = $this->method->post('desc_title');
        $publisher = $this->method->post('publisher');
        $city = $this->method->post('city');
        $year = $this->method->post('year');
        $language = $this->method->post('language');
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
        $book_type = $this->method->post('book_type');
        $length_borrowed = $this->method->post('length_borrowed');
        $hard_copy = $this->method->post('hard_copy', 0);
        $soft_copy = $this->method->post('soft_copy', 0);
        $classification = $this->method->post('tempSelectId3');
        $status = $this->method->post('status', 0);
        $sessionAuthor = $this->method->post('sessionAuthor');

        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_book(
                        book_id,
                        book_title,
                        book_sub_title,
                        book_foreign_title,
                        book_description_title,
                        book_publisher,
                        book_city_launching,
                        book_year_launching,
                        book_language,
                        book_edition,
                        book_print,
                        book_isbn,
                        book_roman_number,
                        book_pages_number,
                        book_bibliography,
                        book_ilustration,
                        book_index,
                        book_width,
                        book_height,
                        book_weight,
                        book_quantity,
                        book_accounting_symbol,
                        book_price,
                        book_resource,
                        book_fund,
                        book_review,
                        book_type,
                        book_length_borrowed,
                        book_hard_copy,
                        book_electronic,
                        book_status,
                        book_classification,
                        book_cover,
                        book_entry_date)
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
                        :sub_title,
                        :foreign_title,
                        :desc_title,
                        :publisher,
                        :city,
                        :year,
                        :language,
                        :edition,
                        :print,
                        :isbn,
                        :roman_number,
                        :pages_number,
                        :bibliography,
                        :ilustration,
                        :index,
                        :width,
                        :height,
                        :weight,
                        :quantity,
                        :accounting_symbol,
                        :price,
                        :resource,
                        :fund,
                        :review,
                        :type,
                        :length_borrowed,
                        :book_hard_copy,
                        :book_electronic,
                        :status,
                        :classification_number,
                        NULL,
                        NOW());
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':sub_title', $sub_title);
        $sth->bindValue(':foreign_title', $foreign_title);
        $sth->bindValue(':desc_title', $desc_title);
        $sth->bindValue(':publisher', $publisher);
        $sth->bindValue(':city', $city);
        $sth->bindValue(':year', $year);
        $sth->bindValue(':language', $language);
        $sth->bindValue(':edition', $edition);
        $sth->bindValue(':print', $print_out);
        $sth->bindValue(':isbn', $isbn);
        $sth->bindValue(':roman_number', $roman_count);
        $sth->bindValue(':pages_number', $page_count);
        $sth->bindValue(':bibliography', $bibliography);
        $sth->bindValue(':ilustration', $ilustration);
        $sth->bindValue(':index', $index);
        $sth->bindValue(':width', $width);
        $sth->bindValue(':height', $height);
        $sth->bindValue(':weight', $weight);
        $sth->bindValue(':quantity', $quantity);
        $sth->bindValue(':accounting_symbol', $accounting_symbol, PDO::PARAM_NULL);
        $sth->bindValue(':price', $price);
        $sth->bindValue(':resource', $resource, PDO::PARAM_NULL);
        $sth->bindValue(':fund', $fund, PDO::PARAM_NULL);
        $sth->bindValue(':review', $reviews);
        $sth->bindValue(':type', $book_type);
        $sth->bindValue(':length_borrowed', $length_borrowed, PDO::PARAM_NULL);
        $sth->bindValue(':book_hard_copy', $hard_copy);
        $sth->bindValue(':book_electronic', $soft_copy);
        $sth->bindValue(':status', $status);
        $sth->bindValue(':classification_number', $classification);

        if ($sth->execute()) {
            $lastBookID = $this->db->lastInsID('book_id', 'digilib_book');

            $this->saveBukuInduk($quantity, $lastBookID);

            $sthAuthor = $this->db->prepare('SELECT * FROM digilib_author_temp WHERE session_id=:id');
            $sthAuthor->setFetchMode(PDO::FETCH_ASSOC);
            $sthAuthor->execute(array(':id' => $sessionAuthor));
            $dataAuthor = $sthAuthor->fetchAll();

            if ($sthAuthor->rowCount() > 0) {
                $sql = '';
                foreach ($dataAuthor as $value) {
                    $sql .= 'INSERT INTO
                                digilib_author(
                                author_first_name,
                                author_last_name,
                                author_description,
                                author_front_degree,
                                author_back_degree,
                                book_id)
                            VALUES(
                                "' . $value['author_first_name'] . '",
                                "' . $value['author_last_name'] . '",
                                ' . $value['author_description'] . ',
                                "' . $value['author_front_degree'] . '",
                                "' . $value['author_back_degree'] . '",
                                "' . $lastBookID . '");';
                }

                if ($this->saveAuthor($sql))
                    $this->deleteAuthorTempSession($sessionAuthor);
            }

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

    public function saveBukuInduk($ekemplar, $book_id) {

        if ($ekemplar > 0) {
            $sql = '';
            for ($idx = 0; $idx < $ekemplar; $idx++) {
                $sql .= 'INSERT INTO
                            digilib_book_register(
                            book_register_id,
                            book_id,
                            book_condition,
                            entry_date)
                        VALUES(
                            (SELECT IF (
                            (SELECT COUNT(cdm.book_register_id) FROM digilib_book_register AS cdm WHERE cdm.book_register_id  LIKE  "' . $book_id . '%") > 0,
                            (SELECT ( dm.book_register_id + 1 ) FROM digilib_book_register AS dm WHERE dm.book_register_id  LIKE  "' . $book_id . '%" ORDER BY dm.book_register_id DESC LIMIT 1), "' . $book_id . '001")),
                            "' . $book_id . '",
                            "1",
                            NOW());';
            }
        }

        $sth = $this->db->prepare($sql);
        $sth->execute();
    }

    public function saveAuthor($statement) {
        $sth = $this->db->prepare($statement);
        if ($sth->execute())
            return true;
        else
            return false;
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

    public function deleteAuthorTemp() {
        $delete_id = $_POST['val'];
        $sth = $this->db->prepare('DELETE FROM digilib_author_temp WHERE author_id = :id');

        try {
            $sth->execute(array(':id' => $delete_id));
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
    }

    public function deleteAuthorTempSession($session) {
        $sth = $this->db->prepare('DELETE FROM digilib_author_temp WHERE session_id = :id');
        $sth->execute(array(':id' => $session));
    }

    public function selectAuthorTempBySession() {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_author_temp.author_first_name,
                                digilib_author_temp.author_last_name,
                                digilib_author_temp.author_description,
                                digilib_author_temp.author_front_degree,
                                digilib_author_temp.author_back_degree,
                                digilib_author_temp.session_id
                            FROM
                                digilib_author_temp
                            WHERE
                                digilib_author_temp.session_id = :session');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':session' => $this->method->get('sa')));
        if ($sth->rowCount() > 0)
            return $sth->fetchAll();
        else
            return false;
    }

    public function selectAuthorByBookID($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                da.author_id,
                                da.author_first_name,
                                da.author_last_name,
                                da.author_description,
                                (SELECT dad.author_description FROM digilib_author_description AS dad WHERE dad.author_description_id = da.author_description) AS desc_name
                            FROM
                                digilib_author AS da
                            WHERE
                                da.book_id = :id
                            ORDER BY da.author_description, da.author_id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        return $sth->fetchAll();
    }

    public function selectAuthorByName() {
        $sth = $this->db->prepare('
                        SELECT *
                        FROM
                            digilib_author
                        ORDER BY digilib_author.author_first_name, digilib_author.author_last_name');

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
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
        $sth = $this->db->prepare('SELECT * FROM digilib_resource ORDER BY resource_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectBookFund() {
        $sth = $this->db->prepare('SELECT * FROM digilib_fund ORDER BY fund_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectPublisher() {
        $sth = $this->db->prepare('SELECT * FROM digilib_publisher ORDER BY publisher_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectPublisherByID() {
        $sth = $this->db->prepare('SELECT * FROM digilib_publisher WHERE publisher_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $this->method->get('id'));
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
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

    public function selectCity($country_id = 0) {
        $sth = $this->db->prepare('SELECT * FROM public_city WHERE country_id=:cid ORDER BY city_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':cid' => $country_id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectDdcByLevel($level = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=:level ORDER BY ddc_classification_number, ddc_title DESC');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':level' => $level));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function selectDdcByParent($id = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_parent=:id ORDER BY ddc_classification_number, ddc_title DESC');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
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
        $sth = $this->db->prepare('SELECT * FROM digilib_author_description ORDER BY author_description DESC');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllLengthBorrowed() {
        $sth = $this->db->prepare('SELECT * FROM digilib_book_borrowed_description ORDER BY borrowed_title DESC');
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

    public function addAuthorTempSave() {
        Session::init();
        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_author_temp(
                        author_first_name,
                        author_last_name,
                        author_description,
                        author_front_degree,
                        author_back_degree,
                        session_id,
                        insert_date)
                    VALUES(
                        :first_name,
                        :last_name,
                        :description,
                        :front_degree,
                        :back_degree,
                        :session_id,
                        NOW())
                ');

        $first_name = trim($_POST['first_name_author']);
        $last_name = trim($_POST['last_name_author']);
        $description = trim($_POST['description_author']);
        $front_degree = trim($_POST['front_degree_author']);
        $back_degree = trim($_POST['back_degree_author']);
        $session_id = trim($_POST['sa']);

        return $sth->execute(array(
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':description' => $description,
                    ':front_degree' => $front_degree,
                    ':back_degree' => $back_degree,
                    ':session_id' => $session_id
                ));
    }

    public function selectAllAuthorTemp($start = 1, $count = 100, $sessionAuthor = 0) {
        $sth = $this->db->prepare('SELECT 
                                        digilib_author_temp.author_id,
                                        digilib_author_temp.author_first_name,
                                        digilib_author_temp.author_last_name,
                                        (SELECT author_description FROM digilib_author_description WHERE digilib_author_description.author_description_id = digilib_author_temp.author_description) AS "author_description",
                                        digilib_author_temp.author_front_degree,
                                        digilib_author_temp.author_back_degree,
                                        digilib_author_temp.session_id
                                   FROM
                                        digilib_author_temp
                                   WHERE
                                        digilib_author_temp.session_id = :session
                                   ORDER BY digilib_author_temp.author_description, digilib_author_temp.author_id LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':session' => $sessionAuthor));
        return $sth->fetchAll();
    }

    public function countAllAuthorTemp($sessionAuthor = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_author_temp WHERE session_id=:session');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':session' => $sessionAuthor));
        return $sth->rowCount();
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

    public function selectBookType() {
        $sth = $this->db->prepare('SELECT *
                                   FROM
                                        digilib_book_type
                                   ORDER BY book_type');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
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

}