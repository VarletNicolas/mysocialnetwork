<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database; 
    }

    // Add User / Register
    public function register($data){
      // Prepare Query
      $this->db->query('INSERT INTO users (fname, lname, email, birthday, password,gender,secretquestion,secretanswer) 
      VALUES (:fname, :lname, :email, :birthday, :password, :gender, :secretquestion, :secretanswer)');

      // Bind Values
      $this->db->bind(':fname', $data['fname']);
      $this->db->bind(':lname', $data['lname']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':birthday', $data['birthdate']);
      $this->db->bind(':password', $data['password']);
      $this->db->bind(':gender', $data['gender']);
      $this->db->bind(':secretquestion', $data['secretquestion']);
      $this->db->bind(':secretanswer', $data['secretanswer']);
	  
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Find USer BY Email
    public function findUserByEmail($email){
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      //Check Rows
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Login / Authenticate User
    public function login($email, $password){
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $row = $this->db->single();
      
      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    // Get User By ID
    public function getUserById($id){
      $this->db->query("SELECT * FROM users WHERE id = :id");
      $this->db->bind(':id', $id);

      $row = $this->db->single();

      return $row;
    }

    // Get Secret Question By E-mail
    public function getUserSecretQuestion($email){
      $this->db->query("SELECT secretquestion FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $row = $this->db->single();
      $sq = $row->secretquestion;
      return $sq;
    }

    // Get User By ID
    public function getEmailById($id){
      $this->db->query("SELECT email FROM users WHERE id = :id");
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      $row = $row->email;
      return $row;
    }

    // Verify 
    public function validate($email, $secretanswer){
      $this->db->query("SELECT secretanswer FROM users WHERE email = :email");
      $this->db->bind(':email', $email);

      $row = $this->db->single();
      
      $hashed_secretanswer = $row->secretanswer;
      if(password_verify($secretanswer, $hashed_secretanswer)){
        return $row;
      } else {
        return false;
      }
    }

    // Update password with email
    public function updatePassword($data){
      $this->db->query("UPDATE users SET password = :password WHERE email = :email");
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
?>