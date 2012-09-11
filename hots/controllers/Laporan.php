<?php

class Laporan extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Beranda');
        $this->view->render('laporan/guru');
    }
    
    public function guru() {
        Web::setTitle('Laporan Guru');
        $this->view->listData = $this->listDataGuru();
        $this->view->render('laporan/guru');
    }
    
    public function listDataGuru($page = 1) {
        $maxRows = 1;
        $countList = $this->model->countAllGuru();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 4;

        $ddcList = $this->model->selectAllGuru(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['USERID'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                //$html .= Form::commit('attach');
                $html .= $idx;
                $html .= '  </td>';
                $html .= '  <td style="text-align: left;">' . $value['Name'] . '</td>';
                $html .= '  <td>' . $value['Gender'] . '</td>';
                $html .= '  <td>-</td>';
                $html .= '</tr>';

                $idx++;
            }

            $html .= $this->content->paging($jumlah_kolom, $countPage, $page);

            Form::create('hidden', 'hiddenID');
            Form::value($id);
            $html .= Form::commit('attach');
        } else {
            $html .= '<tr>';
            $html .= '   <th colspan="' . $jumlah_kolom . '">Data Not Found</th>';
            $html .= '</tr>';
        }
        return $html;
    }

}