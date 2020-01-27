<?php
//Interact with HTTP
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/attendance.php';


//Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

//Instantiate Blog attendance Object
$attendance = new Attendance($db);

//Get branchname & clock from URL
$attendance->branchName = isset($_GET['branchName']) ? $_GET['branchName'] : die('Request Failed');
$attendance->clock = isset($_GET['clock']) ? $_GET['clock'] : die('Request Failed');

print_r(json_encode($attendance->branchName));
print_r(json_encode($attendance->clock));


//Get attendance
$attendance->read();
$num = $result->rowCount();

  // Check if any attendances
  if($num > 0) {
    // attendance array
    $attendance_arr = array();
    // $attendance_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $attendance_arr[] = $row;
    }

//Convert to JSON Data
print_r(json_encode($attendance_arr));

} else {
  // No employeess
  echo json_encode(
    array('message' => 'No Attendance Recorde Found')
  );
}