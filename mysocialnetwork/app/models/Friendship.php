<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

  class Friendship {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function addFriendRequest($data){
      // Prepare Query
      $this->db->query("INSERT INTO friendships (id_user1, id_user2, status) VALUES (:id_user1, :id_user2, :status)");

      // Bind Values
      $this->db->bind(':id_user1', $data['id_user1']);
      $this->db->bind(':id_user2', $data['id_user2']);
      $this->db->bind(':status', 'Amis');
	
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Check if friend request has already been sent
    public function IsFRSent($data){
      // Prepare Query
      $this->db->query('SELECT * FROM friendships WHERE id_user1 = :id_user1 AND id_user2 = :id_user2');


      // Bind Values
      $this->db->bind(':id_user1', $data['id_user1']);
      $this->db->bind(':id_user2', $data['id_user2']);
      
      $row = $this->db->single();

      //Check Rows
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Check if U1 & U2 are friends
    public function IsFriends($id1, $id2){
      // Prepare Query
      $this->db->query('SELECT * FROM friendships WHERE id_user1 = :id_user1 AND id_user2 = :id_user2 AND status="amis"');


      // Bind Values
      $this->db->bind(':id_user1', $id1);
      $this->db->bind(':id_user2', $id2);
      
      $row = $this->db->single();

      //Check Rows
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Get all comments of the post
    public function getfriendlist($id){
      $this->db->query('SELECT * FROM friendships WHERE id_user1 = :id OR id_user2 = :id AND status = "Amis" ORDER BY time DESC');
      
      $this->db->bind(':id', $id);
      $results = $this->db->resultset();

      return $results;
    }

    // Remove like of unique user
    public function rmfriedship($id1, $id2){
      // Prepare Query
      $this->db->query('DELETE FROM friendships WHERE (id_user1 = :id_user1 AND id_user2 = :id_user2) OR (id_user1 = :id_user2 AND id_user2 = :id_user1)');

      // Bind Values
      $this->db->bind(':id_user1', $id1);
      $this->db->bind(':id_user2', $id2);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

  }
?>