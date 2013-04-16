<?php

class StudentprofileModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllStudentProfile($param) {
        $prepare = ' SELECT 
                        ppdb_applicant_profile.applicant_id,
                        ppdb_applicant_profile.applicant_school,
                        ppdb_applicant_profile.applicant_nisn,
                        ppdb_applicant_profile.applicant_name,
                        ppdb_applicant_profile.applicant_gender,
                        ppdb_applicant_profile.applicant_religion,
                        ppdb_applicant_profile.applicant_blood_group,
                        ppdb_applicant_profile.applicant_birthplace,
                        ppdb_applicant_profile.applicant_birthdate,
                        ppdb_applicant_profile.applicant_height,
                        ppdb_applicant_profile.applicant_weight,
                        ppdb_applicant_profile.applicant_disease,
                        ppdb_applicant_profile.applicant_period,
                        ppdb_applicant_profile.applicant_entry,
                        ppdb_applicant_profile.applicant_entry_update,
                        public_gender.gender_title,
                        public_religion.religion_name,
                        public_blood_group.blood_name,
                        ppdb_school_profile.school_name
                      FROM
                        ppdb_applicant_profile
                        INNER JOIN public_gender ON (ppdb_applicant_profile.applicant_gender = public_gender.gender_id)
                        INNER JOIN public_religion ON (ppdb_applicant_profile.applicant_religion = public_religion.religion_id)
                        INNER JOIN public_blood_group ON (ppdb_applicant_profile.applicant_blood_group = public_blood_group.blood_id)
                        INNER JOIN ppdb_school_profile ON (ppdb_applicant_profile.applicant_school = ppdb_school_profile.school_id)';

        if ($param['query'])
            $prepare .= ' WHERE ' . $param['qtype'] . ' LIKE "%' . $param['query'] . '%" ';

        $prepare .= ' ORDER BY ' . $param['sortname'] . ' ' . $param['sortorder'];

        $start = (($param['page'] - 1) * $param['rp']);
        $prepare .= ' LIMIT ' . $start . ',' . $param['rp'];

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveStudentProfile($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        ppdb_applicant_profile(
                        applicant_id,
                        applicant_school,
                        applicant_nisn,
                        applicant_name,
                        applicant_gender,
                        applicant_religion,
                        applicant_blood_group,
                        applicant_birthplace,
                        applicant_birthdate,
                        applicant_height,
                        applicant_weight,
                        applicant_disease,
                        applicant_period,
                        applicant_entry,
                        applicant_entry_update)
                      VALUES(
                        ( SELECT IF (
                            (SELECT COUNT(e.applicant_id) FROM ppdb_applicant_profile AS e 
                                    WHERE e.applicant_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.applicant_id DESC LIMIT 1
                            ) > 0,
                            (SELECT ( e.applicant_id + 1 ) FROM ppdb_applicant_profile AS e 
                                    WHERE e.applicant_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                    ORDER BY e.applicant_id DESC LIMIT 1),
                            (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"0001")))
                        ),
                        :originally_school,
                        :nisn,
                        :applicant_name,
                        :gender,
                        :religion,
                        :blood_group,
                        :birthplace,
                        :birthdate,
                        :height,
                        :weight,
                        :suffered,
                        :period,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':originally_school', $param['originally_school']);
        $sth->bindValue(':nisn', $param['nisn']);
        $sth->bindValue(':applicant_name', $param['applicant_name']);
        $sth->bindValue(':gender', $param['gender']);
        $sth->bindValue(':religion', $param['religion']);
        $sth->bindValue(':blood_group', $param['blood_group']);
        $sth->bindValue(':birthplace', $param['birthplace']);
        $sth->bindValue(':birthdate', $param['birthdate']);
        $sth->bindValue(':height', $param['height']);
        $sth->bindValue(':weight', $param['weight']);
        $sth->bindValue(':suffered', $param['suffered']);
        $sth->bindValue(':period', $param['period']);

        return $sth->execute();
    }

    public function updateStudentProfile($param) {

        $sth = $this->db->prepare('
                      UPDATE
                        ppdb_applicant_profile
                      SET
                        applicant_school = :originally_school,
                        applicant_nisn = :nisn,
                        applicant_name = :applicant_name,
                        applicant_gender = :gender,
                        applicant_religion = :religion,
                        applicant_blood_group = :blood_group,
                        applicant_birthplace = :birthplace,
                        applicant_birthdate = :birthdate,
                        applicant_height = :height,
                        applicant_weight = :weight,
                        applicant_disease = :suffered,
                        applicant_period = :period,
                        applicant_entry_update = NOW()
                      WHERE
                        ppdb_applicant_profile.applicant_id = :id
                ');

        $sth->bindValue(':originally_school', $param['originally_school']);
        $sth->bindValue(':applicant_name', $param['applicant_name']);
        $sth->bindValue(':nisn', $param['nisn']);
        $sth->bindValue(':gender', $param['gender']);
        $sth->bindValue(':religion', $param['religion']);
        $sth->bindValue(':blood_group', $param['blood_group']);
        $sth->bindValue(':birthplace', $param['birthplace']);
        $sth->bindValue(':birthdate', $param['birthdate']);
        $sth->bindValue(':height', $param['height']);
        $sth->bindValue(':weight', $param['weight']);
        $sth->bindValue(':suffered', $param['suffered']);
        $sth->bindValue(':period', $param['period']);
        $sth->bindValue(':id', $param['id']);

        return $sth->execute();
    }

    public function deleteStudentProfile($param) {
        $sth = $this->db->prepare('DELETE FROM ppdb_applicant_profile WHERE ppdb_applicant_profile.applicant_id IN (' . $param['id'] . ')');
        return $sth->execute();
    }

    public function selectAllSchoolProfile($param) {
        $prepare = ' SELECT 
                       ppdb_school_profile.school_id,
                       ppdb_school_profile.school_nss,
                       ppdb_school_profile.school_name,
                       ppdb_school_profile.school_address,
                       ppdb_school_profile.school_rt,
                       ppdb_school_profile.school_rw,
                       ppdb_school_profile.school_village,
                       ppdb_school_profile.school_subdistric,
                       ppdb_school_profile.school_distric,
                       ppdb_school_profile.school_province,
                       ppdb_school_profile.school_zipcode,
                       ppdb_school_profile.school_phone,
                       ppdb_school_profile.school_entry,
                       ppdb_school_profile.school_entry_update
                     FROM
                       ppdb_school_profile ';

        if ($param['query'])
            $prepare .= ' WHERE ' . $param['qtype'] . ' LIKE "%' . $param['query'] . '%" ';

        $prepare .= ' ORDER BY ' . $param['sortname'] . ' ' . $param['sortorder'];

        $start = (($param['page'] - 1) * $param['rp']);
        $prepare .= ' LIMIT ' . $start . ',' . $param['rp'];

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllGender() {
        $sth = $this->db->prepare('SELECT 
                                    public_gender.gender_id,
                                    public_gender.gender_title
                                  FROM
                                    public_gender');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllBloodGroup() {
        $sth = $this->db->prepare('SELECT 
                                    public_blood_group.blood_id,
                                    public_blood_group.blood_name,
                                    public_blood_group.blood_entry,
                                    public_blood_group.blood_entry_update
                                  FROM
                                    public_blood_group');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllReligion() {
        $sth = $this->db->prepare('SELECT 
                                    public_religion.religion_id,
                                    public_religion.religion_name,
                                    public_religion.religion_isother,
                                    public_religion.religion_entry,
                                    public_religion.religion_entry_update
                                  FROM
                                    public_religion');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllFamilyRelationship() {
        $sth = $this->db->prepare('SELECT 
                                    public_family_relationship.family_relationship_id,
                                    public_family_relationship.family_relationship_title
                                  FROM
                                    public_family_relationship');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllEducation() {
        $sth = $this->db->prepare('SELECT 
                                    public_education.education_id,
                                    public_education.educaition_title,
                                    public_education.education_entry,
                                    public_education.education_entry_update
                                  FROM
                                    public_education');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllJobs() {
        $sth = $this->db->prepare('SELECT 
                                    public_job.job_id,
                                    public_job.job_name,
                                    public_job.job_isother,
                                    public_job.job_entry,
                                    public_job.job_entry_update
                                  FROM
                                    public_job');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectStudentProfileById($id) {
        $sth = $this->db->prepare('SELECT 
                                    ppdb_applicant_profile.applicant_id,
                                    ppdb_applicant_profile.applicant_school,
                                    ppdb_applicant_profile.applicant_nisn,
                                    ppdb_applicant_profile.applicant_name,
                                    ppdb_applicant_profile.applicant_gender,
                                    ppdb_applicant_profile.applicant_religion,
                                    ppdb_applicant_profile.applicant_blood_group,
                                    ppdb_applicant_profile.applicant_birthplace,
                                    ppdb_applicant_profile.applicant_birthdate,
                                    ppdb_applicant_profile.applicant_height,
                                    ppdb_applicant_profile.applicant_weight,
                                    ppdb_applicant_profile.applicant_disease,
                                    ppdb_applicant_profile.applicant_period,
                                    ppdb_applicant_profile.applicant_entry,
                                    ppdb_applicant_profile.applicant_entry_update,
                                    public_gender.gender_title,
                                    public_religion.religion_name,
                                    public_blood_group.blood_name,
                                    ppdb_school_profile.school_name
                                  FROM
                                    ppdb_applicant_profile
                                    INNER JOIN public_gender ON (ppdb_applicant_profile.applicant_gender = public_gender.gender_id)
                                    INNER JOIN public_religion ON (ppdb_applicant_profile.applicant_religion = public_religion.religion_id)
                                    INNER JOIN public_blood_group ON (ppdb_applicant_profile.applicant_blood_group = public_blood_group.blood_id)
                                    INNER JOIN ppdb_school_profile ON (ppdb_applicant_profile.applicant_school = ppdb_school_profile.school_id)
                                  WHERE
                                    ppdb_applicant_profile.applicant_id = :id
                                  ');

        $sth->bindValue(':id', $id);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectReportScore($id) {
        $sth = $this->db->prepare('SELECT 
                                    ppdb_report_score.score_id,
                                    ppdb_report_score.score_applicant,
                                    ppdb_report_score.score_subject,
                                    ppdb_report_score.score_c4_smt1,
                                    ppdb_report_score.score_c4_smt2,
                                    ppdb_report_score.score_c5_smt1,
                                    ppdb_report_score.score_c5_smt2,
                                    ppdb_report_score.score_c6_smt1,
                                    ppdb_report_score.score_entry,
                                    ppdb_report_score.score_entry_update
                                  FROM
                                    ppdb_report_score
                                  WHERE
                                    ppdb_report_score.score_applicant = :id
                                  ');

        $sth->bindValue(':id', $id);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectAllSubject() {
        $sth = $this->db->prepare(' SELECT 
                                        ppdb_subject.subject_id,
                                        ppdb_subject.subject_name,
                                        ppdb_subject.subject_entry,
                                        ppdb_subject.subject_entry_update
                                      FROM
                                        ppdb_subject');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveReportScore($param) {

        $this->db->beginTransaction();
        try {

            foreach ($param as $key => $value) {

                $temp_data = $this->selectReportScoreByApplicantAndSubejct($value['score_applicant'], $key);
                if (count($temp_data) > 0) {
                    $data = $temp_data[0];
                    $sth = $this->db->prepare('UPDATE
                                                ppdb_report_score
                                              SET
                                                score_c4_smt1 = :smt1,
                                                score_c4_smt2 = :smt2,
                                                score_c5_smt1 = :smt3,
                                                score_c5_smt2 = :smt4,
                                                score_c6_smt1 = :smt5,
                                                score_entry_update = NOW()
                                              WHERE
                                                ppdb_report_score.score_id = :id');

                    $sth->bindValue(':id', $data['score_id']);
                    $sth->bindValue(':smt1', $value['score_c4_smt1']);
                    $sth->bindValue(':smt2', $value['score_c4_smt2']);
                    $sth->bindValue(':smt3', $value['score_c5_smt1']);
                    $sth->bindValue(':smt4', $value['score_c5_smt2']);
                    $sth->bindValue(':smt5', $value['score_c6_smt1']);
                    $sth->execute();
                } else {
                    $sth = $this->db->prepare('INSERT INTO
                                            ppdb_report_score(
                                            score_id,
                                            score_applicant,
                                            score_subject,
                                            score_c4_smt1,
                                            score_c4_smt2,
                                            score_c5_smt1,
                                            score_c5_smt2,
                                            score_c6_smt1,
                                            score_entry,
                                            score_entry_update)
                                          VALUES(
                                            ( SELECT IF (
                                                (SELECT COUNT(e.score_id) FROM ppdb_report_score AS e 
                                                        WHERE e.score_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                                        ORDER BY e.score_id DESC LIMIT 1
                                                ) > 0,
                                                (SELECT ( e.score_id + 1 ) FROM ppdb_report_score AS e 
                                                        WHERE e.score_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                                        ORDER BY e.score_id DESC LIMIT 1),
                                                (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"000001")))
                                            ),
                                            :applicant,
                                            :subject,
                                            :smt1,
                                            :smt2,
                                            :smt3,
                                            :smt4,
                                            :smt5,
                                            NOW(),
                                            NOW())');
                    $sth->bindValue(':applicant', $value['score_applicant']);
                    $sth->bindValue(':subject', $key);
                    $sth->bindValue(':smt1', $value['score_c4_smt1']);
                    $sth->bindValue(':smt2', $value['score_c4_smt2']);
                    $sth->bindValue(':smt3', $value['score_c5_smt1']);
                    $sth->bindValue(':smt4', $value['score_c5_smt2']);
                    $sth->bindValue(':smt5', $value['score_c6_smt1']);
                    $sth->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
    }

    private function selectReportScoreByApplicantAndSubejct($applicant, $subject) {
        $sth = $this->db->prepare(' SELECT 
                                        ppdb_report_score.score_id
                                      FROM
                                        ppdb_report_score
                                      WHERE
                                        ppdb_report_score.score_applicant = :applicant AND 
                                        ppdb_report_score.score_subject = :subject');
        $sth->bindValue(':applicant', $applicant);
        $sth->bindValue(':subject', $subject);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectRankClass($id) {
        $sth = $this->db->prepare('SELECT 
                                        ppdb_rank_class.rank_class_id,
                                        ppdb_rank_class.rank_class_applicant,
                                        ppdb_rank_class.rank_class_r4_smt1,
                                        ppdb_rank_class.rank_class_s4_smt1,
                                        ppdb_rank_class.rank_class_r4_smt2,
                                        ppdb_rank_class.rank_class_s4_smt2,
                                        ppdb_rank_class.rank_class_r5_smt1,
                                        ppdb_rank_class.rank_class_s5_smt1,
                                        ppdb_rank_class.rank_class_r5_smt2,
                                        ppdb_rank_class.rank_class_s5_smt2,
                                        ppdb_rank_class.rank_class_r6_smt1,
                                        ppdb_rank_class.rank_class_s6_smt1,
                                        ppdb_rank_class.rank_class_entry,
                                        ppdb_rank_class.rank_class_entry_update
                                      FROM
                                        ppdb_rank_class
                                      WHERE
                                        ppdb_rank_class.rank_class_applicant = :id
                                  ');

        $sth->bindValue(':id', $id);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function saveRankClass($param) {

        $this->db->beginTransaction();
        try {

            $temp_data = $this->selectRankClass($param['brank_id']);
            if (count($temp_data) > 0) {
                $data = $temp_data[0];
                $sth = $this->db->prepare('  UPDATE
                                                ppdb_rank_class
                                              SET
                                                rank_class_r4_smt1 = :brank_r_smt1,
                                                rank_class_s4_smt1 = :brank_s_smt1,
                                                rank_class_r4_smt2 = :brank_r_smt2,
                                                rank_class_s4_smt2 = :brank_s_smt2,
                                                rank_class_r5_smt1 = :brank_r_smt3,
                                                rank_class_s5_smt1 = :brank_s_smt3,
                                                rank_class_r5_smt2 = :brank_r_smt4,
                                                rank_class_s5_smt2 = :brank_s_smt4,
                                                rank_class_r6_smt1 = :brank_r_smt5,
                                                rank_class_s6_smt1 = :brank_s_smt5,
                                                rank_class_entry_update = NOW()
                                              WHERE
                                                ppdb_rank_class.rank_class_id = :id');

                $sth->bindValue(':id', $data['rank_class_id']);
                $sth->bindValue(':brank_r_smt1', $param['brank_r_smt1']);
                $sth->bindValue(':brank_s_smt1', $param['brank_s_smt1']);
                $sth->bindValue(':brank_r_smt2', $param['brank_r_smt2']);
                $sth->bindValue(':brank_s_smt2', $param['brank_s_smt2']);
                $sth->bindValue(':brank_r_smt3', $param['brank_r_smt3']);
                $sth->bindValue(':brank_s_smt3', $param['brank_s_smt3']);
                $sth->bindValue(':brank_r_smt4', $param['brank_r_smt4']);
                $sth->bindValue(':brank_s_smt4', $param['brank_s_smt4']);
                $sth->bindValue(':brank_r_smt5', $param['brank_r_smt5']);
                $sth->bindValue(':brank_s_smt5', $param['brank_s_smt5']);
                $sth->execute();
            } else {
                $sth = $this->db->prepare('INSERT INTO
                                            ppdb_rank_class(
                                            rank_class_id,
                                            rank_class_applicant,
                                            rank_class_r4_smt1,
                                            rank_class_s4_smt1,
                                            rank_class_r4_smt2,
                                            rank_class_s4_smt2,
                                            rank_class_r5_smt1,
                                            rank_class_s5_smt1,
                                            rank_class_r5_smt2,
                                            rank_class_s5_smt2,
                                            rank_class_r6_smt1,
                                            rank_class_s6_smt1,
                                            rank_class_entry,
                                            rank_class_entry_update)
                                          VALUES(
                                            ( SELECT IF (
                                                (SELECT COUNT(e.rank_class_id) FROM ppdb_rank_class AS e 
                                                        WHERE e.rank_class_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                                        ORDER BY e.rank_class_id DESC LIMIT 1
                                                ) > 0,
                                                (SELECT ( e.rank_class_id + 1 ) FROM ppdb_rank_class AS e 
                                                        WHERE e.rank_class_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                                        ORDER BY e.rank_class_id DESC LIMIT 1),
                                                (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"0001")))
                                            ),
                                            :applicant,
                                            :brank_r_smt1,
                                            :brank_s_smt1,
                                            :brank_r_smt2,
                                            :brank_s_smt2,
                                            :brank_r_smt3,
                                            :brank_s_smt3,
                                            :brank_r_smt4,
                                            :brank_s_smt4,
                                            :brank_r_smt5,
                                            :brank_s_smt5,
                                            NOW(),
                                            NOW())');
                
                $sth->bindValue(':applicant', $param['brank_id']);
                $sth->bindValue(':brank_r_smt1', $param['brank_r_smt1']);
                $sth->bindValue(':brank_s_smt1', $param['brank_s_smt1']);
                $sth->bindValue(':brank_r_smt2', $param['brank_r_smt2']);
                $sth->bindValue(':brank_s_smt2', $param['brank_s_smt2']);
                $sth->bindValue(':brank_r_smt3', $param['brank_r_smt3']);
                $sth->bindValue(':brank_s_smt3', $param['brank_s_smt3']);
                $sth->bindValue(':brank_r_smt4', $param['brank_r_smt4']);
                $sth->bindValue(':brank_s_smt4', $param['brank_s_smt4']);
                $sth->bindValue(':brank_r_smt5', $param['brank_r_smt5']);
                $sth->bindValue(':brank_s_smt5', $param['brank_s_smt5']);
                $sth->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $exc) {
            $this->db->rollBack();
            return false;
        }
    }
    
    public function selectAllFamily($param) {
        $prepare = ' SELECT 
                       ppdb_school_profile.school_id,
                       ppdb_school_profile.school_nss,
                       ppdb_school_profile.school_name,
                       ppdb_school_profile.school_address,
                       ppdb_school_profile.school_rt,
                       ppdb_school_profile.school_rw,
                       ppdb_school_profile.school_village,
                       ppdb_school_profile.school_subdistric,
                       ppdb_school_profile.school_distric,
                       ppdb_school_profile.school_province,
                       ppdb_school_profile.school_zipcode,
                       ppdb_school_profile.school_phone,
                       ppdb_school_profile.school_entry,
                       ppdb_school_profile.school_entry_update
                     FROM
                       ppdb_school_profile ';

        if ($param['query'])
            $prepare .= ' WHERE ' . $param['qtype'] . ' LIKE "%' . $param['query'] . '%" ';

        $prepare .= ' ORDER BY ' . $param['sortname'] . ' ' . $param['sortorder'];

        $start = (($param['page'] - 1) * $param['rp']);
        $prepare .= ' LIMIT ' . $start . ',' . $param['rp'];

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function saveFamily($param) {
        $sth = $this->db->prepare('
                    INSERT INTO
                        ppdb_appilicant_family(
                        family_id,
                        family_applicant,
                        family_relationship,
                        family_name,
                        family_gender,
                        family_lasteducation,
                        family_jobs,
                        family_phone,
                        family_is_parent,
                        family_entry,
                        family_entry_update)
                      VALUES(
                        ( SELECT IF (
                                                (SELECT COUNT(e.rank_class_id) FROM ppdb_rank_class AS e 
                                                        WHERE e.rank_class_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                                        ORDER BY e.rank_class_id DESC LIMIT 1
                                                ) > 0,
                                                (SELECT ( e.rank_class_id + 1 ) FROM ppdb_rank_class AS e 
                                                        WHERE e.rank_class_id  LIKE  (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"%")) 
                                                        ORDER BY e.rank_class_id DESC LIMIT 1),
                                                (SELECT CONCAT(DATE_FORMAT(CURDATE(),"%y%m"),"0001")))
                                            ),
                        :family_applicant_id,
                        :family_relationship,
                        :familyname,
                        :family_gender,
                        :family_lasteducation,
                        :family_jobs,
                        :family_phone,
                        :family_isparent,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':family_applicant_id', $param['family_applicant_id']);
        $sth->bindValue(':family_relationship', $param['family_relationship']);
        $sth->bindValue(':familyname', $param['familyname']);
        $sth->bindValue(':family_gender', $param['family_gender']);
        $sth->bindValue(':family_lasteducation', $param['family_lasteducation']);
        $sth->bindValue(':family_jobs', $param['family_jobs']);
        $sth->bindValue(':family_phone', $param['family_phone']);
        $sth->bindValue(':family_isparent', $param['family_isparent']);

        return $sth->execute();
    }
}