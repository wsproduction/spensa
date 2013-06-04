<?php

class PublisherModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllPublisher($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'publisher_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_publisher.publisher_id,
            digilib_publisher.publisher_name,
            digilib_publisher.publisher_description,
            digilib_publisher.publisher_entry,
            digilib_publisher.publisher_entry_update,
            (SELECT COUNT(digilib_publisher_office.publisher_office_id) FROM digilib_publisher_office WHERE digilib_publisher_office.publisher_office_name = digilib_publisher.publisher_id) AS publisher_office";

        $prepare = 'SELECT ' . $listSelect . ' FROM digilib_publisher';
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

    public function countAllPublisher() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(publisher_id) AS cnt FROM digilib_publisher';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectAllOffice($page = 1) {
        Session::init();

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            digilib_publisher_office_temp.publisher_office_temp_id,
            digilib_publisher_office_temp.publisher_office_temp_address,
            digilib_publisher_office_temp.publisher_office_temp_city,
            digilib_publisher_office_temp.publisher_office_temp_zipcode,
            digilib_publisher_office_temp.publisher_office_temp_phone,
            digilib_publisher_office_temp.publisher_office_temp_fax,
            digilib_publisher_office_temp.publisher_office_temp_email,
            digilib_publisher_office_temp.publisher_office_temp_website,
            digilib_publisher_office_temp.publisher_office_temp_department,
            digilib_publisher_office_temp.publisher_office_temp_session,
            digilib_publisher_office_department.publisher_office_department_name,
            public_city.city_name,
            public_province.province_name,
            public_country.country_name";

        $prepare = 'SELECT ' . $listSelect . ' 
                    FROM 
                        digilib_publisher_office_temp
                        INNER JOIN digilib_publisher_office_department ON (digilib_publisher_office_temp.publisher_office_temp_department = digilib_publisher_office_department.publisher_office_department_id)
                        INNER JOIN public_city ON (digilib_publisher_office_temp.publisher_office_temp_city = public_city.city_id)
                        INNER JOIN public_province ON (public_city.city_province = public_province.province_id)
                        INNER JOIN public_country ON (public_province.province_country = public_country.country_id)
                    WHERE digilib_publisher_office_temp.publisher_office_temp_session = :session ';
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

    public function countAllOffice() {
        Session::init();
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(publisher_office_temp_id) AS cnt FROM digilib_publisher_office_temp WHERE digilib_publisher_office_temp.publisher_office_temp_session = :session';
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

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                digilib_publisher.publisher_id,
                                digilib_publisher.publisher_name,
                                digilib_publisher.publisher_description,
                                digilib_publisher.publisher_entry,
                                digilib_publisher.publisher_entry_update
                            FROM
                                digilib_publisher
                            WHERE
                                digilib_publisher.publisher_id=:id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':id' => $id));
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function createSave() {

        $name = $this->method->post('name');
        $description = $this->method->post('description');

        $sth = $this->db->prepare('
                    INSERT INTO
                        digilib_publisher(
                            publisher_id,
                            publisher_name,
                            publisher_description,
                            publisher_entry,
                            publisher_entry_update)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(dp.publisher_id) 
                             FROM digilib_publisher AS dp) > 0, 
                                (SELECT dp.publisher_id 
                                 FROM digilib_publisher AS dp 
                                 ORDER BY dp.publisher_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :name,
                        :description,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':name', $name);
        $sth->bindValue(':description', $description);

        if ($sth->execute()) {
            $lastid = $this->db->lastInsID('publisher_id', 'digilib_publisher');
            if ($this->saveOffice($lastid)) {
                $this->clearOfficeTemp();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateSave($id = 0) {
        
        $name = $this->method->post('name');
        $description = $this->method->post('description');

        $sth = $this->db->prepare('
                    UPDATE
                        digilib_publisher
                    SET
                        publisher_name = :name,
                        publisher_description = :description,
                        publisher_entry_update = NOW()
                    WHERE
                        digilib_publisher.publisher_id = :id
                ');
        $sth->bindValue(':name', $name);
        $sth->bindValue(':description', $description);
        $sth->bindValue(':id', $id);
        
        return $sth->execute();
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM digilib_publisher WHERE digilib_publisher.publisher_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function deleteOffice($id) {
        $sth = $this->db->prepare('
                            DELETE
                            FROM
                                digilib_publisher_office_temp
                            WHERE
                                digilib_publisher_office_temp.publisher_office_temp_id IN (' . $id . ')');
        return $sth->execute();
    }

    public function clearOfficeTemp() {
        $listtemp = $this->selectOfficeBySession();
        $prepare = '0';
        foreach ($listtemp as $row) {
            $prepare .= ',' . $row['publisher_office_temp_id'];
        }
        return $this->deleteOffice($prepare);
    }

    public function selectDepartment() {
        $sth = $this->db->prepare('
                                SELECT 
                                    digilib_publisher_office_department.publisher_office_department_id,
                                    digilib_publisher_office_department.publisher_office_department_name
                                FROM
                                    digilib_publisher_office_department
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectCountry() {
        $sth = $this->db->prepare('
                                SELECT 
                                    public_country.country_id,
                                    public_country.country_name,
                                    public_country.country_status,
                                    public_country.country_entry,
                                    public_country.country_entry_update
                                FROM
                                    public_country
                                ORDER BY public_country.country_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
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
                                    public_province.province_country = :countryid
                                ORDER BY public_province.province_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':countryid', $id);
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
                                    public_city.city_province = :provinceid
                                ORDER BY public_city.city_name
                          ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':provinceid', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveOfficeTemp() {
        Session::init();

        $address = $this->method->post('address');
        $city = $this->method->post('city');
        $zipcode = $this->method->post('zipcode');
        $phone = $this->method->post('phone');
        $fax = $this->method->post('fax');
        $email = $this->method->post('email');
        $website = $this->method->post('website');
        $office_description = $this->method->post('office_description');

        $sth = $this->db->prepare('
                                INSERT INTO
                                    digilib_publisher_office_temp(
                                    publisher_office_temp_id,
                                    publisher_office_temp_address,
                                    publisher_office_temp_city,
                                    publisher_office_temp_zipcode,
                                    publisher_office_temp_phone,
                                    publisher_office_temp_fax,
                                    publisher_office_temp_email,
                                    publisher_office_temp_website,
                                    publisher_office_temp_department,
                                    publisher_office_temp_session)
                                VALUES(
                                    (SELECT IF(
                                        (SELECT COUNT(dpot.publisher_office_temp_id) 
                                            FROM digilib_publisher_office_temp AS dpot) > 0, 
                                            (SELECT dpot.publisher_office_temp_id 
                                                FROM digilib_publisher_office_temp AS dpot
                                                ORDER BY dpot.publisher_office_temp_id DESC LIMIT 1) + 1,
                                        1)
                                    ),
                                    :address,
                                    :city,
                                    :zipcode,
                                    :phone,
                                    :fax,
                                    :email,
                                    :website,
                                    :department,
                                    :session)
                            ');
        $sth->bindValue(':address', $address);
        $sth->bindValue(':city', $city);
        $sth->bindValue(':zipcode', $zipcode);
        $sth->bindValue(':phone', $phone);
        $sth->bindValue(':fax', $fax);
        $sth->bindValue(':email', $email);
        $sth->bindValue(':website', $website);
        $sth->bindValue(':department', $office_description);
        $sth->bindValue(':session', Session::id());
        return $sth->execute();
    }

    public function saveOffice($publisherid) {
        $listtemp = $this->selectOfficeBySession();
        $prepare = '';
        foreach ($listtemp as $row) {
            $prepare .= '
                            INSERT INTO
                            digilib_publisher_office(
                                publisher_office_id,
                                publisher_office_name,
                                publisher_office_address,
                                publisher_office_city,
                                publisher_office_zipcode,
                                publisher_office_phone,
                                publisher_office_fax,
                                publisher_office_email,
                                publisher_office_website,
                                publisher_office_department,
                                publisher_office_entry,
                                publisher_office_entry_update)
                            VALUES(
                                (SELECT IF(
                                    (SELECT COUNT(dpo.publisher_office_id) 
                                        FROM digilib_publisher_office AS dpo) > 0, 
                                        (SELECT dpo.publisher_office_id 
                                            FROM digilib_publisher_office AS dpo
                                            ORDER BY dpo.publisher_office_id DESC LIMIT 1) + 1,
                                    1)
                                ),
                                "' . $publisherid . '",
                                "' . $row['publisher_office_temp_address'] . '",
                                "' . $row['publisher_office_temp_city'] . '",
                                "' . $row['publisher_office_temp_zipcode'] . '",
                                "' . $row['publisher_office_temp_phone'] . '",
                                "' . $row['publisher_office_temp_fax'] . '",
                                "' . $row['publisher_office_temp_email'] . '",
                                "' . $row['publisher_office_temp_website'] . '",
                                "' . $row['publisher_office_temp_department'] . '",
                                NOW(),
                                NOW());
                        ';
        }

        $sth = $this->db->prepare($prepare);
        return $sth->execute();
    }

    public function selectOfficeBySession() {
        Session::init();
        $sth = $this->db->prepare('SELECT 
                                        digilib_publisher_office_temp.publisher_office_temp_id,
                                        digilib_publisher_office_temp.publisher_office_temp_address,
                                        digilib_publisher_office_temp.publisher_office_temp_city,
                                        digilib_publisher_office_temp.publisher_office_temp_zipcode,
                                        digilib_publisher_office_temp.publisher_office_temp_phone,
                                        digilib_publisher_office_temp.publisher_office_temp_fax,
                                        digilib_publisher_office_temp.publisher_office_temp_email,
                                        digilib_publisher_office_temp.publisher_office_temp_website,
                                        digilib_publisher_office_temp.publisher_office_temp_department,
                                        digilib_publisher_office_temp.publisher_office_temp_session
                                    FROM
                                        digilib_publisher_office_temp
                                    WHERE
                                        digilib_publisher_office_temp.publisher_office_temp_session = :session');
        $sth->bindValue(':session', Session::id());
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectPublisherOfficeByPublisherId($id = 0) {
        $sth = $this->db->prepare('SELECT 
                                    digilib_publisher_office.publisher_office_id,
                                    digilib_publisher_office.publisher_office_name,
                                    digilib_publisher_office.publisher_office_address,
                                    digilib_publisher_office.publisher_office_city,
                                    digilib_publisher_office.publisher_office_zipcode,
                                    digilib_publisher_office.publisher_office_phone,
                                    digilib_publisher_office.publisher_office_fax,
                                    digilib_publisher_office.publisher_office_email,
                                    digilib_publisher_office.publisher_office_website,
                                    digilib_publisher_office.publisher_office_department,
                                    digilib_publisher_office.publisher_office_entry,
                                    digilib_publisher_office.publisher_office_entry_update
                                  FROM
                                    digilib_publisher_office
                                  WHERE
                                    digilib_publisher_office.publisher_office_name = :id');
        $sth->bindValue(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function loadPublisherOfficeTemp($id = 0) {
        Session::init();
        $listoffice = $this->selectPublisherOfficeByPublisherId($id);
        
        $prepare = '';
        foreach ($listoffice as $value) {
            $prepare .= 'INSERT INTO
                                    digilib_publisher_office_temp(
                                    publisher_office_temp_id,
                                    publisher_office_temp_address,
                                    publisher_office_temp_city,
                                    publisher_office_temp_zipcode,
                                    publisher_office_temp_phone,
                                    publisher_office_temp_fax,
                                    publisher_office_temp_email,
                                    publisher_office_temp_website,
                                    publisher_office_temp_department,
                                    publisher_office_temp_session)
                                VALUES(
                                    (SELECT IF(
                                        (SELECT COUNT(dpot.publisher_office_temp_id) 
                                            FROM digilib_publisher_office_temp AS dpot) > 0, 
                                            (SELECT dpot.publisher_office_temp_id 
                                                FROM digilib_publisher_office_temp AS dpot
                                                ORDER BY dpot.publisher_office_temp_id DESC LIMIT 1) + 1,
                                        1)
                                    ),
                                    "' . $value['publisher_office_address'] . '",
                                    "' . $value['publisher_office_city'] . '",
                                    "' . $value['publisher_office_zipcode'] . '",
                                    "' . $value['publisher_office_phone'] . '",
                                    "' . $value['publisher_office_fax'] . '",
                                    "' . $value['publisher_office_email'] . '",
                                    "' . $value['publisher_office_website'] . '",
                                    "' . $value['publisher_office_department'] . '",
                                    :session);';
        }
        
        $sth = $this->db->prepare($prepare);
        $sth->bindValue(':session',Session::id());
        return $sth->execute();
    }

}