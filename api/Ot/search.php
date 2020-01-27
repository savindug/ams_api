<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Ot.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog ot object
  $ot = new Ot($db);

  $ot->branchName = isset($_GET['branchName']) ? $_GET['branchName'] : die('Request Failed');
  $ot->clock = isset($_GET['clock']) ? $_GET['clock'] : die('Request Failed');

  // Blog ot query
  $result = $ot->search();
  // Get row count
  $num = $result->rowCount();

  // Check if any ots
  if($num > 0) {
    // ot array
    $ot_arr = array();
    // $ot_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      // extract($row);

      // $ot_item = array(
      //   'userId' => $userId,
      //   'UserName' => $UserName,
      //   'Gender' => $Gender,
      //   'deptName' => $deptName,
      //   'branchName' => $branchName
      // );

      // // Push to "data"
      // array_push($ot_arr, $ot_item);
      // // array_push($ot_arr['data'], $ot_item);

      $ot_arr[] = $row;
    }

    // Turn to JSON & output
    echo json_encode($ot_arr);

  } else {
    // No ots
    echo json_encode(
      array('message' => 'No ots Found')
    );
  }
