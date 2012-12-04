<?php

class Classgroup extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        Src::plugin()->flexiGrid();
        
        Web::setTitle('Daftar Rombongan Belajar');
        $this->view->period = array();
        $this->view->link_r = $this->content->setLink('classgroup/add');
        $this->view->link_d = $this->content->setLink('classgroup/delete');
        $this->view->render('classgroup/index');
    }
    
    public function add() {
        Web::setTitle('Tambah Daftar Rombongan Belajar');
        Src::plugin()->flexiGrid();
        
        $this->view->option_period = $this->optionPeriod();
        $this->view->option_class = $this->optionClass();
        $this->view->option_guardian = $this->optionGuardian();
        $this->view->link_back = $this->content->setLink('classgroup/index');
        $this->view->render('classgroup/add');
    }

    public function create() {
        $return = array(false,false);
        if ($this->model->saveCreate()) {
           $return = array(true,true); 
        }
        echo json_encode($return);
    }

    public function read() {
        $this->model->selectList();
    }

    public function update() {
        $this->model->selectList();
    }

    public function delete() {
        $this->model->delete();
    }
    
    public function optionClass() {
        $list_grade = $this->model->selectAllGrade();
        $list_classroom = $this->model->selectAllClassRoom();
        
        $option = array();
        
        foreach ($list_grade as $row_grade) {
            foreach ($list_classroom as $row_classroom) {
                $option[$row_grade['grade_id'] . '_' . $row_classroom['classroom_id']] = $row_grade['grade_title'] . ' (' . $row_grade['grade_name'] . ') ' . $row_classroom['classroom_name'];
            }
        }
        return $option;
    }
    
    public function optionPeriod() {
        $list = $this->model->selectAllPeriod();
        $option = array();
        foreach ($list as $row) {
            $option[$row['period_id']] = $row['period_years_start'] . ' / ' . $row['period_years_end'];
        }
        return $option;
    }
    
    public function optionGuardian() {
        $list = $this->model->selectAllGuardian();
        $option = array();
        foreach ($list as $row) {
            $option[$row['employees_id']] = $row['employess_name'];
        }
        return $option;
    }

}