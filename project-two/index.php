<?php
    include "db.php";
    include "function.php";

    $request = isset($_GET["request"]) ? addslashes(trim($_GET["request"])) : null;
    $jsonArray = array(); 
    $jsonArray["error"] = FALSE; 

    $_code = 200; // Assume that HTTP code is OK
    $_method = $_SERVER["REQUEST_METHOD"]; 


    if($_method  == "POST") { // CREATE
        $username = addslashes($_POST["username"]);
        $name = addslashes($_POST["name"]);
        $password = addslashes($_POST["password"]);
        $mail = addslashes($_POST["mail"]);
        $phone = addslashes($_POST["phone"]);

        $users = $db->query("SELECT * from users WHERE username = '$username' or mail='$mail'");

        // Data Control
        if(empty($username)||empty($name)||empty($password)||empty($mail)||empty($phone)) {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "Fill all the blanks.";
        } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "Invalid mail";
        } else if ($username != checkUsername($username)) {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "Invalid username";
        } else if($users->rowCount() != 0) {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "This username/mail has taken";
        } else {
            $ex = $db->prepare("INSERT INTO users SET username = :username, name = :name, password = PASSWORD(:pass), mail = :mail, phone = :phone");
            $add = $ex->execute(array("username"=>$username,"name"=>$name,"pass"=>$password,"mail"=>$mail,"phone"=>$phone));
            if ($add) {
                $_code = 201;
                $jsonArray["msg"] = "Created successfully.";
            } else {
                $_code = 400;
                $jsonArray["error"] = TRUE;
                $jsonArray["errorMsg"] = "System error";
            }
        }

    } else if($_method == "PUT") { // UPDATE
        $incoming_data = json_decode(file_get_contents("php://input"));

        if(isset($incoming_data->username)&&isset($incoming_data->name)&&
        isset($incoming_data->mail)&&isset($incoming_data->user_id)&&isset($incoming_data->phone)) {
            if($db->query("SELECT * FROM users WHERE id='$incoming_data->user_id'")->rowCount() == 0) {
                $_code = 400;
                $jsonArray["error"] = TRUE;
                $jsonArray["errorMsg"] = "User not found";
            } else if (!filter_var($incoming_data->mail, FILTER_VALIDATE_EMAIL)) {
                $_code = 400;
                $jsonArray["error"] = TRUE;
                $jsonArray["errorMsg"] = "Invalid mail";
            } else {
                $q = $db->prepare("UPDATE users SET username = :username, name = :name, mail = :mail, phone = :phone WHERE id = :user_id");
                $update = $q->execute(array("username"=>$incoming_data->username, 
                                                "name"=>$incoming_data->name, 
                                                "mail"=>$incoming_data->mail,
                                                "phone"=>$incoming_data->phone,
                                                "user_id"=>$incoming_data->user_id));
                if ($update) {
                    $_code = 200;
                    $jsonArray["msg"] = "Update successfully.";
                } else {
                    $_code = 400;
                    $jsonArray["error"] = TRUE;
                    $jsonArray["errorMsg"] = "System error";
                }
            }
        } else {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "Please enter data carefully.";
        }
        
    }else if($_method == "DELETE") { // DELETE
        if (isset($_GET["user_id"]) && !empty(trim($_GET["user_id"]))) {
            $user_id = intval($_GET["user_id"]);
            $isUserExist = $db->query("SELECT * FROM users WHERE id='$user_id'")->rowCount();
            if ($isUserExist) {
                $delete = $db->query("DELETE FROM users WHERE id='$user_id'");
                if ($delete) {
                    $_code = 200;
                    $jsonArray["msg"] = "User deleted";
                } else {
                    $_code = 400;
                    $jsonArray["error"] = TRUE;
                    $jsonArray["errorMsg"] = "System error";
                }
            } else {
                $_code = 400;
                $jsonArray["error"] = TRUE;
                $jsonArray["errorMsg"] = "User not found";
            }
        } else {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "User ID not defined";
        }
        
    }else if($_method == "GET") { // READ
        if (isset($_GET["user_id"]) && !empty(trim($_GET["user_id"]))) {
            $user_id = intval($_GET["user_id"]);
            $isUserExist = $db->query("SELECT * FROM users WHERE id='$user_id'")->rowCount();
            if($isUserExist) {
                $sth = $db->prepare("SELECT * FROM users WHERE id='$user_id'");
                $sth->execute();
                $info = $sth->fetchAll(\PDO::FETCH_ASSOC);
                $jsonArray["user-info"] = $info;
                $_code = 200;
            } else {
                $_code = 400;
                $jsonArray["error"] = TRUE;
                $jsonArray["errorMsg"] = "User not found";
            }
        } else {
            $_code = 400;
            $jsonArray["error"] = TRUE;
            $jsonArray["errorMsg"] = "User ID not defined";
        }
    }else {
        // On error
        $jsonArray["error"] = TRUE;
        $jsonArray["errorMsg"] = "Request not found";
    }

    SetHeader($_code);
    $jsonArray[$_code] = HttpStatus($_code);
    echo json_encode($jsonArray);
?>