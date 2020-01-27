<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Leave.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog Leave object
  $Leave = new Leave($db);

  // Blog Leave query
  $result = $Leave->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any Leaves
  if($num > 0) {
    // Leave array
    $Leave_arr = array();
    // $Leave_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      // extract($row);

      // $Leave_item = array(
      //   'userId' => $userId,
      //   'UserName' => $UserName,
      //   'Gender' => $Gender,
      //   'deptName' => $deptName,
      //   'branchName' => $branchName
      // );

      // // Push to "data"
      // array_push($Leave_arr, $Leave_item);
      // // array_push($Leave_arr['data'], $Leave_item);

      $Leave_arr[] = $row;
    }

    // Turn to JSON & output
    echo json_encode($Leave_arr);

  } else {
    // No Leaves
    echo json_encode(
      array('message' => 'No Leaves Found')
    );
  }
