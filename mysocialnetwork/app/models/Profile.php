<?php
  class Profile {
		private $db;
		
		public function __construct(){
      $this->db = new Database; 
    }
		
		public function getProfile($id){
			$this->db->query("SELECT * FROM users WHERE id = :id");
			$this->db->bind(':id', $id);

			$results = $this->db->resultset();

      return $results;
		}
  }
?>