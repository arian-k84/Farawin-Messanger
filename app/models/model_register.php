<?php

class model_register extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function insert_data($post)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $response = array();
            if($post["username"]){
                if(preg_match("/^[\w]*$/", $post["username"])){
                    $sql = "SELECT * FROM users WHERE username=?";
                    $params = array($post['username']);
                    $result = $this->doSelect($sql, $params);
                    if (sizeof($result) == 0) {
                        $sql = "INSERT INTO users (username,password,register_date) VALUES (?,?,?)";
                        $params = array($post['username'], md5($post['password']), self::jalali_date("Y/m/d"));
                        $this->doQuery($sql, $params);
    
                        $response += array(
                            "type" => "success",
                            "code" => 0
                        );
                    } else {
                        $response += array(
                            // username already exists
                            "type" => "error",
                            "code" =>  2
                        );
                    }
                }else{
                    $response += array(
                        // unfiltered username
                        "type" => "error",
                        "code" =>  1
                    );
                }
            }
            echo json_encode($response);
        }
    }

}