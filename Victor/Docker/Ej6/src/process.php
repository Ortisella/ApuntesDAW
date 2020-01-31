<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $mysql_host = "mysql:3306";
        $mysql_username = "user";
        $mysql_password = "user";
        $mysql_database = "testdb";

        $u_name = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
        $u_email = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
        $u_text = filter_var($_POST["user_text"], FILTER_SANITIZE_STRING);

        if (empty($u_name)){
                die("Please enter your name");
        }
        if (empty($u_email) || !filter_var($u_email, FILTER_VALIDATE_EMAIL)){
                die("Please enter valid email address");
        }

        if (empty($u_text)){
                die("Please enter text");
        }

        //Open a new connection to the MySQL server
        $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

        //Output any connection error
        if ($mysqli->connect_error) {
                die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
        }

        $statement = $mysqli->prepare("INSERT INTO users_data (user_name, user_email, user_message) VALUES(?, ?, ?)"); 
        //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
        $statement->bind_param('sss', $u_name, $u_email, $u_text); //bind values and execute insert query

        if($statement->execute()){
                print "Hello " . $u_name . "!, your message has been saved!";
        }else{
                print $mysqli->error; //show mysql error if any
        }
}
?>

