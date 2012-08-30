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
                                        digilib_book.book_ddc,
                                        (SELECT digilib_ddc.ddc_classification_number FROM digilib_ddc WHERE digilib_ddc.ddc_id = digilib_book.book_ddc) AS call_number,
                                        digilib_book.book_publisher,
                                        (SELECT digilib_publisher.publisher_name FROM digilib_publisher WHERE digilib_publisher.publisher_id = digilib_book.book_publisher) AS publisher_name,
                                        digilib_book.book_type,
                                        digilib_book.book_year_launching,
                                        digilib_book.book_city_launching,
                                        (SELECT public_city.`city_name` FROM `public_city` WHERE `public_city`.`city_id` = digilib_book.`book_city_launching`) AS city_name,
                                        digilib_book.book_edition,
                                        digilib_book.book_language,
                                        digilib_book.book_resource,
                                        (SELECT digilib_resource.`resource_name` FROM `digilib_resource` WHERE `digilib_resource`.`resource_id` = digilib_book.`book_resource`) AS resource_name,
                                        digilib_book.book_fund,
                                        (SELECT digilib_fund.`fund_name` FROM `digilib_fund` WHERE `digilib_fund`.`fund_id` = digilib_book.`book_fund`) AS fund_name,
                                        digilib_book.book_price,
                                        digilib_book.book_isbn,
                                        digilib_book.book_cover,
                                        digilib_book.book_quantity,
                                        digilib_book.book_status,
                                        digilib_book.book_entry_date,
                                        digilib_book.book_review
                                   FROM
                                        digilib_book
                                   ORDER BY digilib_book.book_title LIMIT ' . $start . ',' . $count);
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

    public function countAll() {
        $sth = $this->db->prepare('SELECT * FROM digilib_book');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->rowCount();
    }
    
    public function createSave() {
        $sth = $this->db->prepare('
                    INSERT INTO
                    digilib_book(
                        book_id,
                        book_title,
                        book_sub_title,
                        book_ddc,
                        book_publisher,
                        book_type,
                        book_year_launching,
                        book_city_launching,
                        book_edition,
                        book_language,
                        book_resource,
                        book_fund,
                        book_accounting_symbol,
                        book_price,
                        book_isbn,
                        book_cover,
                        book_quantity,
                        book_width,
                        book_height,
                        book_weight,
                        book_status,
                        book_entry_date,
                        book_review)
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
                        :subtitle,
                        NULL,
                        :publisher,
                        NULL,
                        :year,
                        :city,
                        NULL,
                        :language,
                        :resource,
                        :fund,
                        :accounting_symbol,
                        :price,
                        :isbn,
                        NULL,
                        :quantity,
                        :width,
                        :height,
                        :weight,
                        NULL,
                        NOW(),
                        :review)
                ');

        $title = $this->method->post('title');
        $subtitle = $this->method->post('subtitle');
        $publisher = $this->method->post('publisher');
        $year = $this->method->post('year');
        $city = $this->method->post('city');
        $language = $this->method->post('language');
        $resource = $this->method->post('resource');
        $fund = $this->method->post('fund');
        $accounting_symbol = $this->method->post('accounting_symbol');
        $price = $this->method->post('price');
        $isbn = $this->method->post('isbn');
        $quantity = $this->method->post('quantity');
        $width = $this->method->post('width');
        $height = $this->method->post('height');
        $weight = $this->method->post('weight');
        $review = $this->method->post('review');

        $sth->bindValue(':resource', $resource, PDO::PARAM_NULL);
        
        return $sth->execute(array(
                    ':title' => $title,
                    ':subtitle' => $subtitle,
                    ':publisher' => $publisher,
                    ':year' => $year,
                    ':city' => $city,
                    ':language' => $language,
                    ':fund' => $fund,
                    ':accounting_symbol' => $accounting_symbol,
                    ':price' => $price,
                    ':isbn' => $isbn,
                    ':quantity' => $quantity,
                    ':width' => $width,
                    ':height' => $height,
                    ':weight' => $weight,
                    ':review' => $review
                ));
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
    
    public function selectAuthorByID($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_author.author_last_name
                            FROM
                                digilib_author
                            WHERE
                                digilib_author.book_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
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
        for ($idx=1970;$idx<=date('Y');$idx++) {
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
    
    public function selectCity($country_id=0) {
        $sth = $this->db->prepare('SELECT * FROM public_city WHERE country_id=:cid ORDER BY city_name');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':cid'=>$country_id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }
    
    public function selectDdcByLevel($level=0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=:level ORDER BY ddc_classification_number, ddc_title DESC');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':level'=>$level));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }
    
    public function selectDdcByParent($id=0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_parent=:id ORDER BY ddc_classification_number, ddc_title DESC');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id'=>$id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }
    
    public function selectAllDdcByLevel($level = 0, $start = 1, $count = 100) {
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_level=:level ORDER BY ddc_classification_number LIMIT ' . $start .',' . $count);
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
        $sth = $this->db->prepare('SELECT * FROM digilib_ddc WHERE ddc_parent=:parent ORDER BY ddc_classification_number LIMIT ' . $start .',' . $count);
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
                                   ORDER BY author_first_name LIMIT ' . $start . ',' . $count);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':session' => $sessionAuthor));
        return $sth->fetchAll();
    }
    
    public function countAllAuthorTemp($sessionAuthor = 0) {
        $sth = $this->db->prepare('SELECT * FROM digilib_author_temp WHERE session_id=:session');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':session'=>$sessionAuthor));
        return $sth->rowCount();
    }
    
    public function selectWriterTempBySession($sid = 0) {
        $sth = $this->db->prepare('SELECT *
                                   FROM
                                        digilib_author_temp
                                   WHERE
                                        digilib_author_temp.session_id = :session AND
                                        digilib_author_temp.author_description = 1
                                   ORDER BY author_first_name');
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
}