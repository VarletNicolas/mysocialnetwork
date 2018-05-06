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

		public function changeinfo($data){
			// Prepare Query
      $this->db->query("UPDATE users SET fname=:fname, lname=:lname, email=:email, birthday=:birthday, password=:password, secretquestion=:secretquestion, secretanswer=:secretanswer, phonenb=:tel, city=:city, state=:state, country=:country, zipcode=:zipcode, intro=:intro, website=:website WHERE email = :defaultemail");

      // Bind Values
      $this->db->bind(':fname', $data['fname']);
      $this->db->bind(':lname', $data['lname']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':birthday', $data['birthdate']);
      $this->db->bind(':password', $data['password']);
      $this->db->bind(':secretquestion', $data['secretquestion']);
      $this->db->bind(':secretanswer', $data['secretanswer']);
			$this->db->bind(':defaultemail', $data['defaultemail']);
      $this->db->bind(':tel', $data['tel']);
      $this->db->bind(':city', $data['city']);
      $this->db->bind(':country', $data['country']);
      $this->db->bind(':state', $data['state']);
      $this->db->bind(':zipcode', $data['zipcode']);
      $this->db->bind(':intro', $data['intro']);
      $this->db->bind(':website', $data['website']);
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
		}

		public function changeinforelationship($data){
			// Prepare Query
      $this->db->query("UPDATE users SET relationship = :relationship WHERE email = :defaultemail");

      // Bind Values
      $this->db->bind(':relationship', $data['relationship']);
			$this->db->bind(':defaultemail', $data['defaultemail']);
	
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
    
    public function changeinfowork($data){
			// Prepare Query
      $this->db->query("UPDATE users SET work = :work WHERE email = :defaultemail");

      // Bind Values
      $this->db->bind(':work', $data['work']);
			$this->db->bind(':defaultemail', $data['defaultemail']);
	
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
    
    public function changeinfoschool($data){
			// Prepare Query
      $this->db->query("UPDATE users SET school = :school WHERE email = :defaultemail");

      // Bind Values
      $this->db->bind(':school', $data['school']);
			$this->db->bind(':defaultemail', $data['defaultemail']);
	
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
    
    public function exportfriendsinfotoxml($data){
      // function defination to convert array to xml
      
    }
  }
?>