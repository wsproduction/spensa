<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->link_score = $this->content->setParentLink('score');
        $count_student = $this->model->countStudent();
        $count_score = $this->model->countScore();

        $student = 0;
        if (count($count_student) > 0) {
            $student = $count_student[0]['cnt'];
        }

        $score = 0;
        if (count($count_score) > 0) {
            $score = $count_score[0]['cnt'];
        }
        
        $this->view->student = $student;
        $this->view->score = $score;

        $this->view->render('index/index');
    }

}