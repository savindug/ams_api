<?php
  class Employees {
    // DB stuff
    private $conn;

    // Post Properties
    public $userId;
    public $UserName;
    public $Gender;
    public $deptName;
    public $branchName;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Employees
    public function read() {
      // Create query
      $query = "select * from Employees group by userId";

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    // public function read_single() {
    //       // Create query
    //       $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
    //                                 FROM ' . $this->table . ' p
    //                                 LEFT JOIN
    //                                   categories c ON p.category_id = c.id
    //                                 WHERE
    //                                   p.id = ?
    //                                 LIMIT 0,1';

    //       // Prepare statement
    //       $stmt = $this->conn->prepare($query);

    //       // Bind ID
    //       $stmt->bindParam(1, $this->id);

    //       // Execute query
    //       $stmt->execute();

    //       $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //       // Set properties
    //       $this->title = $row['title'];
    //       $this->body = $row['body'];
    //       $this->author = $row['author'];
    //       $this->category_id = $row['category_id'];
    //       $this->category_name = $row['category_name'];
    // }

    // Create Employees
    public function create() {
          // Create query
          $query = "INSERT INTO Employees
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