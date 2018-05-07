<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

  class Post {
    private $db;
    
    public function __construct(){
      $this->db = new Database; 
    }

    // Get All Own Posts (YouOnly)
    public function getownPosts($id){
      $this->db->query("SELECT *, posts.id as postId, users.id as userId FROM posts INNER JOIN users ON posts.user_id = users.id WHERE visibility = 'YouOnly' AND user_id = :id ORDER BY posts.created_at DESC;");
      $this->db->bind(':id', $id);
      $results = $this->db->resultset();

      return $results;
    }

    // Get All Public Posts
    public function getPublicPosts(){
      $this->db->query("SELECT *, posts.id as postId, users.id as userId FROM posts INNER JOIN users ON posts.user_id = users.id WHERE visibility = 'Public' ORDER BY posts.created_at DESC;");

      $results = $this->db->resultset();

      return $results;
    }

    // Get All Private Posts
    public function getPrivatePosts($id){
      $this->db->query("SELECT *, posts.id as postId, users.id as userId FROM posts INNER JOIN users ON posts.user_id = users.id WHERE visibility = 'Private' AND user_id = :id ORDER BY posts.created_at DESC;");
      $this->db->bind(':id', $id);
      $results = $this->db->resultset();

      return $results;
    }
/*
    // Get All friend Posts
    public function getFriendPost($id){
      $this->db->query("SELECT *, posts.id as postId, users.id as userId FROM posts INNER JOIN users ON posts.user_id = users.id WHERE visibility = 'private' AND user_id = :id ORDER BY posts.created_at DESC;");
      $this->db->bind(':id', $id);
      $results = $this->db->resultset();

      return $results;
    }*/
  
    // Get All Posts of ID
    public function getPostsUser($id){
      $this->db->query("SELECT * FROM posts WHERE posts.user_id = :id ORDER BY posts.created_at DESC");
      $this->db->bind(':id', $id);
      $results = $this->db->resultset();

      return $results;
    }

    // Get Post By ID
    public function getPostById($id){
      $this->db->query("SELECT * FROM posts WHERE id = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    // Add Post
    public function addPost($data){
      // Prepare Query
      $this->db->query('INSERT INTO posts (title, user_id, body, visibility, img_p_blob) 
      VALUES (:title, :user_id, :body, :visibility, :img_p_blob)');

      // Bind Values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':visibility', $data['visibility']);
      $this->db->bind(':img_p_blob', $data['img_p_blob']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Add Post
    public function addcomments($data){
      // Prepare Query
      $this->db->query('INSERT INTO postcomments (id_post, id_user, comment_text) VALUES (:id_post, :id_user, :comment_text)');

      // Bind Values
      $this->db->bind(':id_post', $data['post']->id);
      $this->db->bind(':id_user', $data['user']->id);
      $this->db->bind(':comment_text', $data['body']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
    
    // Get all comments of the post
    public function getPostComments($id){
      $this->db->query("SELECT * FROM postcomments INNER JOIN users WHERE postcomments.id_post = :id AND postcomments.id_user = users.id ORDER BY postcomments.time DESC");

      $this->db->bind(':id', $id);
      $results = $this->db->resultset();

      return $results;
    }

    // Update Post
    public function updatePost($data){
      // Prepare Query
      $this->db->query('UPDATE posts SET title = :title, body = :body, visibility = :visibility WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':visibility', $data['visibility']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Post
    public function updatePostimg($data){
      // Prepare Query
      $this->db->query('UPDATE posts SET title = :title, body = :body, visibility = :visibility, img_p_blob = :img WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':img', $data['img_p_blob']);
      $this->db->bind(':visibility', $data['visibility']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Delete Post
    public function deletePost($id){
      // Prepare Query
      $this->db->query('DELETE FROM posts WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Add like
    public function addlikes($data2){
      // Prepare Query
      $this->db->query('INSERT INTO likes (id_post, id_user) VALUES (:id_post, :id_user)');

      // Bind Values
      $this->db->bind(':id_post', $data2['id_post']);
      $this->db->bind(':id_user', $data2['id_user']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Check if post was liked by user
    public function isliked($data2){
      // Prepare Query
      $this->db->query('SELECT * FROM likes WHERE id_post = :id_post AND id_user = :id_user');


      // Bind Values
      $this->db->bind(':id_post', $data2['id_post']);
      $this->db->bind(':id_user', $data2['id_user']);
      
      $row = $this->db->single();

      //Check Rows
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Get amout of likes
    public function likeamout($id){
      // Prepare Query
      $this->db->query('SELECT * FROM likes WHERE id_post = :id_post');

      // Bind Values
      $this->db->bind(':id_post', $id);
      
      $row = $this->db->single();
      return $this->db->rowCount();
    }

    // Remove like of unique user
    public function rmlikes($data2){
      // Prepare Query
      $this->db->query('DELETE FROM likes WHERE id_post = :id_post AND id_user = :id_user');

      // Bind Values
      $this->db->bind(':id_post', $data2['id_post']);
      $this->db->bind(':id_user', $data2['id_user']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Remove likes of post
    public function rmlikespost($id){
      // Prepare Query
      $this->db->query('DELETE FROM likes WHERE id_post = :id_post');

      // Bind Values
      $this->db->bind(':id_post', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Remove likes of post
    public function rmpostcomments($id){
      // Prepare Query
      $this->db->query('DELETE FROM postcomments WHERE id_post = :id_post');

      // Bind Values
      $this->db->bind(':id_post', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }