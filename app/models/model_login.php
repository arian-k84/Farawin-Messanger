<?php

class model_login extends Model
{
    public $checkLogin = '';

    function __construct()
    {
        parent::__construct();
    }

    function check_data($post)
    {
        $response = array();
        $sql = "SELECT * FROM users WHERE username=? and password=?";
        $params = array($post['username'], md5($post['password']));
        $result = $this->doSelect($sql, $params);

        if (sizeof($result) == 0) {
            $response += array(
                "type" => "error",
                "code" => 0,
            );
        } else {
            $this->session_set("username", $result[0]['username']);
            $this->checkLogin = $result[0]['username'];
            $response += array(
                "type" => "success",
                "code" => 1,
            );
            // header("Location: " . URL . "/index");
        }
        echo json_encode($response);
    }
}
