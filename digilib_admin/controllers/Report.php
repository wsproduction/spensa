<?php

class Report extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->poshytip();
        Src::plugin()->highChart();
    }

    public function borrow() {
        Web::setTitle('Laporan Buku Yang Dipinjam');
        $this->view->month_option = $this->content->monthList();
        $this->view->year_option = $this->content->yearList();
        $this->view->render('report/borrow');
    }

    public function borrower() {
        Web::setTitle('Laporan Peminjam Buku');
        $this->view->month_option = $this->content->monthList();
        $this->view->year_option = $this->content->yearList();
        $this->view->render('report/borrower');
    }

    public function pinalty() {
        Web::setTitle('Laporan Denda');
        $this->view->month_option = $this->content->monthList();
        $this->view->year_option = $this->content->yearList();
        $this->view->render('report/pinalty');
    }

    public function readPinalty($period) {
        $period = str_pad($period, 6, "0", STR_PAD_LEFT);
        $data = $this->model->selectPinaltyByPeriod($period);

        $month = substr($period, 0, 2);
        $year = substr($period, -4);

        if (count($data) > 0) {

            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');

            // set default header data
            $pdf->setPrintHeader(false);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, 10, 11);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set font
            $pdf->SetFont('helvetica', '', 11);

            // add a page
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);

            $html = '  <style>
                            table.list tr th {
                                border-right : 1px solid #000;
                                border-top : 1px solid #000;
                                border-bottom : 1px solid #000;
                                font-weight : bold;
                                background-color : #ccc;
                            }
                            table.list tr td {
                                border-right : 1px solid #000;
                                border-bottom : 1px solid #000;
                            }
                            table.list .valign-middle {
                                line-height:7px;
                            }
                            .first {
                                border-left : 1px solid #000;
                            }
                            .no-border_right {
                                border-left : none;
                            }
                        </style>';
            $html .= '<div style="text-align:center;font-weight:bold">';
            $html .= 'LAPORAN DENDA<br>';
            $html .= 'PERIODE BULAN ' . strtoupper($this->content->monthName($month)) . ' ' . $year;
            $html .= '</div>';

            $html .= '<div>';
            $html .= '<table class="list" width="100%">';
            $html .= '  <thead>';
            $html .= '  <tr>';
            $html .= '      <th width="40" height="35" align="center" valign="middle" class="first valign-middle">NO.</th>';
            $html .= '      <th width="75" class="valign-middle" align="center">ID</th>';
            $html .= '      <th width="180" class="valign-middle" >&nbsp;NAMA ANGGOTA</th>';
            $html .= '      <th width="100" class="valign-middle" align="center">JABATAN</th>';
            $html .= '      <th width="100" class="valign-middle" align="center">KETERANGAN</th>';
            $html .= '      <th width="70" align="center" style="line-height:4px;">JUMLAH SANKSI</th>';
            $html .= '      <th width="100" class="valign-middle" align="center">TOTAL DENDA</th>';
            $html .= '  </tr>';
            $html .= '  </thead>';
            
            $idx = 1;
            $pinalty_count= 0;
            $pinalty_total = 0;
            foreach ($data as $value) {
                $html .= '  <tr>';
                $html .= '      <td width="40" align="center" class="first">' . $idx . '</td>';
                $html .= '      <td width="75" align="center">&nbsp;' . $value['members_id'] . '</td>';
                $html .= '      <td width="180" >&nbsp;' . $value['members_name'] . '</td>';
                $html .= '      <td width="100">&nbsp;' . $value['isa_title'] . '</td>';
                $html .= '      <td width="100">&nbsp;' . $value['members_desc'] . '</td>';
                $html .= '      <td width="70" align="center">' . $value['pinalty_count'] . '</td>';
                $html .= '      <td width="20"align="center" style="border-right: none;">Rp.</td>';
                $html .= '      <td width="80"align="right">' . $value['pinalty_total'] . '</td>';
                $html .= '  </tr>';
                $idx++;
                $pinalty_count += $value['pinalty_count'];
                $pinalty_total += $value['pinalty_total'];
            }

            $html .= '  <tr>';
            $html .= '      <td colspan="5" align="center" class="first"><b>TOTAL</b></td>';
            $html .= '      <td align="center">' . $pinalty_count . '</td>';
            $html .= '      <td width="20" align="center" style="border-right: none;">Rp.</td>';
            $html .= '      <td align="right">' . $pinalty_total . '</td>';
            $html .= '  </tr>';

            $html .= '</table>';
            $html .= '</div>';

            $pdf->writeHTML($html);

            //Close and output PDF document
            $pdf->Output('pinalty_' . date('dmYHis') . '.pdf', 'I');
        } else {
            echo $this->message->dataNotFound();
        }
    }

    public function readBorrower($period) {
        $period = str_pad($period, 6, "0", STR_PAD_LEFT);
        $data = $this->model->selectBorrowerByPeriod($period);

        $month = substr($period, 0, 2);
        $year = substr($period, -4);

        if (count($data) > 0) {

            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');

            // set default header data
            $pdf->setPrintHeader(false);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, 10, 11);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set font
            $pdf->SetFont('helvetica', '', 11);

            // add a page
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);

            $html = '  <style>
                            table.list tr th {
                                border-right : 1px solid #000;
                                border-top : 1px solid #000;
                                border-bottom : 1px solid #000;
                                font-weight : bold;
                                background-color : #ccc;
                            }
                            table.list tr td {
                                border-right : 1px solid #000;
                                border-bottom : 1px solid #000;
                            }
                            table.list .valign-middle {
                                line-height:7px;
                            }
                            .first {
                                border-left : 1px solid #000;
                            }
                            .no-border_right {
                                border-left : none;
                            }
                        </style>';
            $html .= '<div style="text-align:center;font-weight:bold">';
            $html .= 'LAPORAN PEMINJAM BUKU<br>';
            $html .= 'PERIODE BULAN ' . strtoupper($this->content->monthName($month)) . ' ' . $year;
            $html .= '</div>';

            $html .= '<div>';
            $html .= '<table class="list" width="100%">';
            $html .= '  <thead>';
            $html .= '  <tr>';
            $html .= '      <th width="40" height="35" align="center" valign="middle" class="first valign-middle">NO.</th>';
            $html .= '      <th width="90" class="valign-middle" align="center">ID</th>';
            $html .= '      <th width="200" class="valign-middle" >&nbsp;NAMA ANGGOTA</th>';
            $html .= '      <th width="100" class="valign-middle" align="center">JABATAN</th>';
            $html .= '      <th width="100" class="valign-middle" align="center">KETERANGAN</th>';
            $html .= '      <th width="140" align="center" class="valign-middle">JUMLAH PINJAMAN</th>';
            $html .= '  </tr>';
            $html .= '  </thead>';
            
            $idx = 1;
            $borrow_count = 0;
            foreach ($data as $value) {
                $html .= '  <tr>';
                $html .= '      <td width="40" align="center" class="first">' . $idx . '</td>';
                $html .= '      <td width="90" align="center">&nbsp;' . $value['members_id'] . '</td>';
                $html .= '      <td width="200" >&nbsp;' . $value['members_name'] . '</td>';
                $html .= '      <td width="100">&nbsp;' . $value['isa_title'] . '</td>';
                $html .= '      <td width="100">&nbsp;' . $value['members_desc'] . '</td>';
                $html .= '      <td width="140" align="center">' . $value['borrow_count'] . '</td>';
                $html .= '  </tr>';
                $idx++;
                $borrow_count += $value['borrow_count'];
            }

            $html .= '  <tr>';
            $html .= '      <td colspan="5" align="center" class="first"><b>TOTAL</b></td>';
            $html .= '      <td align="center">' . $borrow_count . '</td>';
            $html .= '  </tr>';

            $html .= '</table>';
            $html .= '</div>';

            $pdf->writeHTML($html);

            //Close and output PDF document
            $pdf->Output('pinalty_' . date('dmYHis') . '.pdf', 'I');
        } else {
            echo $this->message->dataNotFound();
        }
    }

    public function readBorrow($period) {
        $period = str_pad($period, 6, "0", STR_PAD_LEFT);
        $data = $this->model->selectBorrowByPeriod($period);

        $month = substr($period, 0, 2);
        $year = substr($period, -4);

        if (count($data) > 0) {

            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');

            // set default header data
            $pdf->setPrintHeader(false);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, 10, 11);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set font
            $pdf->SetFont('helvetica', '', 11);

            // add a page
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);

            $html = '  <style>
                            table.list tr th {
                                border-right : 1px solid #000;
                                border-top : 1px solid #000;
                                border-bottom : 1px solid #000;
                                font-weight : bold;
                                background-color : #ccc;
                            }
                            table.list tr td {
                                border-right : 1px solid #000;
                                border-bottom : 1px solid #000;
                            }
                            table.list .valign-middle {
                                line-height:7px;
                            }
                            .first {
                                border-left : 1px solid #000;
                            }
                            .no-border_right {
                                border-left : none;
                            }
                        </style>';
            $html .= '<div style="text-align:center;font-weight:bold">';
            $html .= 'LAPORAN BUKU YANG DIPINJAM<br>';
            $html .= 'PERIODE BULAN ' . strtoupper($this->content->monthName($month)) . ' ' . $year;
            $html .= '</div>';

            $html .= '<div>';
            $html .= '<table class="list" width="100%">';
            $html .= '  <thead>';
            $html .= '  <tr>';
            $html .= '      <th width="40" height="35" align="center" valign="middle" class="first valign-middle">NO.</th>';
            $html .= '      <th width="90" class="valign-middle" align="center">ID BUKU</th>';
            $html .= '      <th width="400" class="valign-middle" >&nbsp;JUDUL BUKU</th>';
            $html .= '      <th width="140" align="center" class="valign-middle">JUMLAH PINJAMAN</th>';
            $html .= '  </tr>';
            $html .= '  </thead>';
            
            $idx = 1;
            $borrow_total = 0;
            foreach ($data as $row) {
                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];
                
                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);
                
                $description  = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';
                
                $html .= '  <tr>';
                $html .= '      <td width="40" align="center" class="first">' . $idx . '</td>';
                $html .= '      <td width="90" align="center">&nbsp;' . $row['book_id'] . '</td>';
                $html .= '      <td width="400" >&nbsp;' . $description . '</td>';
                $html .= '      <td width="140" align="center">' . $row['borrow_count'] . '</td>';
                $html .= '  </tr>';
                $idx++;
                $borrow_total += $row['borrow_count'];
            }

            $html .= '  <tr>';
            $html .= '      <td colspan="3" align="center" class="first"><b>TOTAL</b></td>';
            $html .= '      <td align="center">' . $borrow_total . '</td>';
            $html .= '  </tr>';

            $html .= '</table>';
            $html .= '</div>';

            $pdf->writeHTML($html);

            //Close and output PDF document
            $pdf->Output('pinalty_' . date('dmYHis') . '.pdf', 'I');
        } else {
            echo $this->message->dataNotFound();
        }
    }

}