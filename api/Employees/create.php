<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: users');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog users object
  $users = new Users($db);

  // Get raw usersed data
  $data = json_decode(file_get_contents("php://input"));

  $users->userId = $data->userId;
  $users->UserName = $data->UserName;
  $users->Gender = $data->Gender;
  $users->deptName = $data->deptName;
  $users->branchName = $data->branchName;

  // Create users
  if($users->create()) {
    echo json_encode(
      array('message' => 'users Created')
    );
  } else {
    echo json_encode(
      array('message' => 'users Not Created')
    );
  }

