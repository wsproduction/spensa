<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        Src::plugin()->nivoSlider();
        Src::plugin()->jsCountDown();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }

    public function download($filename = '') {
        $download_path = Web::path() . 'asset/template/' . Web::$webTemplate . '/images/';
        //echo $download_path . $filename;
        $args = array(
            'download_path' => $download_path,
            'file' => $filename,
            'extension_check' => TRUE,
            'referrer_check' => FALSE,
            'referrer' => NULL,
        );
        $download = Src::plugin()->PHPDownloader();
        $download->set_args($args);
        $download_hook = $download->get_download_hook();
        
        if ($download_hook['download'] == TRUE) {
            /* Let's download file */
            $download->get_download();
        }
    }

}