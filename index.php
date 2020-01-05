<?php
    // Send headers
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");

    // Require config-file.
    require_once 'config.php';

    class Courses
    {
        private $dbconn;

        function __construct($dbhost, $dbuser, $dbpassword, $db)
        {
            // Establish database connection.
            $this->dbconn = new mysqli($dbhost, $dbuser, $dbpassword, $db);
            if ($this->dbconn->connect_errno)
            {
                die("Failed to establish a database connection: " . $dbconn->connect_errno);
            }
        }

        function getCourses()
        {
            $sql = $this->dbconn->prepare("SELECT * FROM Courses");
            $sql->execute();

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
            return $arr;
        }
        function addCourse()
        {

        }
        function updateCourse()
        {

        }
        function deleteCourse($code)
        {
            $sql = $this->dbconn->prepare("DELETE FROM Courses WHERE Code = ?");
            $sql->bind_param('s', $code);
            $sql->execute();
        }
    }

    $method = $_SERVER['REQUEST_METHOD'];

    $courses = new Courses($dbhost, $dbuser, $dbpassword, $db);

    switch ($method){
        case "GET":
            $courses->getCourses();
            break;
            
        case "PUT":
            
            break;
            
        case "POST":
            
            break;
            
        case "DELETE":
            $input = json_decode(file_get_contents('php://input'), true);
            $courses->deleteCourse($input['code']);
            break;
    }

    // Print the data in JSON-format.
    echo json_encode($courses->getCourses());
?>

