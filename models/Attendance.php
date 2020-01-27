<?php

class Attendance {
    // DB stuff
    private $conn;

    // Post Properties
    public $userId;
    public $UserName;
    public $deptName;
    public $branchName;
    public $place;
    public $verifyMode;
    public $remark;
    public $attTime;
    public $clockIn;
    public $clockOut;
    public $otHrs;
    public $date;
    public $clock;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Attendance
    public function read() {
      // Create query
      $query = "Select DISTINCT a.userId, a.UserName, a.branchName, e.deptName, a.clock, a.remarks from
      Employees e, Attendance a
      where a.userId = e.userId and a.branchname = ? and a.clock like ?
      Order by a.clock";

      // Prepare statement
      $stmt = $this->conn->prepare($query);



      // Bind data
      $stmt->bindParam(1, $this->branchName);
      $stmt->bindParam(2, $this->clock);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


    // Create Attendance
    public function create() {
          // Create query
          $query = "INSERT INTO Attendance
          (userId, UserName, Gender, deptName, branchName) VALUES
           (:userId, :UserName, :Gender, :deptName, :branchName)";

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->userId = htmlspecialchars(strip_tags($this->userId));
          $this->UserName = htmlspecialchars(strip_tags($this->UserName));
          $this->Gender = htmlspecialchars(strip_tags($this->Gender));
          $this->deptName = htmlspecialchars(strip_tags($this->deptName));
          $this->branchName = htmlspecialchars(strip_tags($this->branchName));

          // Bind data
          $stmt->bindParam(':userId', $this->userId);
          $stmt->bindParam(':UserName', $this->UserName);
          $stmt->bindParam(':Gender', $this->Gender);
          $stmt->bindParam(':deptName', $this->deptName);
          $stmt->bindParam(':branchName', $this->branchName);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }



  }

?>