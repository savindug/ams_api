<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: ot');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/ot.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog ot object
  $ot = new Ot($db);

  // Get raw ot data
  $data = json_decode(file_get_contents("php://input"));

  $ot->userId = $data->userId;
  $ot->UserName = $data->UserName;
  $ot->clockIn = $data->clockIn;
  $ot->clockOut = $data->clockOut;
  $ot->date = $data->date;
  $ot->otHrs = $data->otHrs;
  $ot->branchName = $data->branchName;

  // Create ot
  if($ot->create()) {
    echo json_encode(
      array('message' => 'ot Created')
    );
  } else {
    echo json_encode(
      array('message' => 'ot Not Created')
    );
  }

