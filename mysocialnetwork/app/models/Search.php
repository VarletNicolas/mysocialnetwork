<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

  class Search {
    private $db;

    public function __construct(){
      $this->db = new Database; 
    }

    public function searchpost($pattern){
      $this->db->query("SELECT *, posts.id AS PID FROM posts, users WHERE title LIKE :pattern and posts.user_id = users.id");
      $this->db->bind(':pattern', $pattern);
      $results = $this->db->resultset();

      return $results;
    }

    public function searchuser($pattern){
      $this->db->query("SELECT * FROM users WHERE lname LIKE :pattern OR fname LIKE :pattern OR city LIKE :pattern");
      $this->db->bind(':pattern', $pattern);
      $results = $this->db->resultset();

      return $results;
    }
  }
?>