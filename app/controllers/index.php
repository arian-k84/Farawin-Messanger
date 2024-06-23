<?php

class Index extends Controller
{
    public $checkLogin = '';

    function __construct()
    {
        parent::__construct();
        $this->checkLogin = Model::session_get("number");
        if ($this->checkLogin == FALSE) {
            header("Location: " . URL . "/login");
        }
        // if ($this->checkLogin == FALSE) {
        //     header("Location: " . URL . "/login");
        // }
    }

    function index()
    {
//        $widget = $this->model->getWidget($this->checkLogin);
//        $data = array('widget' => $widget);

//        $this->view('index/index', $data);
        $this->view('index/index');
    }

    function add_contact()
    {
        $this->model->add_contact($_POST);
    }

    function get_contacts()
    {
        $this->model->get_contacts();
    }

    function load_messages()
    {
        $this->model->load_messages($_POST);
    }
    function edit_contact()
    {
        $this->model->edit_contact($_POST);
    }
    function send_message()
    {
        $this->model->send_message($_POST);
    }

    function change_status()
    {
        $this->model->change_status($_POST);
    }
    function logout(){
        $this->model->logout();
    }
}