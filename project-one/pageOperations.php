<?php
$flag_dataShown = false;

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["createUser"])) {
    createUser__();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["showUsers"])) {
    showUsers__();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["showUsersJSON"])) {
    showUsersJSON__();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["deleteUser"])) {
    deleteUser__();
}

function createUser__() {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $con = new DBConnection("localhost","root","","demo");
    echo $con->connect_db();
    echo $con->create_user($name,$mail);
    echo $con->close_connection();
}

function showUsers__() {
    echo "<br>";
    $con = new DBConnection("localhost","root","","demo");
    echo $con->connect_db();
    echo $con->create_as_table();
    echo $con->close_connection();
    $flag_dataShown = true;
}

function showUsersJSON__() {
    echo "<br>";
    $con = new DBConnection("localhost","root","","demo");
    echo $con->connect_db();
    echo $con->create_as_json();
    echo $con->close_connection();
    $flag_dataShown = true;
}

function deleteUser__() {
    $id = $_POST['id'];
    $con = new DBConnection("localhost","root","","demo");
    echo $con->connect_db();
    echo $con->delete_user($id);
    echo $con->close_connection();
}
?>