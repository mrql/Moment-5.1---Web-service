<?php
    // Send headers
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");

    // Require config-file.
    require_once 'config.php';

    /*
    class Courses
    {
        private $courseCode;
        private $courseProgression;
        private $courseName;
        private $coursePlan;
        
        
    }



    $input = json_decode(file_get_contents('php://input'), true);
    var_dump($input);

    */

    $dbconn = new mysqli($dbhost, $dbuser, $dbpassword, $db);
    if ($dbconn->connect_errno)
    {
        die("Failed to establish a database connection: " . $dbconn->connect_errno);
    }

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method){
        case "GET":
            $sql = $dbconn->prepare("SELECT * FROM Courses");
            $sql->execute();
            break;
            
        case "PUT":
            
            break;
            
        case "POST":
            
            break;
            
        case "DELETE":

            break;
    }

    if($method != "GET")
    {
        $sql = $dbconn->prepare("SELECT * FROM Courses");
        $sql->execute();
    }

    $arr = [];
    $result = $sql->get_result();
    while($row = $result->fetch_assoc())
    {
        $row_arr['Code'] = $row['Code'];
        $row_arr['Name'] = $row['Name'];
        $row_arr['Progression'] = $row['Progression'];
        $row_arr['PlanURL'] = $row['PlanURL'];
        array_push($arr,$row_arr);
    }

    // Print the data in JSON-format.
    echo json_encode($arr);

    // Close database connection.
    $dbconn->close();
?>

