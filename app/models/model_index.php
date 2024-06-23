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
                // adds contact for user
                $sql = "INSERT INTO contacts (name, user_id, contact_id, contact_pnumber) VALUES (?, ?, ?, ?)";
                $params = array($post['name'], $this->session_get("id"), $this->doSelect("SELECT id FROM users WHERE pnumber=" . $result[0]['pnumber'])[0]['id'], $post['number']);
                $res1 = $this->doQuery($sql, $params);
                // adds user for contact
                $sql = "INSERT INTO contacts (name, user_id, contact_id, contact_pnumber) VALUES (?, ?, ?, ?)";
                $params = array($this->session_get("number"), $this->doSelect("SELECT id FROM users WHERE pnumber=" . $result[0]['pnumber'])[0]['id'], $this->session_get("id"), $this->session_get("number"));
                $res2 = $this->doQuery($sql, $params);

                if($res1 && $res2){
                    $response += array(
                        "type" => "success",
                        "code" => 0,
                    );
                }else{
                    $response += array(
                        "type" => "error",
                        "code" => 3,
                    );
                }
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
        $result = $this->doSelect("SELECT c.*,u.status FROM contacts c left join users u on c.contact_id=u.id WHERE c.user_id=" . $this->session_get("id"));
        // if(!$result){
        //     $result = $this->doSelect("SELECT * FROM contacts WHERE contact_pnumber=" . $this->session_get("number"));
        // }
        echo json_encode($result);
    }

    function load_messages($post)
    {
        $result = array_merge($this->doSelect("SELECT * FROM messages WHERE sender_id=" . $this->session_get("id") . " AND recipient_id=" . $post["contact-id"]), $this->doSelect("SELECT * FROM messages WHERE sender_id=" . $post["contact-id"] . " AND recipient_id=" . $this->session_get("id")));
        echo json_encode($result);
    }

    function edit_contact($post)
    {
        $sql = ("UPDATE contacts SET name=(?) WHERE user_id=(?) AND contact_id=(?)");
        $params = array($this->check_param($post['name']),$this->session_get("id"),$this->doSelect("SELECT id FROM users WHERE pnumber=" . $this->check_param($post["contact-number"]))[0]['id']);
        $result = $this->doQuery($sql, $params);
        if($result){
            echo json_encode(array(
                "type" => "success",
                "code" => 0,
            ));
        }else{
            echo json_encode(array(
                "type" => "error",
                "code" => 1,
            ));
        }
    }

    function send_message($post)
    {
        $sql = "INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)";
        $params = array($this->session_get("id"), $post["recipient_id"], $post["message"]);
        $this->doQuery($sql, $params);
        echo json_encode(array(
            "type" => "success",
            "code" => 0,
        ));
    }

    function change_status($post){
        if($post["state"] == 1){
            $this->doQuery("UPDATE users SET status=" . 1 . " WHERE pnumber=" . $this->session_get("number"));
        }else{
            $this->doQuery("UPDATE users SET status=" . 0 . " WHERE pnumber=" . $this->session_get("number"));
        }
    }
    function logout()
    {
        $this->doQuery(("UPDATE users SET status=" . 0 . " WHERE user_id=" . $this->session_get("id")));
        $_SESSION = array();
        session_destroy();
    }
}

?>