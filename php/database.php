<?php
class Database
{
  private $db_host = 'localhost';
  private $db_user = 'root';
  private $db_password = '';
  private $db_name = 'chat_db';

  private $conn;

  public function __construct()
  {
    try {
      $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";
      $this->conn = new PDO($dsn, $this->db_user, $this->db_password);
      $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Database connection failed: " . $e->getMessage());
    }
  }


  public function updateStatus($table, $status, $id)
  {
    if ($this->tableExists($table)) {
      try {
        $sql = "UPDATE $table SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $id);

        return $stmt->execute();

      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }


  // public function lastMessage()
  // {

  //   $result = $this->read("users");
  //   foreach ($result as $row) {
  //     try {
  //       $stmt = $this->conn->prepare("SELECT * FROM chats 
  //           WHERE incoming = ? 
  //           OR outgoing = ?  AND outgoing = ?
  //           OR outgoing = ? ORDER BY id ASC LIMIT 1");

  //       $stmt->bindParam(1, $row['id']);
  //       $stmt->bindParam(2, $row['id']);
  //       $stmt->bindParam(3, $_SESSION['user_id']);
  //       $stmt->bindParam(4, $_SESSION['user_id']);

  //       $stmt->execute();

  //       $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
  //       if(count($result) > 0) {
  //         return $result;
  //       }

  //     } catch (PDOException $e) {
  //       throw new Exception($e->getMessage());
  //     }
  //   }

  // }

  public function readWhere($table, $outgoing, $incoming)
  {
    if ($this->tableExists($table)) {
      try {

        $stmt = $this->conn->prepare("SELECT $table.*, users.img FROM $table 
        LEFT JOIN users ON users.id = ?
        WHERE outgoing = ? AND incoming = ? OR outgoing = ? 
        AND incoming = ? ORDER BY $table.id ASC");

        $stmt->bindParam(1, $outgoing);
        $stmt->bindParam(2, $outgoing);
        $stmt->bindParam(3, $incoming);
        $stmt->bindParam(4, $incoming);
        $stmt->bindParam(5, $outgoing);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
          return $result;
        }
      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }




  public function search($table, $search)
  {
    if ($this->tableExists($table)) {
      try {

        $stmt = $this->conn->prepare("SELECT * FROM $table 
        WHERE fname LIKE ? OR lname LIKE ?");
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(1, $searchTerm);
        $stmt->bindParam(2, $searchTerm);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
          return $result;
        }
      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }




  public function read($table)
  {
    if ($this->tableExists($table)) {
      try {

        $stmt = $this->conn->prepare("SELECT * FROM $table");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
          return $result;
        }
      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }




  public function userById($table, $id)
  {
    if ($this->tableExists($table)) {
      try {

        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
          return $result;
        }
      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }


  public function userByEmail($table, $email)
  {
    if ($this->tableExists($table)) {
      try {

        $stmt = $this->conn->prepare("SELECT id FROM $table WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
          return $result;
        }
      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }

  public function login($email, $password)
  {

    try {
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");

      $stmt->bindParam(1, $email);
      $stmt->bindParam(2, $password);

      $stmt->execute();

      $count = $stmt->fetchColumn();

      return $count > 0;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }


  public function insert($table, $params = array())
  {
    if ($this->tableExists($table)) {
      try {
        // Prepare the column names and placeholders
        $columns = implode(', ', array_keys($params));
        $placeholders = implode(', ', array_fill(0, count($params), '?'));

        // Build the SQL query dynamically
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        // Bind the parameters dynamically
        $i = 1;
        foreach ($params as $key => $value) {
          $stmt->bindValue($i, $value);
          $i++;
        }

        // Execute the query
        return $stmt->execute();
      } catch (PDOException $e) {
        throw new Exception($e->getMessage());
      }
    }
  }

  // public function insert($table, $params = array())
  // {
  //   if ($this->tableExists($table)) {
  //     try {

  //       $table_columns = implode(', ', array_keys($params));
  //       $table_values = implode("', '", $params);

  //       $stmt = $this->conn->prepare("INSERT INTO $table ($table_columns) VALUES(?, ?, ?, ?, ?, ?)");

  //       $stmt->bindParam(1, $params['fname'], PDO::PARAM_STR);
  //       $stmt->bindParam(2, $params['lname'], PDO::PARAM_STR);
  //       $stmt->bindParam(3, $params['email'], PDO::PARAM_STR);
  //       $stmt->bindParam(4, $params['password'], PDO::PARAM_STR);
  //       $stmt->bindParam(5, $params['img'], PDO::PARAM_STR);
  //       $stmt->bindParam(6, $params['status'], PDO::PARAM_STR);

  //       return $stmt->execute();
  //     } catch (PDOException $e) {
  //       throw new Exception($e->getMessage());
  //     }
  //   }
  // }

  private function tableExists($table)
  {
    try {
      $stmt = $this->conn->prepare("SHOW TABLES FROM {$this->db_name} LIKE ?");
      $stmt->bindParam(1, $table);
      $stmt->execute();
      return $stmt !== false;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function checkEmail($email)
  {
    try {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
      $stmt->bindParam(1, $email, PDO::PARAM_STR);

      $stmt->execute();

      $count = $stmt->fetchColumn();

      return $count > 0;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }
}
