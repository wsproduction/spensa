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
        Web::setTitle('Daftar Hadir Guru');
        $this->view->link_r = $this->content->setLink('teacher/read');
        $this->view->link_c = $this->content->setLink('teacher/add');
        $this->view->link_d = $this->content->setLink('teacher/delete');
        $this->view->option_name = $this->optionName(2);
        $this->view->render('teacher/index');
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
    }

    public function treport() {
        Web::setTitle('Laporan Waktu Daftar Hadir Guru');
        $this->view->link_r = $this->content->setLink('teacher/read');
        $this->view->link_c = $this->content->setLink('teacher/add');
        $this->view->link_d = $this->content->setLink('teacher/delete');
        $this->view->option_name = $this->optionName(2);
        $this->view->render('teacher/treport');
    }

    public function treportprint() {

        $action = $this->method->post('page', 0);

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

        $listData = $this->model->selectUserInfo();

        $pdf = Src::plugin()->tcPdf();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Warman Suganda');
        $pdf->SetTitle('TCPDF Example 061');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set header and footer fonts
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 17);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 10);

        foreach ($dateList as $dlRow) {

            list($d, $m, $y) = explode('/', $dlRow);

            $date = $d . ' ' . $this->content->getMonthName($m, 'ina') . ' ' . $y;

            // add a page
            $pdf->AddPage();

            // define some HTML content with style
            $html = '
                    <style type="text/css">
                        .header {
                            text-align : center;
                            font-size : 14pt;
                            font-weight : bold;
                        }
                        .date {
                            text-align : left;
                            text-decoration : none;
                        }
                        .list-data {
                        }
                        .list-data .th {
                            font-size : 10pt;
                            border-top : 1px solid #000;
                            border-bottom : 1px solid #000;
                            border-right : 1px solid #000;
                            text-align: center;
                            font-weight : bold;
                        }
                        .list-data .first {
                            border-left : 1px solid #000;
                        }
                        .list-data .td {
                            font-size : 10pt;
                            border-bottom : 1px solid #000;
                            border-right : 1px solid #000;
                        }
                    </style>
                 ';

            $html .= '<div class="header">DAFTAR HADIR PEGAWAI<br>SMP NEGERI 1 SUBANG</div>';
            $html .= '<br>';
            $html .= '<table cellpadding="0" cellspacing="0" width="650">
                        <tr>
                            <td align="left" height="18"><b>Keterangan :</b> Guru</td>
                            <td align="right"><b>Hari/Tanggal :</b> Senin, ' . $date . '</td>
                        </tr>
                     </table>';
            $html .= '<table class="list-data" cellpadding="4" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="th first" rowspan="2" width="50" align="center">&nbsp;<br>NO</td>
                                <td class="th" rowspan="2" width="250">&nbsp;<br>NAMA</td>
                                <td class="th" colspan="2" width="200">WAKTU</td>
                                <td class="th" rowspan="2" width="150">&nbsp;<br>KETERANGAN</td>
                            </tr>
                            <tr>
                                <td class="th" width="100" style="border-top:none;">DATANG</td>
                                <td class="th" width="100" style="border-top:none;">PULANG</td>
                            </tr>
                        </thead>';
            $html .= '  <tbody>';
            $no = 1;
            foreach ($listData as $userInfoRow) {

                // START : Set Clock In / Clock Out
                $clockin = '-';
                $clockout = '-';
                if (isset($checkinout[$userInfoRow['USERID']][$dlRow])) {
                    $time = $checkinout[$userInfoRow['USERID']][$dlRow];
                    $timecount = count($time);
                    if ($timecount > 0) {
                        sort($time);
                        $clockfirst = $time[0];
                        $clocklast = $time[$timecount - 1];

                        if ($clockfirst >= date('H:i', strtotime(substr($userInfoRow['CHECKINTIME1'], -8, 8))) && $clockfirst <= date('H:i', strtotime(substr($userInfoRow['CHECKINTIME2'], -8, 8)))) {
                            $clockin = $clockfirst;
                        }

                        if ($clocklast >= date('H:i', strtotime(substr($userInfoRow['CHECKOUTTIME1'], -8, 8))) && $clocklast <= date('H:i', strtotime(substr($userInfoRow['CHECKOUTTIME2'], -8, 8)))) {
                            $clockout = $clocklast;
                        }
                    }
                }

                if ($clockin == '-' && $clockout == '-') {
                    $note = 'Tanpa Keterangan';
                    $style = 'style="color:red;"';
                } else {
                    $note = '';
                    $style = 'style="color:black;"';
                }
                // END : Set Clock In / Clock Out

                $html .= '   <tr>
                            <td class="td first" align="center" width="50">' . $no . '.</td>
                            <td class="td" width="250">' . $userInfoRow['Name'] . '</td>
                            <td class="td" align="center" width="100">' . $clockin . '</td>
                            <td class="td" align="center" width="100">' . $clockout . '</td>
                            <td class="td" align="center" width="150">' . $note . '</td>
                        </tr>';
                $no++;
            }
            $html .= '  </tbody>';

            $html .= '</table>';
            $html .= '<br>';
            $html .= '<table>';
            $html .= '  <tr>';
            $html .= '      <td width="450">Mengetahui,</td>';
            $html .= '      <td>Subang, ' . date('d') . ' ' . $this->content->getMonthName(date('m'), 'ina') . ' ' . date('Y') . '</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td>Kepala Sekolah</td>';
            $html .= '      <td>Wakabid Manajement</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td height="75">&nbsp;</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td><u>E. Heni Rodiah, S.Pd.,M.M.Pd.</u></td>';
            $html .= '      <td><u>Sri Suryanti, S.Pd.</u></td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td>NIP. 19283948488484994</td>';
            $html .= '      <td>NIP. 19283948488484994</td>';
            $html .= '  </tr>';
            $html .= '</table>';

            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
        }

        // ---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_061.pdf', 'I');

        //============================================================+
        // END OF FILE                                                
        //============================================================+
    }

}