<?php

class Ot {
    // DB stuff
    private $conn;

    // Post Properties
    public $userId;
    public $UserName;
    public $branchName;
    public $remark;
    public $clockIn;
    public $clockOut;
    public $otHrs;
    public $date;
    public $clock;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Ot
    public function read() {
      // Create query
      $query = "Select DISTINCT o.userId, o.UserName, o.branchName, e.deptName, o.date, o.clockIn, o.clockOut , o.otHours
      from Employees e, otTable o
      where o.userId = e.userId
      Order by o.date";

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


    // Create Ot
    public function create() {
          // Create query
          $query = "INSERT INTO otTable
          (`userId`, `userName`, `clockIn`, `clockOut`, `date`, `otHours`, `branchName`)
           VALUES (?, ?, ?, ?, ?, ?, ?)";

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->userId = htmlspecialchars(strip_tags($this->userId));
          $this->UserName = htmlspecialchars(strip_tags($this->UserName));
          $this->clockIn = htmlspecialchars(strip_tags($this->clockIn));
          $this->clockOut = htmlspecialchars(strip_tags($this->clockOut));
          $this->date = htmlspecialchars(strip_tags($this->date));
          $this->otHrs = htmlspecialchars(strip_tags($this->otHrs));
          $this->branchName = htmlspecialchars(strip_tags($this->branchName));

          // Bind data
          $stmt->bindParam(1, $this->userId);
          $stmt->bindParam(2, $this->UserName);
          $stmt->bindParam(3, $this->clockIn);
          $stmt->bindParam(4, $this->clockOut);
          $stmt->bindParam(5, $this->date);
          $stmt->bindParam(6, $this->otHrs);
          $stmt->bindParam(7, $this->branchName);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function search() {
      // Create query
      $query = "Select DISTINCT o.userId, o.UserName, o.branchName, e.deptName, o.date, o.clockIn, o.clockOut , o.otHours
      from Employees e, otTable o
      where o.userId = e.userId and o.branchname = ? and CAST(o.date as date) like ?
      Order by o.date";

      // Prepare statement
      $stmt = $this->conn->prepare($query);



      // Bind data
      $stmt->bindParam(1, $this->branchName);
      $stmt->bindParam(2, $this->clock);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function search() {
      // Create query
      $query = "Select DISTINCT o.userId, o.UserName, o.branchName, e.deptName, o.date, o.clockIn, o.clockOut , o.otHours
      from Employees e, otTable o
      where o.userId = e.userId and o.branchname = ? and CAST(o.date as date) like ?
      Order by o.date";

      // Prepare statement
      $stmt = $this->conn->prepare($query);



      // Bind data
      $stmt->bindParam(1, $this->branchName);
      $stmt->bindParam(2, $this->clock);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

  }

?>