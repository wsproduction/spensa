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
        Web::setTitle('Laporan Peminjaman Buku');
        $this->view->render('report/index');
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
            $pdf->SetHeaderData('', '', 'PERPUSTAKAAN', 'SMP NEGERI 1 SUBANG');

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, 20, 11);
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
                            .first {
                                border-left : 1px solid #000;
                            }
                        </style>';
            $html .= '<div style="text-align:center;font-weight:bold">';
            $html .= 'LAPORAN DENDA<br>';
            $html .= 'PERIODE BULAN ' . strtoupper($this->content->monthName($month)) . ' ' . $year;
            $html .= '</div>';

            $html .= '<div>';
            $html .= '<table class="list" width="100%">';
            $html .= '  <tr>';
            $html .= '      <th width="60" align="center" class="first">NO.</th>';
            $html .= '      <th width="280" >&nbsp;NAMA ANGGOTA</th>';
            $html .= '      <th width="165" align="center">JUMLAH SANKSI</th>';
            $html .= '      <th width="165" align="center">TOTAL DENDA</th>';
            $html .= '  </tr>';

            foreach ($data as $value) {
                $html .= '  <tr>';
                $html .= '      <td width="60" align="center" class="first">NO.</td>';
                $html .= '      <td width="280" >&nbsp;NAMA ANGGOTA</td>';
                $html .= '      <td width="165" align="center">JUMLAH SANKSI</td>';
                $html .= '      <td width="165" align="center">TOTAL DENDA</td>';
                $html .= '  </tr>';
            }

            $html .= '  <tr>';
            $html .= '      <td colspan="3" align="center" class="first"><b>TOTAL</b></td>';
            $html .= '      <td width="165" align="center"></td>';
            $html .= '  </tr>';

            $html .= '</table>';
            $html .= '</div>';

            $pdf->writeHTML($html);

            //Close and output PDF document
            $pdf->Output('pinalty_' . date('dmYHis') . '.pdf', 'I');
        } else {
            echo 'Maaf Daftar Print Tidak Ditemukan!';
        }
    }

}