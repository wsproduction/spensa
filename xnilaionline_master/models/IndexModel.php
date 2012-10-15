<?php

class IndexModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function saveStudent($nis, $kelas, $nama, $tahunAjaran) {
        $sth = $this->db->prepare('SELECT student_id FROM public_student WHERE student_register_number=:nis');
        $sth->bindValue(':nis', $nis);
        if ($sth->execute()) {
            $tempId = $sth->fetchAll();
            $studentId = $tempId[0]['student_id'];
            //echo $studentId . '<br>';
            $sth2 = $this->db->prepare('INSERT INTO
                                        public_class_history(
                                        school_year,
                                        student_id,
                                        class_id)
                                    VALUES(
                                        :thAjaran,
                                        :id,
                                        :kelas)');
            $sth2->bindValue(':thAjaran', $tahunAjaran);
            $sth2->bindValue(':id', $studentId);
            $sth2->bindValue(':kelas', $kelas);
            $sth2->execute();
        }
        /*$sth = $this->db->prepare('INSERT INTO
                                    public_student(
                                        student_register_number,
                                        student_full_name,
                                        student_password)
                                    VALUES(
                                        :nis,
                                        :nama,
                                        MD5(:nis))');
        $sth->bindValue(':nis', $nis);
        $sth->bindValue(':nama', $nama);
        if ($sth->execute()) {
            $student_id = $this->db->lastInsID('student_id', 'public_student');

            $sth2 = $this->db->prepare('INSERT INTO
                                        public_class_history(
                                        school_year,
                                        student_id,
                                        class_id)
                                    VALUES(
                                        :thAjaran,
                                        :id,
                                        :kelas)');
            $sth2->bindValue(':thAjaran', $tahunAjaran);
            $sth2->bindValue(':id', $student_id);
            $sth2->bindValue(':kelas', $kelas);
            $sth2->execute();
        }*/
        
    }

}