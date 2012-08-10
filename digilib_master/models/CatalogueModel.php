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
                    digilib_writer(
                        writer_name,
                        writer_profile)
                    VALUES(
                        :name,
                        :profile)
                ');

        $name = trim($_POST['name']);
        $address = trim($_POST['profile']);

        return $sth->execute(array(
                    ':name' => $name,
                    ':profile' => $address
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
    
    public function selectAuthorByID($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_author.author_last_name
                            FROM
                                digilib_author_detail
                            INNER JOIN digilib_author ON (digilib_author_detail.author_id = digilib_author.author_id)
                            WHERE
                                digilib_author_detail.book_id = :id');
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

}