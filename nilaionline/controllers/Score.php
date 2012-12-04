<?php

class Score extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->link_r = $this->content->setLink('score/read');
        $this->view->link_p = $this->content->setLink('score/printreportcard');

        $this->view->option_period = $this->optionPeriod();
        $this->view->option_recapitulation = $this->optionRecapitulation();
        $this->view->option_subject = $this->optionSubject();

        $this->view->render('score/index');
    }

    public function read() {
        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectScore($page);
            $total = 11; //$this->model->countAllLanguage();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                //$link_edit = URL::link($this->content->setLink('language/edit/' . $row['language_id']), 'Edit', 'attach');

                $xml .= "<row id='" . $row['subject_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['subject_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['subject_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['teacher_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['kkm'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['score'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $this->textNote($row['score'], $row['kkm']) . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function textNote($score, $kkm) {
        $note = 'Tercapai';
        if ($score > $kkm) {
            $note = 'Terlampaui';
        } else if ($score < $kkm) {
            $note = 'Tidak Tercapai';
        }
        return $note;
    }

    public function printReportCard() {
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
                    font-size : 10pt;
                    font-weight : bold;
                }
                .info-student-label-sparator {
                    width : 10px;
                    font-size : 10pt;
                    font-weight : bold;
                }
                .info-student-label-content {
                    width : 400px;
                    font-size : 10pt;
                }
                .title-period {
                    text-align : center;
                    font-size : 10pt;
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
                    font-size : 10px;
                }
                .box-score-list-head {
                    text-align : center;
                    font-size : 10pt;
                    color : #fff;
                    background-color : #000;
                    border-left : 1px solid #fff;
                    border-right : 1px solid #fff;
                    border-top : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-head-child {
                    text-align : center;
                    font-size : 10pt;
                    color : #fff;
                    background-color : #000;
                    border-left : 1px solid #fff;
                    border-right : 1px solid #fff;
                    border-top : 1px solid #fff;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-head-first {
                    text-align : center;
                    font-size : 10pt;
                    color : #fff;
                    background-color : #000;
                    border-left : 1px solid #000;
                    border-right : 1px solid #fff;
                    border-top : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-head-last {
                    text-align : center;
                    font-size : 10pt;
                    color : #fff;
                    background-color : #000;
                    border-left : 1px solid #fff;
                    border-right : 1px solid #000;
                    border-top : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-content {
                    color : #000;
                    font-size : 10pt;
                    background : #fff;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-content-first {
                    color : #000;
                    font-size : 10pt;
                    background : #fff;
                    border-left : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-sumary {
                    color : #000;
                    font-size : 10pt;
                    background : #fff;
                    border-top : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-sumary-first {
                    color : #000;
                    font-size : 10pt;
                    background : #fff;
                    border-top : 1px solid #000;
                    border-left : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-average {
                    color : #000;
                    font-size : 10pt;
                    background : #fff;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
                }
                .box-score-list-average-first {
                    color : #000;
                    font-size : 10pt;
                    background : #fff;
                    border-left : 1px solid #000;
                    border-right : 1px solid #000;
                    border-bottom : 1px solid #000;
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
                                <td>LAPORAN HASIL BELAJAR SISWA TENGAH SEMESTER 2</td>
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
                                            <td class="info-student-label-content">121308001</td>
                                        </tr>
                                        <tr>
                                            <td class="info-student-label-name">NISN</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">8849484884</td>
                                        </tr>
                                        <tr>
                                            <td class="info-student-label-name">NAMA</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">WARMAN SUGANDA</td>
                                        </tr>
                                        <tr>
                                            <td class="info-student-label-name">KELAS</td>
                                            <td class="info-student-label-sparator">:</td>
                                            <td class="info-student-label-content">IX (SEMBILAN) A</td>
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
                                            <td>2012 / 2013</td>
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
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td align="center" width="40" class="box-score-list-content-first">01.</td>
                    <td align="left" width="225" class="box-score-list-content">Teknologi Informasi dan Komunikasi</td>
                    <td align="center" width="50" class="box-score-list-content">80</td>
                    <td align="center" width="60" class="box-score-list-content">78</td>
                    <td align="left" width="180" class="box-score-list-content">tujuh puluh delapan</td>
                    <td align="center" width="150" class="box-score-list-content">Tidak Tercapai</td>
                </tr>
                <tr>
                    <td align="center" width="40" class="box-score-list-content-first">01.</td>
                    <td align="left" width="225" class="box-score-list-content">Teknologi Informasi dan Komunikasi</td>
                    <td align="center" width="50" class="box-score-list-content">80</td>
                    <td align="center" width="60" class="box-score-list-content">78</td>
                    <td align="left" width="180" class="box-score-list-content">tujuh puluh delapan</td>
                    <td align="center" width="150" class="box-score-list-content">Tidak Tercapai</td>
                </tr>
                <tr>
                    <td align="center" width="40" class="box-score-list-content-first">01.</td>
                    <td align="left" width="225" class="box-score-list-content">Teknologi Informasi dan Komunikasi</td>
                    <td align="center" width="50" class="box-score-list-content">80</td>
                    <td align="center" width="60" class="box-score-list-content">78</td>
                    <td align="left" width="180" class="box-score-list-content">tujuh puluh delapan</td>
                    <td align="center" width="150" class="box-score-list-content">Tidak Tercapai</td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-1">&nbsp;</td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td align="center" width="315" class="box-score-list-sumary-first"><b>JUMLAH</b></td>
                    <td align="center" width="60" class="box-score-list-sumary">980</td>
                    <td align="left" width="330" class="box-score-list-sumary">tujuh puluh delapan</td>
                </tr>
                <tr>
                    <td align="center" width="315" class="box-score-list-average-first"><b>RATA-RATA</b></td>
                    <td align="center" width="60" class="box-score-list-average">980</td>
                    <td align="left" width="330" class="box-score-list-average">tujuh puluh delapan</td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column">&nbsp;</td>
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
                    <td align="center" width="330" class="box-score-list-content">Sangat Baik</td>
                </tr>
                <tr>
                    <td align="left" width="315" class="box-score-list-content-first">2. Paskibra</td>
                    <td align="center" width="60" class="box-score-list-content">B</td>
                    <td align="center" width="330" class="box-score-list-content">Baik</td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="blank-column-2">&nbsp;</td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td align="center" width="315" class="box-score-list-head-first">AHLAK DAN KEPRIBADIAN</td>
                    <td align="center" width="60" class="box-score-list-head">NILAI</td>
                    <td align="center" width="330" class="box-score-list-head-last">KETERANGAN</td>
                </tr>
                <tr>
                    <td align="left" width="315" class="box-score-list-content-first">AHLAK</td>
                    <td align="center" width="60" class="box-score-list-content">A</td>
                    <td align="center" width="330" class="box-score-list-content">Sangat Baik</td>
                </tr>
                <tr>
                    <td align="left" width="315" class="box-score-list-content-first">KEPRIBADIAN</td>
                    <td align="center" width="60" class="box-score-list-content">B</td>
                    <td align="center" width="330" class="box-score-list-content">Baik</td>
                </tr>
            </table>
        ';

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_061.pdf', 'I');
    }

    public function optionPeriod() {
        $option = array();
        $semester = $this->model->selectAllSemester();
        $period = $this->model->selectAllPeriod();
        foreach ($period as $rowperiod) {
            foreach ($semester as $rowsmester) {
                $option[$rowperiod['years_start'] . '' . $rowperiod['years_end'] . '' . $rowsmester['semester_id']] = $rowperiod['years_start'] . ' / ' . $rowperiod['years_end'] . ' - ' . $rowsmester['semester_name'];
            }
        }
        return $option;
    }
    
    public function optionRecapitulation() {
        $option = array();
        $recapitulation = $this->model->selectAllRecapitulation();
        foreach ($recapitulation as $rowrecap) {
            $option[$rowrecap['recapitulation_type_id']] = $rowrecap['recapitulation_type_title'];
        }
        return $option;
    }
    
    public function optionSubject() {
        $option = array();
        $recapitulation = $this->model->selectAllSubject();
        foreach ($recapitulation as $rowrecap) {
            $option[$rowrecap['subject_id']] = $rowrecap['subject_name'];
        }
        return $option;
    }

}