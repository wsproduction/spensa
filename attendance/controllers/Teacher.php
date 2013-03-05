<?php

class Teacher extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
        Src::plugin()->jQueryMultiSelect();
        Src::plugin()->jQueryGlobalize();
    }

    public function index() {
        Web::setTitle('Daftar Hadir Guru');
        $this->view->link_r = $this->content->setLink('teacher/read');
        $this->view->link_c = $this->content->setLink('teacher/add');
        $this->view->link_d = $this->content->setLink('teacher/delete');
        $this->view->option_name = $this->content->optionName(2);
        $this->view->option_description = $this->content->optionDescription();
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

    public function addAttendance() {
        if ($this->model->addAttendanceSave()) {
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

                $nameid = $this->method->post('nameid', 0);
                $sdate = $this->method->post('sdate', 0);
                $fdate = $this->method->post('fdate', 0);

                $begin = new DateTime(date('Y-m-d', strtotime($sdate)));
                $end_temp = new DateTime(date('Y-m-d', strtotime($fdate)));
                $end = $end_temp->modify('+1 day');

                $checktime = $this->model->selectAllCheckTime($nameid, $begin->format('m/d/Y'), $end->format('m/d/Y'));
                $checkInOut = $this->content->pasingCheckTime($checktime);

                $dateList = $this->content->parsingDateList($begin, $end);
                $listData = $this->model->selectUserInfo($nameid);

                $spedayList = $this->model->selectSpeday($nameid);
                $userSpeday = array();

                foreach ($spedayList as $row_sd) {
                    $s = new DateTime(date('Y-m-d', strtotime($row_sd['STARTSPECDAY'])));
                    $e_temp = new DateTime(date('Y-m-d', strtotime($row_sd['ENDSPECDAY'])));
                    $e = $e_temp->modify('+1 day');

                    foreach ($this->content->parsingDateList($s, $e) as $row_d) {
                        $userSpeday[$row_sd['USERID']][$row_d][] = $row_sd['YUANYING'];
                    }
                }

                //var_dump($userSpeday);

                $listView = $this->content->parsingListView($listData, $dateList, $checkInOut, $userSpeday);

                $page = 1;
                $total = count($listView);

                $xml .= "<page>$page</page>";
                $xml .= "<total>$total</total>";

                foreach ($listView as $row) {

                    $style = $row['Style'];

                    $btn_edit = Src::image('edit.gif', null, array('rel' => $row['USERID'], 'title' => 'Perbaharui Keterangan', 'class' => 'edit', 'style' => 'cursor:pointer'));

                    $xml .= "<row id='" . $row['USERID'] . "'>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['USERID'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['SSN'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['CardNo'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['Name'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['Gender'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['DateList'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['ClockIn'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['ClockOut'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['Note'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[<span " . $style . ">" . $row['USER_SPEDAY'] . "</span>]]></cell>";
                    $xml .= "<cell><![CDATA[" . $btn_edit . "]]></cell>";
                    $xml .= "</row>";
                }
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

    public function editDescription() {
        $ket = array(0, 0, $this->message->saveError());
        if ($this->model->editDescriptionSave()) {
            $ket = array(1, 0, $this->message->saveSucces());
        }
        echo json_encode($ket);
    }

    public function report() {
        Web::setTitle('Laporan Daftar Hadir Guru');
        $this->view->link_r = $this->content->setLink('teacher/read');
        $this->view->link_c = $this->content->setLink('teacher/add');
        $this->view->link_d = $this->content->setLink('teacher/delete');
        $this->view->option_name = $this->optionName(2);
        $this->view->option_month_name = $this->optionMonth();
        $this->view->option_years = $this->optionYears();
        $this->view->render('teacher/report');
    }

    public function reportPreview() {

        $nameid = $this->method->get('nameid', 0);
        $sdate = $this->method->get('sdate', 0);
        $fdate = $this->method->get('fdate', 0);

        $begin = new DateTime(date('Y-m-d', strtotime($sdate)));
        $end_temp = new DateTime(date('Y-m-d', strtotime($fdate)));
        $end = $end_temp->modify('+1 day');

        $checktime = $this->model->selectAllCheckTime($nameid, $begin->format('m/d/Y'), $end->format('m/d/Y'));
        $checkInOut = $this->content->pasingCheckTime($checktime);

        $dateList = $this->content->parsingDateList($begin, $end);
        $listData = $this->model->selectUserInfo($nameid);

        //$listView = $this->content->parsingListView($listData, $dateList, $checkInOut);

        $pdf = Src::plugin()->tcPdf('P', 'mm', 'F4', true, 'UTF-8', false, false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Warman Suganda');
        $pdf->SetTitle('TCPDF Example 061');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(18, 8, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(5);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 12);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 8);

        foreach ($dateList as $dlRow) {

            list($d, $m, $y) = explode('/', $dlRow);

            $dayname = $this->content->getDayName($y . '-' . $m . '-' . $d, 'ina');
            $date = $d . ' ' . $this->content->getMonthName($m, 'ina') . ' ' . $y;

            // add a page
            $pdf->AddPage();

            // define some HTML content with style
            $html = '
                    <style type="text/css">
                        .header {
                            text-align : center;
                            font-size : 9pt;
                            font-weight : bold;
                        }
                        .date {
                            text-align : left;
                            text-decoration : none;
                        }
                        .list-data {
                        }
                        .list-data .th {
                            font-size : 7pt;
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
                            font-size : 7pt;
                            border-bottom : 1px solid #000;
                            border-right : 1px solid #000;
                        }
                    </style>
                 ';

            $html .= '<div class="header">DAFTAR HADIR GURU<br>SMP NEGERI 1 SUBANG</div>';
            $html .= '<br>';
            $html .= '<table cellpadding="0" cellspacing="0" width="650">
                        <tr>
                            <td align="left"><b>Hari/Tanggal :</b> ' . $dayname . ', ' . $date . '</td>
                            <td align="right" height="18"><b>Keterangan :</b> Libur Hari Raya Idul Fitri 1425H</td>
                        </tr>
                     </table>';
            $html .= '<table class="list-data" cellpadding="4" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="th first" colspan="3" align="center" width="205">NOMOR</td>
                                <td class="th" rowspan="2" width="205">&nbsp;<br>NAMA</td>
                                <td class="th" rowspan="2" width="30" align="center">&nbsp;<br>L/P</td>
                                <td class="th" colspan="2" width="120">WAKTU</td>
                                <td class="th" rowspan="2" width="90">&nbsp;<br>KETERANGAN</td>
                            </tr>
                            <tr>
                                <td class="th first" width="40" align="center" style="border-top:none;">URUT</td>
                                <td class="th" width="100" style="border-top:none;">NIP</td>
                                <td class="th" width="65" style="border-top:none;">NUPTK</td>
                                <td class="th" width="60" style="border-top:none;">DATANG</td>
                                <td class="th" width="60" style="border-top:none;">PULANG</td>
                            </tr>
                        </thead>';
            $html .= '  <tbody>';
            $no = 1;
            foreach ($listData as $userInfoRow) {

                // START : Set Clock In / Clock Out
                $clockin = '-';
                $clockout = '-';
                if (isset($checkInOut[$userInfoRow['USERID']][$dlRow])) {
                    $time = $checkInOut[$userInfoRow['USERID']][$dlRow];
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
                    $note = 'tanpa keterangan';
                    $style = 'style="color:red;"';
                } else {
                    $note = '';
                    $style = 'style="color:black;"';
                }
                // END : Set Clock In / Clock Out

                $SSN = '-';
                if ($userInfoRow['SSN'] != '') {
                    $SSN = $userInfoRow['SSN'];
                }

                $CardNo = '-';
                if (!empty($userInfoRow['CardNo'])) {
                    $CardNo = $userInfoRow['CardNo'];
                }

                switch ($userInfoRow['Gender']) {
                    case 'Male':
                        $Gender = 'L';
                        break;
                    case 'Female':
                        $Gender = 'P';
                        break;
                    default:
                        $Gender = '-';
                        break;
                }

                $html .= '<tr>
                            <td class="td first" align="center" width="40">' . $no . '.</td>
                            <td class="td" align="center" width="100">' . $SSN . '</td>
                            <td class="td" align="center" width="65">' . $CardNo . '</td>
                            <td class="td" width="205   ">' . $userInfoRow['Name'] . '</td>
                            <td class="td" width="30" align="center">' . $Gender . '</td>
                            <td class="td" align="center" width="60">' . $clockin . '</td>
                            <td class="td" align="center" width="60">' . $clockout . '</td>
                            <td class="td" align="center" width="90">' . $note . '</td>
                         </tr>';
                $no++;
            }
            $html .= '  </tbody>';

            $html .= '</table>';
            $html .= '<br>';
            $html .= '<table>';
            $html .= '  <tr>';
            $html .= '      <td width="450">MENGETAHUI</td>';
            $html .= '      <td>SUBANG, ' . date('d') . ' ' . strtoupper($this->content->getMonthName(date('m'), 'ina')) . ' ' . date('Y') . '</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td>KEPALA SEKOLAH,</td>';
            $html .= '      <td>KEPEGAWAIAN,</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td height="75">&nbsp;</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td><u>E. HENI RODIAH, S.Pd.,M.M.Pd.</u></td>';
            $html .= '      <td><u>DAYAT</u></td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td>NIP. 19570326 197703 2 002</td>';
            $html .= '      <td>NIP. 19620825 198703 1 006</td>';
            $html .= '  </tr>';
            $html .= '</table>';

            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
        }

        //Close and output PDF document
        $pdf->Output('example_061.pdf', 'I');
    }

    public function recapitulationPreview() {

        $nameid = $this->method->get('nameid', 0);
        $report_type = $this->method->get('report_type', 0);
        $month = $this->method->get('month', 0);
        $semester = $this->method->get('semester', 0);
        $years = $this->method->get('years', 0);

        $sumDay = cal_days_in_month(CAL_GREGORIAN, $month, $years);

        $dateList = array();
        for ($day = 1; $day <= $sumDay; $day++) {
            $dateList[] = str_pad($day, 2, '0', STR_PAD_LEFT) . '/' . $month . '/' . $years;
        }

        $firtDate = explode('/', $dateList[0]);
        $lastDate = explode('/', $dateList[count($dateList) - 1]);

        $sdate = $firtDate[1] . '/' . $firtDate[0] . '/' . $firtDate[2];
        $fdate = $lastDate[1] . '/' . $lastDate[0] . '/' . $lastDate[2];

        $checktime = $this->model->selectAllCheckTime($nameid, $sdate, $fdate);
        $checkInOut = $this->content->pasingCheckTime($checktime);
        $listData = $this->model->selectUserInfo($nameid);

        $pdf = Src::plugin()->tcPdf('P', 'mm', 'F4', true, 'UTF-8', false, false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Warman Suganda');
        $pdf->SetTitle('TCPDF Example 061');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(10, 5, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(5);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 12);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 8);

        // add a page
        $pdf->AddPage('L');

        // define some HTML content with style
        $html = ' <style type="text/css">
                        .header {
                            text-align : center;
                            font-size : 9pt;
                            font-weight : bold;
                        }
                        .date {
                            text-align : left;
                            text-decoration : none;
                        }
                        .list-data {
                        }
                        .list-data .th {
                            font-size : 7pt;
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
                            font-size : 7pt;
                            border-bottom : 1px solid #000;
                            border-right : 1px solid #000;
                        }
                    </style> ';

        $html .= '<div class="header">REKAPITULASI DAFTAR HADIR GURU<br>SMP NEGERI 1 SUBANG</div>';
        $html .= '<br>';
        $html .= '<table cellpadding="0" cellspacing="0" width="650">
                    <tr>
                        <td align="left" height="15"><b>Bulan :</b> ' . $this->content->getMonthName($month, 'ina') . '</td>';
        $html .= '  </tr>
                  </table>';

        $dateWidth = 18 * $sumDay;

        $html .= '<table class="list-data" cellpadding="2" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="th first" colspan="3" align="center" width="205">NOMOR</td>
                            <td width="210" rowspan="2" class="th" style="line-height:10px;">NAMA</td>
                            <td rowspan="2" class="th" style="line-height:10px;">L/P</td>
                            <td width="' . $dateWidth . '" colspan="' . $sumDay . '" class="th">TANGGAL</td>
                            <td colspan="4" class="th">KETERANGAN</td>
                        </tr>
                        <tr>
                            <td class="th first" width="40" style="border-top:none;">URUT</td>
                            <td class="th" width="100" style="border-top:none;">NIP</td>
                            <td class="th" width="65" style="border-top:none;">NUPTK</td>';

        for ($day = 1; $day <= $sumDay; $day++) {
            $html .= '<td width="18" class="th">' . $day . '</td>';
        }

        $html .= '          <td class="th">D</td>';
        $html .= '          <td class="th">S</td>';
        $html .= '          <td class="th">I</td>';
        $html .= '          <td class="th">A</td>';

        $html .= '      </tr>
                    </thead>';

        $html .= '  <tbody>';
        $norut = 1;
        foreach ($listData as $userInfoRow) {

            $SSN = '-';
            if ($userInfoRow['SSN'] != '') {
                $SSN = $userInfoRow['SSN'];
            }

            $CardNo = '-';
            if (!empty($userInfoRow['CardNo'])) {
                $CardNo = $userInfoRow['CardNo'];
            }

            switch ($userInfoRow['Gender']) {
                case 'Male':
                    $Gender = 'L';
                    break;
                case 'Female':
                    $Gender = 'P';
                    break;
                default:
                    $Gender = '-';
                    break;
            }

            $html .= '        <tr>';
            $html .= '          <td width="40" class="td first" align="center">' . $norut . '.</td>';
            $html .= '          <td width="100" class="td" align="center">' . $SSN . '</td>';
            $html .= '          <td width="65" class="td" align="center">' . $CardNo . '</td>';
            $html .= '          <td width="210" class="td">' . $userInfoRow['Name'] . '</td>';
            $html .= '          <td class="td" align="center">' . $Gender . '</td>';

            for ($day = 1; $day <= $sumDay; $day++) {
                $html .= '<td width="18" class="td" align="center">' . $day . '</td>';
            }

            $html .= '          <td class="td" align="center">D</td>';
            $html .= '          <td class="td" align="center">S</td>';
            $html .= '          <td class="td" align="center">I</td>';
            $html .= '          <td class="td" align="center">A</td>';
            $html .= '        </tr>';
            $norut++;
        }
        $html .= '  </tbody>';

        $html .='</table>';

        $pdf->writeHTML($html, true, false, true, false, '');



        //Close and output PDF document
        $pdf->Output('example_061.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }

    public function optionYears() {
        $list = array();
        for ($y = date('Y'); $y >= 2010; $y--) {
            $list[$y] = $y;
        }
        return $list;
    }

    public function optionMonth() {
        return array(1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
    }

}