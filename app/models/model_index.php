<?php

class model_index extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function add_contact($post)
    {
        $response = array();
        if($this->session_get("number") != $post['number']){
            $sql = "SELECT * FROM users WHERE pnumber=?";
            $params = array($post['number']);
            $result = $this->doSelect($sql, $params);

            if (sizeof($result) == 0) {
                $response += array(
                    "type" => "error",
                    "code" => 2,
                    "err_info" => $result[0]['pnumber']
                );
            }else{
                $sql = "INSERT INTO contacts (name, user_id, contact_id) VALUES (?, ?, ?)";
                $params = array($post['name'], $this->doSelect("SELECT id FROM users WHERE pnumber=" . $this->session_get("number"))[0]['id'], $this->doSelect("SELECT id FROM users WHERE pnumber=" . $result[0]['pnumber'])[0]['id']);
                $this->doQuery($sql, $params);
                $response += array(
                    "type" => "success",
                    "code" => 0,
                );
            }
        }else{
            $response += array(
                "type" => "error",
                "code" => 1,
            );
        }
        echo json_encode($response);
    }
}

?>