<?php

class Studentprofile extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
        Src::plugin()->jsAccounting();
    }

    public function index() {
        Web::setTitle('DAFTAR PELAMAR');

        $this->view->link_c = $this->content->setLink('studentprofile/create');
        $this->view->link_r = $this->content->setLink('studentprofile/read');
        $this->view->link_u = $this->content->setLink('studentprofile/update');
        $this->view->link_d = $this->content->setLink('studentprofile/delete');
        $this->view->link_filter = $this->content->setLink('studentprofile/readschoolprofile');
        $this->view->link_family = $this->content->setLink('studentprofile/readfamily');
        $this->view->option_date = $this->content->dayList();
        $this->view->option_moth = $this->content->monthList();
        $this->view->option_gender = $this->optionGender();
        $this->view->option_blood_group = $this->optionBloodGroup();
        $this->view->option_religion = $this->optionReligion();
        $this->view->option_education = $this->optionEducation();
        $this->view->option_jobs = $this->optionJobs();
        $this->view->option_family_relationship = $this->optionFamilyRelationschip();
        $this->view->table_report_score = $this->tableReportScore();
        $this->view->render('applicant/index');
    }

    public function read() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname', 'question_id');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('query', false);
            $param['qtype'] = $this->request->post('qtype', false);

            $list_data = $this->model->selectAllStudentProfile($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {

                $link_edit = URL::link($this->content->setLink('studentprofile/getdatastudentprofile/' . $value['applicant_id']), Src::image('1365588894_user_info.png', null, array('class' => 'icon_grid', 'title' => 'Edit Biodata Pelamar')), false, array('class' => 'edit'));
                $link_report_score = URL::link($this->content->setLink('studentprofile/getdatareportscore/' . $value['applicant_id']), Src::image('1365589927_report.png', null, array('class' => 'icon_grid', 'title' => 'Data Nilai Rapor')), false, array('class' => 'report_score'));
                $link_rank_class = URL::link($this->content->setLink('studentprofile/getdatarankclass/' . $value['applicant_id']), Src::image('1365589049_rank.png', null, array('class' => 'icon_grid', 'title' => 'Peringkat di Sekolah')), false, array('class' => 'rank_class'));
                $link_achievement = URL::link($this->content->setLink('studentprofile/getdatarankclass/' . $value['applicant_id']), Src::image('1365588680_bestseller.png', null, array('class' => 'icon_grid', 'title' => 'Data Prestasi')), false, array('class' => 'rank_class'));
                $link_family = URL::link($this->content->setLink('studentprofile/getdatafamily/' . $value['applicant_id']), Src::image('1365589090_agt_family.png', null, array('class' => 'icon_grid', 'title' => 'Data Keluarga Pelamar')), false, array('class' => 'family'));
                $link_education = URL::link($this->content->setLink('studentprofile/getdatarankclass/' . $value['applicant_id']), Src::image('1365589267_Student_3D.png', null, array('class' => 'icon_grid', 'title' => 'Riwayat Pindidikan Pelamar')), false, array('class' => 'rank_class'));

                $xml .= "<row id='" . $value['applicant_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['applicant_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['applicant_nisn'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['applicant_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['gender_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['religion_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['blood_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['applicant_birthplace'] . ', ' . date('d', strtotime($value['applicant_birthdate'])) . ' ' . $this->content->monthName(date('n', strtotime($value['applicant_birthdate']))) . ' ' . date('Y', strtotime($value['applicant_birthdate'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['applicant_height'] . ' Cm / ' . $value['applicant_weight'] . ' Kg' . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['applicant_disease'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['applicant_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['applicant_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . ' ' . $link_family . ' ' . $link_education . '  ' . $link_report_score . '  ' . $link_rank_class . ' ' . $link_achievement . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function create() {
        $param = array();
        $param['originally_school'] = $this->request->post('originally_school');
        $param['nisn'] = $this->request->post('nisn');
        $param['applicant_name'] = $this->request->post('applicant_name');
        $param['gender'] = $this->request->post('gender');
        $param['blood_group'] = $this->request->post('blood_group');
        $param['religion'] = $this->request->post('religion');
        $param['birthplace'] = $this->request->post('birthplace');
        $param['birthdate'] = $this->request->post('year') . '-' . $this->request->post('month') . '-' . $this->request->post('day');
        $param['height'] = $this->request->post('height');
        $param['weight'] = $this->request->post('weight');
        $param['suffered'] = $this->request->post('suffered');
        $param['period'] = 1;

        $res = array(false, $this->message->saveError());
        if ($this->model->saveStudentProfile($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function update() {
        $param = array();
        $param['id'] = $this->request->post('id');
        $param['originally_school'] = $this->request->post('originally_school');
        $param['nisn'] = $this->request->post('nisn');
        $param['applicant_name'] = $this->request->post('applicant_name');
        $param['gender'] = $this->request->post('gender');
        $param['blood_group'] = $this->request->post('blood_group');
        $param['religion'] = $this->request->post('religion');
        $param['birthplace'] = $this->request->post('birthplace');
        $param['birthdate'] = $this->request->post('year') . '-' . $this->request->post('month') . '-' . $this->request->post('day');
        $param['height'] = $this->request->post('height');
        $param['weight'] = $this->request->post('weight');
        $param['suffered'] = $this->request->post('suffered');
        $param['period'] = 1;

        $res = array(false, $this->message->saveError());
        if ($this->model->updateStudentProfile($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function delete() {
        $param = array();
        $param['id'] = $this->request->post('id');

        $res = false;
        if ($this->model->deleteStudentProfile($param)) {
            $res = true;
        }

        echo json_encode($res);
    }

    public function readSchoolProfile() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('keyword_text', false);
            $param['qtype'] = $this->request->post('keyword_category', false);

            $list_data = $this->model->selectAllSchoolProfile($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {
                $xml .= "<row id='" . $value['school_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['school_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_nss'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_address'] . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readFamily() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('keyword_text', false);
            $param['qtype'] = $this->request->post('keyword_category', false);

            $list_data = $this->model->selectAllFamily($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {
                $xml .= "<row id='" . $value['school_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['school_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_nss'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_address'] . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    private function optionGender() {
        $list = $this->model->selectAllGender();
        $option = array();
        foreach ($list as $value) {
            $option[$value['gender_id']] = $value['gender_title'];
        }
        return $option;
    }

    private function optionBloodGroup() {
        $list = $this->model->selectAllBloodGroup();
        $option = array();
        foreach ($list as $value) {
            $option[$value['blood_id']] = $value['blood_name'];
        }
        return $option;
    }

    private function optionReligion() {
        $list = $this->model->selectAllReligion();
        $option = array();
        foreach ($list as $value) {
            $option[$value['religion_id']] = $value['religion_name'];
        }
        return $option;
    }

    private function optionFamilyRelationschip() {
        $list = $this->model->selectAllFamilyRelationship();
        $option = array();
        foreach ($list as $value) {
            $option[$value['family_relationship_id']] = $value['family_relationship_title'];
        }
        return $option;
    }

    private function optionEducation() {
        $list = $this->model->selectAllEducation();
        $option = array();
        foreach ($list as $value) {
            $option[$value['education_id']] = $value['educaition_title'];
        }
        return $option;
    }

    private function optionJobs() {
        $list = $this->model->selectAllJobs();
        $option = array();
        foreach ($list as $value) {
            $option[$value['job_id']] = $value['job_name'];
        }
        return $option;
    }

    private function tableReportScore() {
        $list = $this->model->selectAllSubject();
        $table = '';
        $idx = 1;

        $option_score = array();
        for ($i = 1; $i <= 100; $i++) {
            $option_score[$i] = $i;
        }

        $temp_id = array();
        foreach ($list as $value) {

            $temp_id[] = $value['subject_id'];

            Form::create('select', 'smt_1_' . $value['subject_id']);
            Form::option($option_score, ' ');
            Form::style('brc_val');
            $select1 = Form::commit('attach');

            Form::create('select', 'smt_2_' . $value['subject_id']);
            Form::option($option_score, ' ');
            Form::style('brc_val');
            $select2 = Form::commit('attach');

            Form::create('select', 'smt_3_' . $value['subject_id']);
            Form::option($option_score, ' ');
            Form::style('brc_val');
            $select3 = Form::commit('attach');

            Form::create('select', 'smt_4_' . $value['subject_id']);
            Form::option($option_score, ' ');
            Form::style('brc_val');
            $select4 = Form::commit('attach');

            Form::create('select', 'smt_5_' . $value['subject_id']);
            Form::option($option_score, ' ');
            Form::style('brc_val');
            $select5 = Form::commit('attach');

            $table .= '<tr>';
            $table .= ' <td class="first" align="center"> ' . $idx . '. </td>';
            $table .= ' <td> ' . $value['subject_name'] . ' </td>';
            $table .= ' <td align="center"> ' . $select1 . ' </td>';
            $table .= ' <td align="center"> ' . $select2 . ' </td>';
            $table .= ' <td align="center"> ' . $select3 . ' </td>';
            $table .= ' <td align="center"> ' . $select4 . ' </td>';
            $table .= ' <td align="center"> ' . $select5 . ' </td>';
            $table .= '</tr>';
            $idx++;
        }

        $res = '<tbody temp_id="' . implode(',', $temp_id) . '">';
        $res .= $table;
        $res .= '</tbody>';

        return $res;
    }

    public function getDataStudentProfile($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectStudentProfileById($id);
        if (count($list) > 0) {
            $value = $list[0];
            $data['applicant_id'] = $value['applicant_id'];
            $data['applicant_school'] = $value['applicant_school'];
            $data['applicant_nisn'] = $value['applicant_nisn'];
            $data['applicant_name'] = $value['applicant_name'];
            $data['applicant_gender'] = $value['applicant_gender'];
            $data['applicant_blood_group'] = $value['applicant_blood_group'];
            $data['applicant_religion'] = $value['applicant_religion'];
            $data['applicant_birthplace'] = $value['applicant_birthplace'];
            $data['applicant_birthdate_d'] = date('d', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_m'] = date('n', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_y'] = date('Y', strtotime($value['applicant_birthdate']));
            $data['applicant_height'] = $value['applicant_height'];
            $data['applicant_weight'] = $value['applicant_weight'];
            $data['applicant_disease'] = $value['applicant_disease'];
            $data['applicant_period'] = $value['applicant_period'];
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

    public function getDataReportScore($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectStudentProfileById($id);
        if (count($list) > 0) {
            $value = $list[0];
            $data['applicant_id'] = $value['applicant_id'];
            $data['applicant_school'] = $value['applicant_school'];
            $data['applicant_name'] = $value['applicant_name'];
            $data['applicant_nisn'] = $value['applicant_nisn'];
            $data['applicant_gender'] = $value['applicant_gender'];
            $data['applicant_blood_group'] = $value['applicant_blood_group'];
            $data['applicant_religion'] = $value['applicant_religion'];
            $data['applicant_birthplace'] = $value['applicant_birthplace'];
            $data['applicant_birthdate_d'] = date('d', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_m'] = date('n', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_y'] = date('Y', strtotime($value['applicant_birthdate']));
            $data['applicant_height'] = $value['applicant_height'];
            $data['applicant_weight'] = $value['applicant_weight'];
            $data['applicant_disease'] = $value['applicant_disease'];
            $data['applicant_period'] = $value['applicant_period'];
            $data['gender_title'] = $value['gender_title'];
            $data['religion_name'] = $value['religion_name'];
            $data['blood_name'] = $value['blood_name'];
            $data['school_name'] = $value['school_name'];
            $data['list_report_score'] = $this->listReportScore($value['applicant_id']);
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

    private function listReportScore($id) {
        $report_score = $this->model->selectReportScore($id);
        $list = array();
        foreach ($report_score as $value) {
            $list[$value['score_subject']] = array(
                'smt1' => $value['score_c4_smt1'],
                'smt2' => $value['score_c4_smt2'],
                'smt3' => $value['score_c5_smt1'],
                'smt4' => $value['score_c5_smt2'],
                'smt5' => $value['score_c6_smt1']
            );
        }
        return $list;
    }

    public function createReportScore() {
        $applicant_id = $this->request->post('brc_id');
        $temp_id = $this->request->post('brc_tempid');
        $param = array();
        foreach (explode(',', $temp_id) as $value) {
            $param[$value]['score_applicant'] = $applicant_id;
            $param[$value]['score_c4_smt1'] = $this->request->post('smt_1_' . $value);
            $param[$value]['score_c4_smt2'] = $this->request->post('smt_2_' . $value);
            $param[$value]['score_c5_smt1'] = $this->request->post('smt_3_' . $value);
            $param[$value]['score_c5_smt2'] = $this->request->post('smt_4_' . $value);
            $param[$value]['score_c6_smt1'] = $this->request->post('smt_5_' . $value);
        }

        $res = array(false, $this->message->saveError());
        if ($this->model->saveReportScore($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function createFamily() {
        $param = array();
        $param['family_applicant_id'] = $this->request->post('family_applicant_id');
        $param['familyname'] = $this->request->post('familyname');
        $param['family_relationship'] = $this->request->post('family_relationship');
        $param['family_gender'] = $this->request->post('family_gender');
        $param['family_lasteducation'] = $this->request->post('family_lasteducation');
        $param['family_jobs'] = $this->request->post('family_jobs');
        $param['family_phone'] = $this->request->post('family_phone');
        $param['family_isparent'] = $this->request->post('family_isparent');
        
        $res = array(false, $this->message->saveError());
        if ($this->model->saveFamily($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function getDataRankClass($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectStudentProfileById($id);
        if (count($list) > 0) {
            $value = $list[0];
            $data['applicant_id'] = $value['applicant_id'];
            $data['applicant_school'] = $value['applicant_school'];
            $data['applicant_nisn'] = $value['applicant_nisn'];
            $data['applicant_name'] = $value['applicant_name'];
            $data['applicant_gender'] = $value['applicant_gender'];
            $data['applicant_blood_group'] = $value['applicant_blood_group'];
            $data['applicant_religion'] = $value['applicant_religion'];
            $data['applicant_birthplace'] = $value['applicant_birthplace'];
            $data['applicant_birthdate_d'] = date('d', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_m'] = date('n', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_y'] = date('Y', strtotime($value['applicant_birthdate']));
            $data['applicant_height'] = $value['applicant_height'];
            $data['applicant_weight'] = $value['applicant_weight'];
            $data['applicant_disease'] = $value['applicant_disease'];
            $data['applicant_period'] = $value['applicant_period'];
            $data['gender_title'] = $value['gender_title'];
            $data['religion_name'] = $value['religion_name'];
            $data['blood_name'] = $value['blood_name'];
            $data['school_name'] = $value['school_name'];
            $data['list_rank_class'] = $this->listRankScore($value['applicant_id']);
            $result = array(true, $data);
        }
        echo json_encode($result);
    }
    
    private function listRankScore($id) {
        $report_score = $this->model->selectRankClass($id);
        $list = array();
        foreach ($report_score as $value) {
            $list[1] = array(
                'r_smt1' => $value['rank_class_r4_smt1'],
                's_smt1' => $value['rank_class_s4_smt1'],
                'r_smt2' => $value['rank_class_r4_smt2'],
                's_smt2' => $value['rank_class_s4_smt2'],
                'r_smt3' => $value['rank_class_r5_smt1'],
                's_smt3' => $value['rank_class_s5_smt1'],
                'r_smt4' => $value['rank_class_r5_smt2'],
                's_smt4' => $value['rank_class_s5_smt2'],
                'r_smt5' => $value['rank_class_r6_smt1'],
                's_smt5' => $value['rank_class_s6_smt1']
            );
        }
        return $list;
    }
    
    public function createRankClass() {
        
        $param = array();
        $param['brank_id'] = $this->request->post('brank_id');
        $param['brank_r_smt1'] = $this->request->post('brank_r_smt1');
        $param['brank_s_smt1'] = $this->request->post('brank_s_smt1');
        $param['brank_r_smt2'] = $this->request->post('brank_r_smt2');
        $param['brank_s_smt2'] = $this->request->post('brank_s_smt2');
        $param['brank_r_smt3'] = $this->request->post('brank_r_smt3');
        $param['brank_s_smt3'] = $this->request->post('brank_s_smt3');
        $param['brank_r_smt4'] = $this->request->post('brank_r_smt4');
        $param['brank_s_smt4'] = $this->request->post('brank_s_smt4');
        $param['brank_r_smt5'] = $this->request->post('brank_r_smt5');
        $param['brank_s_smt5'] = $this->request->post('brank_s_smt5');
        
        $res = array(false, $this->message->saveError());
        if ($this->model->saveRankClass($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }
    
    public function getDataFamily($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectStudentProfileById($id);
        if (count($list) > 0) {
            $value = $list[0];
            $data['applicant_id'] = $value['applicant_id'];
            $data['applicant_school'] = $value['applicant_school'];
            $data['applicant_nisn'] = $value['applicant_nisn'];
            $data['applicant_name'] = $value['applicant_name'];
            $data['applicant_gender'] = $value['applicant_gender'];
            $data['applicant_blood_group'] = $value['applicant_blood_group'];
            $data['applicant_religion'] = $value['applicant_religion'];
            $data['applicant_birthplace'] = $value['applicant_birthplace'];
            $data['applicant_birthdate_d'] = date('d', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_m'] = date('n', strtotime($value['applicant_birthdate']));
            $data['applicant_birthdate_y'] = date('Y', strtotime($value['applicant_birthdate']));
            $data['applicant_height'] = $value['applicant_height'];
            $data['applicant_weight'] = $value['applicant_weight'];
            $data['applicant_disease'] = $value['applicant_disease'];
            $data['applicant_period'] = $value['applicant_period'];
            $data['gender_title'] = $value['gender_title'];
            $data['religion_name'] = $value['religion_name'];
            $data['blood_name'] = $value['blood_name'];
            $data['school_name'] = $value['school_name'];
            $data['list_rank_class'] = $this->listRankScore($value['applicant_id']);
            $result = array(true, $data);
        }
        echo json_encode($result);
    }
}