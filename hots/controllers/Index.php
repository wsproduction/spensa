<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }

    public function chart() {

        $mothYear = array("072012", "082012", "092012", "102012", "112012", "122012", "012013", "022013", "032013", "042013", "052013", "062013");

        $dataGrade7 = $this->model->selectChart(1, $mothYear);
        $listGrade7 = $dataGrade7[0];
        $dataGrade8 = $this->model->selectChart(2, $mothYear);
        $listGrade8 = $dataGrade8[0];
        $dataGrade9 = $this->model->selectChart(3, $mothYear);
        $listGrade9 = $dataGrade9[0];

        $chartGrade7 = array((int) $listGrade7['jul'], (int) $listGrade7['aug'], (int) $listGrade7['sep'], (int) $listGrade7['okt'], (int) $listGrade7['nov'], (int) $listGrade7['des'], (int) $listGrade7['jan'], (int) $listGrade7['feb'], (int) $listGrade7['mar'], (int) $listGrade7['apr'], (int) $listGrade7['may'], (int) $listGrade7['jun']);
        $chartGrade8 = array((int) $listGrade8['jul'], (int) $listGrade8['aug'], (int) $listGrade8['sep'], (int) $listGrade8['okt'], (int) $listGrade8['nov'], (int) $listGrade8['des'], (int) $listGrade8['jan'], (int) $listGrade8['feb'], (int) $listGrade8['mar'], (int) $listGrade8['apr'], (int) $listGrade8['may'], (int) $listGrade8['jun']);
        $chartGrade9 = array((int) $listGrade9['jul'], (int) $listGrade9['aug'], (int) $listGrade9['sep'], (int) $listGrade9['okt'], (int) $listGrade9['nov'], (int) $listGrade9['des'], (int) $listGrade9['jan'], (int) $listGrade9['feb'], (int) $listGrade9['mar'], (int) $listGrade9['apr'], (int) $listGrade9['may'], (int) $listGrade9['jun']);
        
        echo json_encode(array($chartGrade7, $chartGrade8, $chartGrade9));
    }

}