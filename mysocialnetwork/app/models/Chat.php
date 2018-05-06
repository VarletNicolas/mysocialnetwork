<?php
  class Chat {
    private $db;

    public function __construct(){
			if(!isset($_SESSION['user_id'])){
        redirect('chats/index');
      }
      $this->db = new Database; 
    }
	
		// Add message
    public function addMessage($data){
      // Prepare Query
      $this->db->query('INSERT INTO messages (id_user, id_dest, message) VALUES (:id_user, :id_dest, :message)');

			// Bind Values			
      $this->db->bind(':id_user', $data['emmeteur']);
      $this->db->bind(':id_dest', $data['dest']);
      $this->db->bind(':message', $data['message']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
		
		// Get All Messages
    public function getMessages($id){
      $this->db->query("SELECT * FROM messages where id_user = :id_user ORDER BY send_at DESC;");
			$this->db->bind(':id_user', $id);
			
      $results = $this->db->resultset();

      return $results;
    }	
  }
	
	?>