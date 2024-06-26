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
        $num = $this->check_param($post['number']);
        if(preg_match("/^[6789][0-9]{9}$/", $num)){
            $sql = "SELECT * FROM users WHERE pnumber=? and password=?";
            $params = array($num, md5($post['password']));
            $result = $this->doSelect($sql, $params);

            if (sizeof($result) == 0) {
                $response += array(
                    "type" => "error",
                    "code" => 0,
                );
            }else{
                $this->session_set("number", $result[0]['pnumber']);
                $this->session_set("id", $this->doSelect("SELECT id FROM users WHERE pnumber=" . $result[0]['pnumber'])[0]['id']);
                $this->checkLogin = $result[0]['pnumber'];
                $response += array(
                    "type" => "success",
                    "code" => 1,
                );
                // header("Location: " . URL . "/index");
            }
            echo json_encode($response);
        }else{
            $response += array(
                "type" => "error",
                "code" => 0,
            );
        }
    }
}
