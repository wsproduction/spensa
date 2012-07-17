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
                                        (SELECT digilib_ddc.ddc_call_number FROM digilib_ddc WHERE digilib_ddc.ddc_id = digilib_book.book_ddc) AS call_number,
                                        digilib_book.book_publisher,
                                        (SELECT digilib_publisher.publisher_name FROM digilib_publisher WHERE digilib_publisher.publisher_id) AS publisher_name,
                                        digilib_book.book_type,
                                        digilib_book.book_year_launching,
                                        digilib_book.book_city_launching,
                                        (SELECT public_city.city_name FROM public_city WHERE public_city.city_id = digilib_book.book_city_launching) AS city_name,
                                        digilib_book.book_edition,
                                        digilib_book.book_language,
                                        digilib_book.book_resource,
                                        digilib_book.book_fund,
                                        (SELECT digilib_book_fund.fund_name FROM digilib_book_fund WHERE digilib_book_fund.`fund_id` = digilib_book.book_fund) AS fund_name,
                                        digilib_book.book_price,
                                        digilib_book.book_isbn,
                                        digilib_book.book_cover,
                                        digilib_book.book_quantity,
                                        digilib_book.book_status,
                                        digilib_book.book_entry_date,
                                        digilib_book.book_review,
                                        digilib_book_resource.resource_name
                                   FROM
                                        digilib_book
                                   INNER JOIN digilib_book_resource ON (digilib_book.book_resource = digilib_book_resource.resource_id)
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
    
    public function selectAuthor($id) {
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

}