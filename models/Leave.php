<?php

class Leave {
    // DB stuff
    private $conn;

    // Post Properties
    public $userId;
    public $UserName;
    public $branchName;
    public $remark;
    public $from;
    public $to;
    public $date;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Leave
    public function read() {
      // Create query
      $query = "Select DISTINCT l.userId, l.UserName, l.branchName, e.deptName, l.submittedDate, l.fromDtae ,l.toDate ,l.remarks
      from Employees e, Leaves l
      where l.userId = e.userId
      Order by l.submittedDate";

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

     // Get Leave
     public function search() {
        // Create query
        $query = "Select DISTINCT l.userId, l.UserName, l.branchName, e.deptName, l.submittedDate, l.fromDtae ,l.toDate ,l.remarks
        from Employees e, Leaves l
        where l.userId = e.userId and l.branchname = ? and CAST(l.submittedDate as date) like ?
         Order by l.submittedDate";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(1, $this->branchName);
        $stmt->bindParam(2, $this->date);

        // Execute query
        $stmt->execute();

        return $stmt;
      }


    // Create Leave
    public function create() {
          // Create query
          $query = "INSERT INTO LeaveTable
          (`userId`, `userName`, `clockIn`, `clockOut`, `date`, `LeaveHours`, `branchName`)
           VALUES (?, ?, ?, ?, ?,n?, ?)";

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->userId = htmlspecialchars(strip_tags($this->userId));
          $this->UserName = htmlspecialchars(strip_tags($this->UserName));
          $this->clockIn = htmlspecialchars(strip_tags($this->clockIn));
          $this->clockOut = htmlspecialchars(strip_tags($this->clockOut));
          $this->date = htmlspecialchars(strip_tags($this->date));
          $this->LeaveHrs = htmlspecialchars(strip_tags($this->LeaveHrs));
          $this->branchName = htmlspecialchars(strip_tags($this->branchName));

          // Bind data
          $stmt->bindParam(1, $this->userId);
          $stmt->bindParam(2, $this->UserName);
          $stmt->bindParam(3, $this->clockIn);
          $stmt->bindParam(4, $this->clockOut);
          $stmt->bindParam(5, $this->date);
          $stmt->bindParam(6, $this->LeaveHrs);
          $stmt->bindParam(7, $this->branchName);

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