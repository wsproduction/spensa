<?php

class Report extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function preview($classgroup_id = 0) {
        Web::setTitle('Cetak Laporan Hasil Belajar Siswa');
        Session::init();
        $user_references = Session::get('user_references');
        $guardian_list = $this->model->selectGuardianInformation($classgroup_id, $user_references);
        if ($guardian_list) {
            $guardian_info = $guardian_list[0];
            $this->view->guardian_info = $guardian_info;

            $this->view->link_back = $this->content->setParentLink('guardian/page/' . $classgroup_id);
            $this->view->optionStudent = $this->studentOption($classgroup_id);
            $this->view->optionReportType = $this->optionReportType();

            $this->view->render('report/index');
        } else {
            $this->view->render('report/404');
        }
    }

    public function readSubject($classgroup_id = 0) {
        $subject_list = $this->model->selectSubjectByClassGroup($classgroup_id);
        $html_list = '';
        if ($subject_list) {
            $idx = 1;
            foreach ($subject_list as $row) {
                $html_list .= '<tr>';
                $html_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $html_list .= '     <td>' . $row['subject_name'] . '</td>';
                $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                $html_list .= '     <td align="center">-</td>';
                $html_list .= '     <td align="center">-</td>';
                $html_list .= '     <td align="center">Lihat</td>';
                $html_list .= '</tr>';
                $idx++;
            }
        } else {
            $html_list .= '<tr>
                                <td class="first" colspan="3">
                                    <div class="information-box">
                                        Data tidak ditemukan
                                    </div>
                                </td>
                            </tr>';
        }
        echo json_encode($html_list);
    }

    public function readEskul($classgroup_id = 0) {
        $subject_list = $this->model->selectSubjectByClassGroup($classgroup_id);
        $html_list = '';
        if ($subject_list) {
            $idx = 1;
            foreach ($subject_list as $row) {
                $html_list .= '<tr>';
                $html_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $html_list .= '     <td>' . $row['subject_name'] . '</td>';
                $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                $html_list .= '     <td align="center">-</td>';
                $html_list .= '     <td align="center">-</td>';
                $html_list .= '     <td align="center">Lihat</td>';
                $html_list .= '</tr>';
                $idx++;
            }
        } else {
            $html_list .= '<tr>
                                <td class="first" colspan="3">
                                    <div class="information-box">
                                        Data tidak ditemukan
                                    </div>
                                </td>
                            </tr>';
        }
        echo json_encode($html_list);
    }

    private function studentOption($classgroup_id = 0) {
        $list = $this->model->selectStudentByClassGroupId($classgroup_id);
        $option = array();
        foreach ($list as $row) {
            $option[$row['student_nis']] = $row['student_nis'] . ' - ' . $row['student_name'];
        }
        return $option;
    }

    private function optionReportType() {
        $list = $this->model->selectRepotType();
        $option = array();
        foreach ($list as $row) {
            $option[$row['score_type_id']] = $row['score_type_description'];
        }
        return $option;
    }

    public function generate($info_id = 0) {

        list($classgroup_id, $nis, $report_type) = explode('.', $info_id);
        $title_head = "";
        if ($report_type == 1) {
            $title_head = "LAPORAN HASIL BELAJAR SISWA TENGAH ";
        }

        $student_list = $this->model->selectStudentById($classgroup_id, $nis);

        if ($student_list) {

            $student_info = $student_list[0];
            $must_subject_list = $this->model->selectMustSubject($student_info['student_nis'], $student_info['period_id'], $student_info['semester_id'], $student_info['grade_id'], $report_type);
            $choice_subject_list = $this->model->selectChoiceSubject($student_info['student_nis'], $student_info['period_id'], $student_info['semester_id'], $student_info['grade_id'], $report_type);
            $mulok_subject_list = $this->model->selectMulokSubject();
            $report_publishing_list = $this->model->selectReportPublishing($student_info['period_id'], $student_info['semester_id'], $report_type);

            $publishing_date = 'dd-mm-YY';
            if (count($report_publishing_list) > 0) {
                $report_publishing_info = $report_publishing_list[0];
                $pd = $report_publishing_info['report_publishing_date'];
                $publishing_date = date('d', strtotime($pd)) . ' ' . $this->content->monthName(date('m', strtotime($pd))) . ' ' . date('Y', strtotime($pd));
            }

            $guardian_id = '';
            if (!empty($student_info['employess_nip'])) {
                $guardian_id = $student_info['employess_nip'];
            }
            $guardian_name = $student_info['employess_name'];

            $terbilang = Src::plugin()->PHPTerbilang();

            $pdf = Src::plugin()->tcPdf();
            $pdf->SetProtection($permissions = array('copy'), $user_pass = '', $owner_pass = null, $mode = 0, $pubkeys = null);

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
            $pdf->SetMargins(6, 5, 5);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 17);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // ---------------------------------------------------------
            // set font
            $pdf->SetFont('helvetica', '', 8);

            // add a page
            $pdf->AddPage();

            $html = '
            <style type="text/css">
                .letter-head {
                    border : 1px solid #000;
                    color : #000;
                    font-weight:bold;
                }
                .title-head {
                    border : 1px solid #000;
                    color : #fff;
                    background-color : #000;
                    font-weight : bold;
                    font-size : 10pt;
                    text-align : center;
                }
                .school-name {
                    font-size : 16pt;
                    font-weight:bold;
                }
                .school-address {
                    font-size : 9pt;
                }
                .school-info {
                    font-size : 9pt;
                }
                .detail-head {
                    border : 1px solid #000;
                }
                .info-student {
                    border-right : 1px solid #000;
                    width : 510px;
                }
                .info-student-label-name {
                    width : 100px;
                    font-size : 9pt;
                    font-weight : bold;
                }
                .info-student-label-sparator {
                    width : 10px;
                    font-size : 9pt;
                    font-weight : bold;
                }
                .info-student-label-content {
                    width : 400px;
                    font-size : 9pt;
                }
                .title-period {
                    text-align : center;
                    font-size : 9pt;
                    font-weight : bold;
                    width : 187px;
                    border-bottom : 1px solid #000;
                }
                .content-period {
                    text-align : center;
                    font-size : 12pt;
                    font-weight : bold;
                    width : 187px;
                }
                .blank-column-1 {
                    height : 5px;
                    font-size : 5px;
                }
                .blank-column-2 {
                    height : 10px;
                    font-size : 5px;
                }
                .box-score-list-head {
                    text-align : center;
                    font-size : 9pt;
                    font-weight: bold;
                    color : #fff;
                    background-color : #000;
                    border-left : 1px solid #fff;
                    border-right : 1px solid #fff;
                    border-top : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-head-child {
                    text-align : center;
                    font-size : 9pt;
                    font-weight: bold;
                    color : #fff;
                    background-color : #000;
                    border-left : 1px solid #fff;
                    border-right : 1px solid #fff;
                    border-top : 1px solid #fff;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-head-first {
                    text-align : center;
                    font-size : 9pt;
                    color : #fff;
                    font-weight: bold;
                    background-color : #000;
                    border-left : 1px solid #000;
                    border-right : 1px solid #fff;
                    border-top : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-head-last {
                    text-align : center;
                    font-size : 9pt;
                    color : #fff;
                    font-weight: bold;
                    background-color : #000;
                    border-left : 1px solid #fff;
                    border-right : 1px solid #000;
                    border-top : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-content {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-content-first {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-left : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-sumary {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-top : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-sumary-first {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-top : 1px solid #000;
                    border-left : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-average {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-average-first {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-left : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .signature {
                     font-size:9pt;
                }
                .box-score-list-choice {
                    color : #000;
                    font-size : 9pt;
                    background : #fff;
                    border-right : 1px solid #000;
                }
            </style>
            <table width="100%" cellpadding="2" cellspacing="0">
                <tr>
                    <td class="letter-head">
                        <table width="100%" cellpadding="2" cellspacing="0">
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="1">
                                        <tr>
                                            <td rowspan="3" width="60"><img src="' . Web::path() . 'asset/upload/images/logo-spensa.png" width="50"></td>
                                            <td width="600" class="school-name">SMP NEGERI 1 SUBANG</td>
                                        </tr>
                                        <tr>
                                            <td class="school-address">Jln. Letjen Soeprapto No. 105 Subang 41211 Telp. (0260)  411403 Fax. (0260) 411404</td>
                                        </tr>
                                        <tr>
                                            <td class="school-info">Email : info@smpn1subang.sch.id  Website : www.smpn1subang.sch.id</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="title-head">
                        <table cellpadding="2" cellspacing="0">
                            <tr>
                                <td>' . $title_head . ' ' . strtoupper($student_info['semester_name']) . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="detail-head">
                        <table cellpadding="2" cellspacing="0">
                            <tr>
                                <td class="info-student" rowspan="2">
                                    <table>
                                        <tr>
                                            <td class="info-student-label-name">NIS</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">' . $student_info['student_nis'] . '</td>
                                        </tr>
                                        <tr>
                                            <td class="info-student-label-name">NISN</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">' . $student_info['student_nisn'] . '</td>
                                        </tr>
                                        <tr>
                                            <td class="info-student-label-name">NAMA</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">' . strtoupper($student_info['student_name']) . '</td>
                                        </tr>
                                        <tr>
                                            <td class="info-student-label-name">KELAS</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">' . $student_info['grade_title'] . ' (' . strtoupper($student_info['grade_name']) . ') ' . $student_info['classroom_name'] . '</td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="title-period">
                                    <table cellpadding="4" cellspacing="0">
                                        <tr>
                                            <td>TAHUN PELAJARAN</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="content-period">
                                    <table cellpadding="6" cellspacing="0">
                                        <tr>
                                            <td>' . $student_info['period_years_start'] . ' / ' . $student_info['period_years_end'] . '</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-2">&nbsp;</td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="40" class="box-score-list-head-first" rowspan="2">
                        <table cellpadding="7" cellspacing="0">
                            <tr>
                                <td>NO</td>
                            </tr>
                        </table>
                    </td>
                    <td width="225" class="box-score-list-head" rowspan="2" >
                        <table cellpadding="7" cellspacing="0">
                            <tr>
                                <td>MATA PELAJARAN</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50" class="box-score-list-head" rowspan="2" >
                        <table cellpadding="7" cellspacing="0">
                            <tr>
                                <td>KKM</td>
                            </tr>
                        </table>
                    </td>
                    <td width="240" class="box-score-list-head" colspan="2">NILAI</td>
                    <td width="150" class="box-score-list-head-last" rowspan="2" >DESKRIPSI KEMAJUAN BELAJAR</td>
                </tr>
                <tr>
                    <td width="60" class="box-score-list-head-child">ANGKA</td>
                    <td width="180" class="box-score-list-head-child">HURUF</td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0">';

            /* Daftar Mata Pelajaran Wajib */
            $idx = 1;
            $total_score = 0;
            $total_subject = 0;
            foreach ($must_subject_list as $rowscore) {
                $score = $rowscore['score_value'];
                $mlc = $rowscore['mlc_value'];
                $total_score += $score;
                $html .='<tr>
                    <td align="center" width="40" class="box-score-list-content-first">' . $idx . '.</td>
                    <td align="left" width="225" class="box-score-list-content"> ' . $rowscore['subject_name'] . ' </td>
                    <td align="center" width="50" class="box-score-list-content">' . $mlc . '</td>
                    <td align="center" width="60" class="box-score-list-content">' . $score . '</td>
                    <td align="left" width="180" class="box-score-list-content">' . strtolower($terbilang->eja($score)) . '</td>
                    <td align="center" width="150" class="box-score-list-content">' . $this->content->descProgressLearning($score, $mlc) . '</td>
                </tr>';
                $idx++;
                if (!is_null($score))
                    $total_subject++;
            }

            /* Daftar Mata Pelajaran Pilihan */
            $rowspan_choice_subject_list = count($choice_subject_list) + 1;
            $html .='<tr>
                    <td align="center" width="40" class="box-score-list-content-first" rowspan="' . $rowspan_choice_subject_list . '">' . $idx . '.</td>
                    <td align="left" class="box-score-list-choice"> Pilihan : </td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                </tr>';

            $numbering_choice_subject = 'a';
            foreach ($choice_subject_list as $rowscore) {
                $score = 80; //$rowscore['score_value'];
                $mlc = 78; //$rowscore['mlc_value'];
                $total_score += $score;
                $html .='<tr>
                    <td align="left" width="225" class="box-score-list-content"> ' . $numbering_choice_subject . '. ' . $rowscore['subject_name'] . ' </td>
                    <td align="center" width="50" class="box-score-list-content">80</td>
                    <td align="center" width="60" class="box-score-list-content">78</td>
                    <td align="left" width="180" class="box-score-list-content">' . strtolower($terbilang->eja($score)) . '</td>
                    <td align="center" width="150" class="box-score-list-content">tidak tercapai</td>
                </tr>';
                $numbering_choice_subject++;
                if (!is_null($score))
                    $total_subject++;
            }


            $idx++;

            /* Daftar Mata Pelajaran Muatan Lokal */
            $rowspan_mulok_subject_list = count($mulok_subject_list) + 1;
            $html .='<tr>
                    <td align="center" width="40" class="box-score-list-content-first" rowspan="' . $rowspan_mulok_subject_list . '">' . $idx . '.</td>
                    <td align="left" class="box-score-list-choice"> Pilihan : </td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                    <td align="left" class="box-score-list-choice">&nbsp;</td>
                </tr>';

            $numbering_mulok_subject = 'a';
            foreach ($mulok_subject_list as $rowscore) {
                $score = 80; //$rowscore['score_value'];
                $mlc = 78; //$rowscore['mlc_value'];
                $total_score += $score;
                $html .='<tr>
                    <td align="left" width="225" class="box-score-list-content"> ' . $numbering_mulok_subject . '. ' . $rowscore['subject_name'] . ' </td>
                    <td align="center" width="50" class="box-score-list-content">80</td>
                    <td align="center" width="60" class="box-score-list-content">78</td>
                    <td align="left" width="180" class="box-score-list-content">' . strtolower($terbilang->eja($score)) . '</td>
                    <td align="center" width="150" class="box-score-list-content">tidak tercapai</td>
                </tr>';
                $numbering_mulok_subject++;
                if (!is_null($score))
                    $total_subject++;
            }

            $average_score = number_format($total_score / $total_subject, 2, '.', ' ');
            if (stristr($average_score, '.') == '.00') {
                list($value, $point) = explode('.', $average_score);
                $average_score = $value;
            }

            $html .='</table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-1">&nbsp;</td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td align="center" width="315" class="box-score-list-sumary-first"><b>JUMLAH</b></td>
                    <td align="center" width="60" class="box-score-list-sumary">' . $total_score . '</td>
                    <td align="left" width="330" class="box-score-list-sumary">' . strtolower($terbilang->eja($total_score)) . '</td>
                </tr>
                <tr>
                    <td align="center" width="315" class="box-score-list-average-first"><b>RATA-RATA</b></td>
                    <td align="center" width="60" class="box-score-list-average">' . $average_score . '</td>
                    <td align="left" width="330" class="box-score-list-average">' . strtolower($terbilang->eja($average_score)) . ' </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-2">&nbsp;</td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td align="center" width="315" class="box-score-list-head-first">KEGIATAN PENGEMBANGAN DIRI</td>
                    <td align="center" width="60" class="box-score-list-head">NILAI</td>
                    <td align="center" width="330" class="box-score-list-head-last">KETERANGAN</td>
                </tr>
                <tr>
                    <td align="left" width="315" class="box-score-list-content-first">1. Ketangkasan Office</td>
                    <td align="center" width="60" class="box-score-list-content">A</td>
                    <td align="center" width="330" class="box-score-list-content">sangat baik</td>
                </tr>
                <tr>
                    <td align="left" width="315" class="box-score-list-content-first">2. Paskibra</td>
                    <td align="center" width="60" class="box-score-list-content">B</td>
                    <td align="center" width="330" class="box-score-list-content">baik</td>
                </tr>
                <tr>
                    <td align="left" width="315" class="box-score-list-content-first">2. Paskibra</td>
                    <td align="center" width="60" class="box-score-list-content">B</td>
                    <td align="center" width="330" class="box-score-list-content">baik</td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-2">&nbsp;</td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td align="center" width="375" style="border-right:1px solid #000;" class="box-score-list-head-first">AHLAK DAN KEPRIBADIAN</td>
                    <td align="center" width="20" rowspan="2"></td>
                    <td align="center" width="310" style="border-left:1px solid #000;" class="box-score-list-head-last">KETIDAKHADIRAN</td>
                </tr>
                <tr>
                    <td align="left" class="box-score-list-content-first">
                        <table>
                            <tr>
                                <td width="100" align="left">AKHLAK</td>
                                <td width="10">:</td>
                                <td align="left"> A (sangat baik) </td>
                            </tr>
                            <tr>
                                <td align="left">KEPRIBADIAN</td>
                                <td>:</td>
                                <td align="left"> A (sangat baik) </td>
                            </tr>
                        </table>
                    </td>
                    <td align="center" class="box-score-list-content" style="border-left:1px solid #000;">
                        <table>
                            <tr>
                                <td width="15" align="left">1.</td>
                                <td width="150" align="left">SAKIT</td>
                                <td width="15">:</td>
                                <td width="30" align="right"> 1 </td>
                                <td align="left"> hari </td>
                            </tr>
                            <tr>
                                <td align="left">2.</td>
                                <td align="left">IJIN</td>
                                <td>:</td>
                                <td align="right"> 1 </td>
                                <td align="left"> hari </td>
                            </tr>
                            <tr>
                                <td align="left">3.</td>
                                <td align="left">TANPA KETERANGAN</td>
                                <td>:</td>
                                <td align="right"> - </td>
                                <td align="left"> hari </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-2">&nbsp;</td>
                </tr>
            </table>
            <table class="signature">
                <tr>
                    <td width="425">&nbsp;</td>
                    <td width="100" align="left">Diberikan di</td>
                    <td width="20">:</td>
                    <td width="160" align="left">Subang</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left">Tanggal</td>
                    <td>:</td>
                    <td align="left" >' . $publishing_date . '</td>
                </tr>
                <tr>
                    <td align="left" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left">
                        <table>
                            <tr>
                                <td>Mengetahui</td>
                            </tr>
                            <tr>
                                <td>Orang Tua/Wali, </td>
                            </tr>
                            <tr>
                                <td height="60">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="250" style="border-bottom:1px solid #000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td align="left" colspan="3">
                        <table>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Wali Kelas, </td>
                            </tr>
                            <tr>
                                <td height="60">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="250" style="border-bottom:1px solid #000;">' . $guardian_name . '</td>
                            </tr>
                            <tr>
                                <td>NIP. ' . $guardian_id . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        ';

            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // ---------------------------------------------------------
            //Close and output PDF document
            $pdf->Output('example_061.pdf', 'I');
        } else {
            echo "Data tidak ditemukan";
        }
    }

}