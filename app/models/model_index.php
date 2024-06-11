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
                );
            }else{
                $sql = "INSERT INTO contacts (name, user_id, contact_id, contact_pnumber) VALUES (?, ?, ?, ?)";
                $params = array($post['name'], $this->session_get("id"), $this->doSelect("SELECT id FROM users WHERE pnumber=" . $result[0]['pnumber'])[0]['id'], $post['number']);
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

    function get_contacts()
    {
        // $response = array();
        $result = $this->doSelect("SELECT * FROM contacts WHERE user_id=" . $this->session_get("id"));
        
        echo json_encode($result);
    }

    function edit_contact($post)
    {
        $sql = ("UPDATE contacts SET name=(?) WHERE user_id=(?) AND contact_id=(?)");
        $params = array($post['name'],$this->session_get("id"),$this->doSelect("SELECT id FROM users WHERE pnumber=" . $post["contact-number"])[0]['id']);
        $this->doQuery($sql, $params);
        echo json_encode(array(
            "type" => "success",
            "code" => 0,
        ));
    }
}

?>