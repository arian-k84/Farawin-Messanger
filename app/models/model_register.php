<?php

class model_register extends Model
{
    public $checkLogin = '';
    function __construct()
    {
        parent::__construct();
    }
    function insert_data($post)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $response = array();
            $num = $this->check_param($post["pnumber"]);
            if($num){
                if(preg_match("/^[6789][0-9]{9}$/", $num) && preg_match("/^[\w]*$/", $num)){
                    if(preg_match("/^(?=.*\d)/", $post["password"]) && preg_match("/[a-z]/", $post["password"]) && preg_match("/.[A-Z]/", $post["password"]) && preg_match("/.{6,20}/", $post["password"])){
                        $sql = "SELECT * FROM users WHERE pnumber=?";
                        $params = array($num);
                        $result = $this->doSelect($sql, $params);
                        if(sizeof($result) == 0){
                            $sql = "INSERT INTO users (pnumber,password,register_date) VALUES (?,?,?)";
                            $params = array($num, md5($post['password']), self::jalali_date("Y/m/d"));
                            $this->doQuery($sql, $params);
                            $this->session_set("number", $num);
                            $this->session_set("id", $this->doSelect("SELECT id FROM users WHERE pnumber=" . $num)[0]['id']);
                            $this->checkLogin = $num;
                            $response += array(
                                "type" => "success",
                                "code" => 0
                            );
                        }else{
                            $response += array(
                                // number already exists
                                "type" => "error",
                                "code" =>  2
                            );
                        }
                    }else{
                        $response += array(
                            // password conditions not met
                            "type" => "error",
                            "code" =>  3
                        );
                    }
                }else{
                    $response += array(
                        // unfiltered number
                        "type" => "error",
                        "code" =>  1
                    );
                }
            }
            echo json_encode($response);
        }
    }

}