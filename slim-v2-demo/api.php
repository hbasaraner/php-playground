<?php
    require 'vendor/autoload.php';
    require 'function.php';
    $app = new \Slim\Slim();

    // API Group
    $app->group('/api', function() use ($app) {

        // USER Group
        $app->group('/user', function() use ($app) {

            // GET
            $app->get('/get/:id', function ($id) use ($app) {
                try {
                    $db = new PDO("mysql:host=localhost;dbname=test", "root", "");

                    # Control: Check if user exists
                    $isUserExist = $db->query("SELECT id FROM users WHERE id=$id")->rowCount();
                    if ($isUserExist) {
                        $sql = "SELECT * FROM users WHERE id=$id";
                        $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                        $app->response->setStatus(302); // Found
                        header('Content-type: application/json');
                        echo json_encode($result);
                    } 
                    
                    else {
                        $app->response->setStatus(204); // No Content
                        echo "User not found.";
                    }
                } catch (PDOException $e) {
                    print("Error: ".$e->getMessage());
                    die();
                }
            });

            // POST
            $app->post('/add', function() use($app) {
                try {
                    $input = json_decode($app->request->getBody());

                    $username = addslashes($input->username);
                    $name = addslashes($input->name);
                    $password = addslashes($input->password);
                    $mail = addslashes($input->mail);
                    $phone = addslashes($input->phone);
                    
                    $db = new PDO("mysql:host=localhost;dbname=test", "root", "");

                    # Control: Check if client entered all attributes
                    if(empty($username)||empty($name)||empty($password)||empty($mail)||empty($phone)) {
                        $app->response->setStatus(400); // Bad Request
                        echo "Fill the all blanks";
                    } 
                    
                    # Control: Check if mail entered correctly
                    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        $app->response->setStatus(400); // Bad Request
                        echo "Invalid mail";
                    } 
                    
                    # Control: Check if username entered correct form
                    else if ($username != checkUsername($username)) {
                        $app->response->setStatus(400); // Bad Request
                        echo "Invalid username";
                    } 
                    
                    # Check if user added before
                    else if ($db->query("SELECT * FROM users WHERE username = '$username' OR mail = '$mail'")->rowCount() != 0) {
                        $app->response->setStatus(302); // Found
                        echo "User already added";
                    } 
                    
                    else {
                        $sql = "INSERT INTO users (username, name, password, mail, phone) VALUES (?,?,PASSWORD(?),?,?)";
                        $result = $db->prepare($sql)->execute([$username, $name, $password, $mail, $phone]);

                        if ($result) {
                            $app->response->setStatus(201); // Created
                            header('Content-type: application/json');
                            echo "User added";
                        }
                    }
                } catch (PDOException $e) {
                    print("Error: ".$e->getMessage());
                    die();
                }
            });

            // PUT
            $app ->put('/update/:id', function($id) use ($app) {
                try {
                    // $input = json_decode(file_get_contents("php://input"));
                    $input = json_decode($app->request->getBody());

                    $username = addslashes($input->username);
                    $name = addslashes($input->name);
                    $password = addslashes($input->password);
                    $mail = addslashes($input->mail);
                    $phone = addslashes($input->phone);

                    $db = new PDO("mysql:host=localhost;dbname=test", "root", "");
                    
                    # Control: Check if user exists
                    $isUserExist = $db->query("SELECT id FROM users WHERE id=$id")->rowCount();
                    if (!$isUserExist) {
                        $app->response->setStatus(204); // No Content
                        echo "User not found.";
                    } 
                    
                    # Control: Check if mail entered correctly
                    else if (!filter_var($incoming_data->mail, FILTER_VALIDATE_EMAIL)) {
                        $app->response->setStatus(400); // Bad Request
                        echo "Invalid mail";
                    } 
                    
                    else {
                        $sql = "UPDATE users SET username = ?, name = ?, mail = ?, phone = ? WHERE id = ?";
                        $result = $db->prepare($sql)->execute([$username, $name, $mail, $phone, $id]);
                        if ($result) {
                            $app->response->setStatus(200);
                            echo "User ID: ".$id." is updated.";
                        }
                    }
                } catch(PDOException $e) {
                    print("Error: ".$e->getMessage());
                    die();
                }
            });

            // DELETE
            $app ->delete('/delete/:id', function($id) use ($app) {
                try {
                    $db = new PDO("mysql:host=localhost;dbname=test", "root", "");

                    # Control: Check if user exists
                    $isUserExist = $db->query("SELECT id FROM users WHERE id=$id")->rowCount();
                    if (!$isUserExist) {
                        $app->response->setStatus(204); // No Content
                        echo "User not found.";
                    }

                    else {
                        $sql = "DELETE FROM users WHERE id='$id'";
                        $result = $db->query($sql);
                        if ($result) {
                            $app->response->setStatus(410); // Gone
                            echo "User ID: ".$id." is deleted.";
                        }
                    }
                } catch(PDOException $e) {
                    print("Error: ".$e->getMessage());
                    die();
                }
            });
        });
    });
    $app->run();
?>