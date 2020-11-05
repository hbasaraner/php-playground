<?php

class DBConnection {
    public $servername;
    public $username;
    private $password;
    public $dbname;

    public $connection;

    # Set values at once.
    function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        console_log("All data set.");
    }

    # For showing database information in JSON format
    function get_info() {
        $data = array("servername"=> $this->servername, "username"=>$this->username, "password"=>$this->password, "dbname"=>$this->dbname);
        echo json_encode($data);
    }

    # Open DB connection and set to global variable
    function connect_db() {
        $this->connection = new mysqli($this->servername, $this->username,  $this->password, $this->dbname);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
            }
        console_log("Database connection has established.");
    }

    # Showing raw data in HTML Table (SELECT Query as OOP)
    function create_as_table() {
        $sql = "SELECT * FROM main";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["mail"]."</td></tr>";
            }
            echo "</table>";
            } else {
            echo "0 results";
        }
        console_log("Table is shown.");
    }

    # Showing raw data as JSON format (SELECT Query as Procedural)
    function create_as_json() {
        $query = mysqli_query($this->connection, "SELECT * FROM main");
        $rows = array();
        while($r = mysqli_fetch_assoc($query)) {
            $rows[] = $r;
        }
        echo json_encode($rows);
        console_log("JSON is shown.");
    }

    # Create user
    function create_user($name, $mail) {
        $sql = "INSERT INTO main (name, mail) VALUES (\"".$name."\", \"".$mail."\");";
        if ($this->connection->query($sql)===TRUE) {
            console_log("New record created successfully.");
            echo "<script>alert(\"".$name." created successfully.\");</script>";
        } else {
            console_log("Error: ".$sql." -- ".$this->connection->error);
        }
    }

    function delete_user($id) {
        $sql = "DELETE FROM main WHERE id = ".$id.";";
        if ($this->connection->query($sql)===TRUE) {
            console_log("Record deleted successfully.");
            echo "<script>alert(\"Record deleted successfully.\");</script>";
        } else {
            console_log("Error: ".$sql." -- ".$this->connection->error);
        }
    }

    

    # Close DB connection (This is important)
    function close_connection(){
        $this->connection->close();
        console_log("Connection closed.");
    }
}

# For debugging in console.
function console_log($data="null_log") {
    echo "<script>";
    echo "console.log(\"$data\");";
    echo "</script>";
}
?>