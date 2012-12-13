<?php

class Teaching extends Controller {

    public function __construct() {
        parent::__construct();
        Src::plugin()->flexiGrid();
        Src::plugin()->jQueryValidation();
    }

    public function index() {
        Web::setTitle('Daftar Tugas Mengajar Mengajar');
        $this->view->period = array();
        $this->view->link_r = $this->content->setLink('teaching/add');
        $this->view->link_d = $this->content->setLink('teaching/delete');
        $this->view->render('teaching/index');
    }
    
    public function add() {
        Web::setTitle('Tambah Daftar Rombongan Belajar');
        $this->view->option_period = $this->optionPeriod();
        $this->view->option_teacher = $this->optionTeacher();
        $this->view->option_subject= $this->optionTeacher();
        $this->view->link_back = $this->content->setLink('teaching/index');
        $this->view->ling_get_class = $this->content->setLink('teaching/getclass');
        $this->view->render('teaching/add');
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
    
    public function optionTeacher() {
        $list = $this->model->selectAllTeacher();
        $option = array();
        foreach ($list as $row) {
            $option[$row['employees_id']] = $row['employess_name'];
        }
        return $option;
    }

}