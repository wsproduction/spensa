<?php

class ScoreModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectScore($id) {
        return array(
            array(
                'subject_id' => '00001',
                'subject_name' => 'Teknologi Informasi dan Komunikasi',
                'teacher_name' => 'Iman Muttaqin, S.Kom.',
                'kkm' => 85,
                'score' => 90
            ),
            array(
                'subject_id' => '00002',
                'subject_name' => 'Pendidikan Agama Islam',
                'teacher_name' => 'Hj. Titi Reswati, S.Pd.',
                'kkm' => 78,
                'score' => 78
            ),
            array(
                'subject_id' => '00003',
                'subject_name' => 'Pendidikan Kewarganegaraan',
                'teacher_name' => 'Budi Sagitariawan, S.Pd.',
                'kkm' => 78,
                'score' => 78
            ),
            array(
                'subject_id' => '00004',
                'subject_name' => 'Bahasa Indonesia',
                'teacher_name' => 'Joko Triyoga N., S.Pd.',
                'kkm' => 78,
                'score' => 76
            ),
            array(
                'subject_id' => '00005',
                'subject_name' => 'Bahasa Inggris',
                'teacher_name' => 'Budi Kusnadi, S.Pd.',
                'kkm' => 76,
                'score' => 70
            ),
            array(
                'subject_id' => '00006',
                'subject_name' => 'Matematika',
                'teacher_name' => 'Asep Wahyudin, S.Pd.,M.M.Pd.',
                'kkm' => 76,
                'score' => 75
            ),
            array(
                'subject_id' => '00007',
                'subject_name' => 'Ilmu Pengetahuan Alam',
                'teacher_name' => 'Euis Haura, S.Pd.',
                'kkm' => 80,
                'score' => 78
            ),
            array(
                'subject_id' => '00008',
                'subject_name' => 'Ilmu Pengetahuan Sosial',
                'teacher_name' => 'Siswati Marlina, S.Pd.Ek',
                'kkm' => 79,
                'score' => 80
            ),
            array(
                'subject_id' => '00009',
                'subject_name' => 'Seni Budaya',
                'teacher_name' => 'Oktafiyanti, S.Sn.',
                'kkm' => 80,
                'score' => 80
            ),
            array(
                'subject_id' => '00010',
                'subject_name' => 'Penjaskes',
                'teacher_name' => 'Budi Ramdani, S.Si.',
                'kkm' => 81,
                'score' => 89
            ),
            array(
                'subject_id' => '00011',
                'subject_name' => 'Bahasa Sunda',
                'teacher_name' => 'Ii Heri Hermawan, S.Pd.',
                'kkm' => 78,
                'score' => 78
            ),
            array(
                'subject_id' => '00012',
                'subject_name' => 'PC Assembling',
                'teacher_name' => 'Iman Muttaqin',
                'kkm' => 81,
                'score' => 85
            )
        );
    }
    
    public function selectAllSemester() {
        $sth = $this->db->prepare('SELECT * FROM academic_semester');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllPeriod() {
        $sth = $this->db->prepare('SELECT * FROM academic_period');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllRecapitulation() {
        $sth = $this->db->prepare('SELECT * FROM academic_recapitulation_type');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function selectAllSubject() {
        $sth = $this->db->prepare('SELECT * FROM academic_subject');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

}