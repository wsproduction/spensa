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
        $count_teacher = $this->model->countTeacher();

        $student = 0;
        if (count($count_student) > 0) {
            $student = $count_student[0]['cnt'];
        }

        $score = 0;
        if (count($count_score) > 0) {
            $score = $count_score[0]['cnt'];
        }

        $teacher = 0;
        if (count($count_teacher) > 0) {
            $teacher = $count_teacher[0]['cnt'];
        }
        
        $this->view->student = $student;
        $this->view->score = $score;
        $this->view->teacher = $teacher;

        $this->view->render('index/index');
    }

}