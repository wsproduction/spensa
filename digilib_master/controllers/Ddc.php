<?php

class Ddc extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->topMenu = $this->content->topMenu();

        Session::init();
        if (!Session::get('loginStatus')) {
            Session::destroy();
            $this->url->redirect('index');
            exit;
        }

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
    }

    public function index() {
        Web::title('Dashboard', true, '|');
        $this->view->listData = $this->listData();
        $this->view->render('Ddc/index');
    }

    public function add() {
        Web::title('Dashboard', true, '|');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $this->view->render('Ddc/add');
    }

    public function create() {
        if ($this->model->addSave()) {
            $ket = array(1, $this->message->saveSucces());
        } else {
            $ket = array(1, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    public function read() {
        $page = 1;
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        }
        echo json_encode($this->listData($page));
    }

    public function update() {
        //$this->model->selectList();
    }

    public function delete() {
        echo json_encode($this->model->delete());
    }

    public function getSub1() {
        echo json_encode($this->model->selectSub1());
    }

    public function getSub2() {
        echo json_encode($this->model->selectSub2());
    }

    public function listData($page = 1) {
        $maxRows = 10;
        $countList = $this->model->countAll();
        $countPage = ceil($countList / $maxRows);

        $ddcList = $this->model->selectAll((($page * $maxRows) - $maxRows) + 1 , $page * $maxRows);
        $html = '';
        $jumlah_kolom = 4;
        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['ddc_id'];
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
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td style="text-align: center;">' . $value['ddc_call_number'] . '</td>';
                $html .= '  <td>' . $value['ddc_title'] . '</td>';
                $html .= '  <td style="text-align: center;">-</td>';
                $html .= '</tr>';

                $idx++;
            }

            $html .= $this->paging($countPage, $page);

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

    public function paging($count = 1, $current = 1) {
        $html = '<tr class="pagging">';
        $html .= '  <td colspan="4" class="first">';

        Form::create('button');
        Form::value('Prev');
        Form::style('action_prev');
        $html .= Form::commit('attach');

        $num = array();
        for ($i = 1; $i <= $count; $i++) {
            $num[$i] = $i;
        }

        Form::create('select','paging');
        Form::option($num, '', $current);
        $html .= Form::commit('attach');
        
        Form::create('hidden','maxPaging');
        Form::value($i);
        $html .= Form::commit('attach');

        Form::create('button');
        Form::value('Next');
        Form::style('action_next');
        $html .= Form::commit('attach');

        $html .= '  </td>';
        $html .= '</tr>';
        return $html;
    }

}