<?php

class model_register extends model
{
    function __construct()
    {
        parent::__construct();
    }
    function insert_data($post)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $sql = "SELECT * FROM users WHERE username=?";
            $params = array($post['username']);
            $result = $this->doSelect($sql, $params);

            if (sizeof($result) == 0) {
                if($post['password']!=$post['confirm_password']){
                    echo "error";
                    header("Location: " . URL . "/register");
                    return;
                }
                $sql = "INSERT INTO users (username,password,register_date) VALUES (?,?,?)";
                $params = array($post['username'], md5($post['password']), self::jalali_date("Y/m/d"));
                $this->doQuery($sql, $params);

                echo "ok";
                header("Location: ". URL . "/login");
            } else {
                echo "error";
                header("Location: ". URL . "/register");
            }
        }
    }

}