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
            if($post["pnumber"]){
                if(preg_match("/^[\w]*$/", $post["pnumber"])){
                    $sql = "SELECT * FROM users WHERE pnumber=?";
                    $params = array($post['pnumber']);
                    $result = $this->doSelect($sql, $params);
                    if (sizeof($result) == 0) {
                        $sql = "INSERT INTO users (pnumber,password,register_date) VALUES (?,?,?)";
                        $params = array($post['pnumber'], md5($post['password']), self::jalali_date("Y/m/d"));
                        $this->doQuery($sql, $params);
    
                        $response += array(
                            "type" => "success",
                            "code" => 0
                        );
                    } else {
                        $response += array(
                            // number already exists
                            "type" => "error",
                            "code" =>  2
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