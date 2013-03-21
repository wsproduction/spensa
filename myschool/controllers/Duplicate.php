<?php

class Duplicate extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('home/index');
    }

    public function classgroup() {
        $period_id = 1;
        $new_semester_id = 2;

        $list_classgroup = $this->model->selectClassGroupByPeriod($period_id);

        foreach ($list_classgroup as $value) {
            $data = array();
            $data['grade'] = $value['classgroup_grade'];
            $data['name'] = $value['classgroup_name'];
            $data['room'] = $value['classgroup_room'];
            $data['period'] = $value['classgroup_period'];
            $data['semester'] = $new_semester_id;
            $data['guardian'] = $value['classgroup_guardian'];

            //$this->model->saveClassGroup($data);
        }
    }

    public function teaching() {
        $period_id = 1;
        $semester_id = 1;
        $new_semester_id = 2;

        $list_classgroup = $this->model->selectClassGroupByPeriod($period_id);
        $classgroup_list = array();
        $classgroup_id = array();

        foreach ($list_classgroup as $value) {

            $classgroup_list[$value['classgroup_id']] = array(
                'grade' => $value['classgroup_grade'],
                'name' => $value['classgroup_name'],
                'period' => $value['classgroup_period']
            );

            $classgroup_id[$value['classgroup_grade']][$value['classgroup_name']][$value['classgroup_period']][$value['classgroup_semester']] = $value['classgroup_id'];
        }

        $list_teaching = $this->model->selectTeachingByPeriod($period_id, $semester_id);

        $data = array();
        foreach ($list_teaching as $value) {
            $data['teacher'] = $value['teaching_teacher'];

            $cl = $classgroup_list[$value['teaching_classgroup']];
            $cgi = $classgroup_id[$cl['grade']][$cl['name']][$cl['period']][$new_semester_id];
            $data['classgroup'] = $cgi;
            $data['subject'] = $value['teaching_subject'];
            $data['total_time'] = $value['teaching_total_time'];
            $data['period'] = $value['teaching_period'];
            $data['semester'] = $new_semester_id;

            //$this->model->saveTeaching($data);
        }
    }

    public function mlc() {
        $period_id = 1;
        $new_semester_id = 2;

        $list_mlc = $this->model->selectMlcByPeriod($period_id);

        foreach ($list_mlc as $value) {
            $data = array();
            $data['subject'] = $value['mlc_subject'];
            $data['period'] = $value['mlc_period'];
            $data['semester'] = $new_semester_id;
            $data['grade'] = $value['mlc_grade'];
            $data['value'] = $value['mlc_value'];
            $data['value'] = $value['mlc_value'];

            //$this->model->saveMlc($data);
        }
    }

    public function classhistory() {
        $period_id = 1;
        $semester_id = 1;
        $new_semester_id = 2;

        $list_classgroup = $this->model->selectClassGroupByPeriod($period_id);
        $classgroup_list = array();
        $classgroup_id = array();

        foreach ($list_classgroup as $value) {

            $classgroup_list[$value['classgroup_id']] = array(
                'grade' => $value['classgroup_grade'],
                'name' => $value['classgroup_name'],
                'period' => $value['classgroup_period']
            );

            $classgroup_id[$value['classgroup_grade']][$value['classgroup_name']][$value['classgroup_period']][$value['classgroup_semester']] = $value['classgroup_id'];
        }

        $list_teaching = $this->model->selectClassHistoryByPeriod($period_id);

        $data = array();
        $idx = 0;
        foreach ($list_teaching as $value) {
            $data['student'] = $value['classhistory_student'];

            $cl = $classgroup_list[$value['classhistory_classgroup']];
            $cgi = $classgroup_id[$cl['grade']][$cl['name']][$cl['period']][$new_semester_id];
            $data['classgroup'] = $cgi;

            $data['status'] = $value['classhistory_status'];
            
            echo $data['student'];// . '<br>';
            /*
            if ($this->model->saveClassHistotry($data)) {
                echo 'OK<br>';
            } else {
                echo 'ERROR<br>';
            }
            */
            $idx++;
        }
        //var_dump($data);
        echo $idx;
    }

    public function guidance() {
        $period_id = 1;
        $semester_id = 1;
        $new_semester_id = 2;

        $list_classgroup = $this->model->selectClassGroupByPeriod($period_id);
        $classgroup_list = array();
        $classgroup_id = array();

        foreach ($list_classgroup as $value) {

            $classgroup_list[$value['classgroup_id']] = array(
                'grade' => $value['classgroup_grade'],
                'name' => $value['classgroup_name'],
                'period' => $value['classgroup_period']
            );

            $classgroup_id[$value['classgroup_grade']][$value['classgroup_name']][$value['classgroup_period']][$value['classgroup_semester']] = $value['classgroup_id'];
        }

        $list_teaching = $this->model->selectGuidanceByPeriod($period_id);

        $data = array();
        $idx = 0;
        foreach ($list_teaching as $value) {

            $cl = $classgroup_list[$value['guidance_classgroup']];
            $cgi = $classgroup_id[$cl['grade']][$cl['name']][$cl['period']][$new_semester_id];
            $data['classgroup'] = $cgi;

            $data['teacher'] = $value['guidance_teacher'];
            $data['period'] = $value['guidance_period'];
            $data['semester'] = $new_semester_id;
            $data['semester'] = $new_semester_id;
            /*
            if ($this->model->saveGuidance($data)) {
                echo 'OK<br>';
            } else {
                echo 'ERROR<br>';
            }
            */
            $idx++;
        }
        
        echo $idx;
    }

    public function extaracuricularCoach() {
        $period_id = 1;
        $semester_id = 1;
        $new_semester_id = 2;

        $list_coach = $this->model->selectExtaracuricularCoachByPeriod($period_id);
        $data = array();
        foreach ($list_coach as $value) {
            $data['coach_name'] = $value['extracurricular_coach_history_name'];
            $data['extra_name'] = $value['extracurricular_coach_history_field'];
            $data['period'] = $value['extracurricular_coach_history_period'];
            $data['semester'] = $new_semester_id;
            $data['total_time'] = $value['extracurricular_coach_history_totaltime'];
            $data['total_time'] = $value['extracurricular_coach_history_totaltime'];
            /*
            if ($this->model->saveExtaracuricularCoach($data)) {
                echo 'OK<br>';
            } else {
                echo 'ERROR<br>';
            }
            */
        }

    }
    

}