<?php

class Teacher extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        
    }

    public function attendance() {
        Web::setTitle('Daftar Hadir Guru');
        $this->view->link_r = $this->content->setLink('teacher/read');
        $this->view->link_c = $this->content->setLink('teacher/add');
        $this->view->link_d = $this->content->setLink('teacher/delete');
        $this->view->option_name = $this->optionName(2);

        $this->timeTable();

        $this->view->render('attendance/teacher');
    }

    public function add() {
        Web::setTitle('Add DDC');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $this->view->link_back = $this->content->setLink('ddc');
        $this->view->link_sub1 = $this->content->setLink('ddc/getSub1');
        $this->view->render('ddc/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit DDC');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('ddc');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;

            switch ($listData['ddc_level']) {
                case 2:
                    foreach ($this->model->selectSub1() as $value) {
                        $listSub1[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub1 = array($listSub1, $listData['ddc_main_parent']);
                    $this->view->link_sub2 = $this->content->setLink('ddc/getSub2');
                    break;
                case 3:
                    $this->view->link_sub2 = $this->content->setLink('ddc/getSub2');
                    foreach ($this->model->selectSub1() as $value) {
                        $listSub1[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub1 = array($listSub1, $listData['ddc_temp_parent']);

                    foreach ($this->model->selectSub2($listData['ddc_temp_parent']) as $value) {
                        $listSub2[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub2 = array($listSub2, $listData['ddc_main_parent']);
                    break;
            }
            $this->view->render('ddc/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
    }

    public function create() {
        if ($this->model->createSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

    public function read() {
        if ($this->method->isAjax()) {

            $action = $this->method->post('page', 0);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";

            if ($action == 999) {
                $checktime = $this->model->selectAllCheckTime();
                $checkinout = array();
                foreach ($checktime as $value) {
                    //$checkinout['USERID']['TANGGAL']['INDEX'] = 'JAM'
                    $checkinout[$value['USERID']][date('d/m/Y', strtotime($value['CHECKTIME']))][] = date('H:i', strtotime($value['CHECKTIME']));
                }

                $sdate = $this->method->post('sdate', 0);
                $fdate = $this->method->post('fdate', 0);

                $dateList = array();
                $begin = new DateTime(date('Y-m-d', strtotime($sdate)));
                $end = new DateTime(date('Y-m-d', strtotime($fdate)));
                $end = $end->modify('+1 day');
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval, $end);

                foreach ($daterange as $date) {
                    $dateList[] = $date->format('d/m/Y');
                }


                $page = 1;
                $listData = $this->model->selectUserInfo();
                $total = 1; //$this->model->countAllDdc();


                $xml .= "<page>$page</page>";
                $xml .= "<total>$total</total>";

                foreach ($listData AS $row) {

                    foreach ($dateList as $dList) {

                        // START : Set Clock In / Clock Out
                        $clockin = '-';
                        $clockout = '-';
                        if (isset($checkinout[$row['USERID']][$dList])) {
                            $time = $checkinout[$row['USERID']][$dList];
                            $timecount = count($time);
                            if ($timecount > 0) {
                                sort($time);
                                $clockfirst = $time[0];
                                $clocklast = $time[$timecount - 1];

                                if ($clockfirst >= date('H:i', strtotime(substr($row['CHECKINTIME1'], -8, 8))) && $clockfirst <= date('H:i', strtotime(substr($row['CHECKINTIME2'], -8, 8)))) {
                                    $clockin = $clockfirst;
                                }

                                if ($clocklast >= date('H:i', strtotime(substr($row['CHECKOUTTIME1'], -8, 8))) && $clocklast <= date('H:i', strtotime(substr($row['CHECKOUTTIME2'], -8, 8)))) {
                                    $clockout = $clocklast;
                                }
                            }
                        }

                        if ($clockin == '-' && $clockout == '-') {
                            $note = 'A';
                            $style = 'style="color:red;"';
                        } else {
                            $note = '';
                            $style = 'style="color:black;"';
                        }
                        // END : Set Clock In / Clock Out

                        $nip = '-';
                        if (!empty($row['SSN'])) {
                            $nip = $row['SSN'];
                        }

                        $nuptk = '-';
                        if (!empty($row['CardNo'])) {
                            $nuptk = $row['CardNo'];
                        }


                        $xml .= "<row id='" . $row['USERID'] . "'>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['USERID'] . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $nip . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $nuptk . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['Name'] . "</span>]]></cell>";
                        $gender = "Perempuan";
                        if ($row['Gender'] == 'Male')
                            $gender = "Laki-Laki";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $gender . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $dList . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $clockin . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $clockout . "</span>]]></cell>";
                        $xml .= "<cell><![CDATA[<span " . $style . ">" . $note . "</span>]]></cell>";
                        $xml .= "</row>";
                    }
                }
            } else {
                
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function update($id = 0) {
        if ($this->model->updateSave($id)) {
            $ket = array(1, 0, $this->message->saveSucces());
        } else {
            $ket = array(0, 0, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    public function delete() {
        $res = false;
        if ($this->model->delete()) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function getSub1() {
        $list = array();
        foreach ($this->model->selectSub1() as $value) {
            $list[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
        }

        Form::create('select', 'sub1');
        Form::tips('Chose Level DDC');
        Form::validation()->requaired();
        Form::option($list, ' ');
        Form::properties(array('link' => $this->content->setLink('ddc/getSub2')));
        $html = Form::commit('attach');

        echo json_encode($html);
    }

    public function getSub2() {
        $list = array();
        foreach ($this->model->selectSub2($_GET['id']) as $value) {
            $list[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
        }

        Form::create('select', 'sub2');
        Form::tips('Chose Level DDC');
        Form::validation()->requaired();
        Form::option($list, ' ');
        $html = Form::commit('attach');

        echo json_encode($html);
    }

    public function optionName($deptId = 0) {
        $list = $this->model->selectUserByDeptId($deptId);
        $name = array();
        $idx = 1;
        foreach ($list as $value) {
            $name[$value['USERID']] = $value['Name'];
            $idx++;
        }
        return $name;
    }

    public function timeTable() {
        $list = $this->model->selectAllTimeTable();
        $time = array();
        foreach ($list as $value) {
            $time[$value['SCHCLASSID']] = $value;
        }
        //print_r($time);
    }

}