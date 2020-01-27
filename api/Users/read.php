<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Employees.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog employees object
  $employees = new Employees($db);

  // Blog employees query
  $result = $employees->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any employeess
  if($num > 0) {
    // employees array
    $employees_arr = array();
    // $employees_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      // extract($row);

      // $employees_item = array(
      //   'userId' => $userId,
      //   'UserName' => $UserName,
      //   'Gender' => $Gender,
      //   'deptName' => $deptName,
      //   'branchName' => $branchName
      // );

      // // Push to "data"
      // array_push($employees_arr, $employees_item);
      // // array_push($employees_arr['data'], $employees_item);

      $employees_arr[] = $row;
    }

    // Turn to JSON & output
    echo json_encode($employees_arr);

  } else {
    // No employeess
    echo json_encode(
      array('message' => 'No employeess Found')
    );
  }
