<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

  class Posts extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
      $this->imageModel = $this->model('Image');
      $this->friendshipModel = $this->model('Friendship');
    }

    // Load All Posts
    public function index(){
      $postsyouonly = $this->postModel->getownPosts($_SESSION['user_id']);
      $postspublic = $this->postModel->getPublicPosts();
      $postsprivate = $this->postModel->getPrivatePosts($_SESSION['user_id']);

      $Posts = array_merge($postsyouonly, $postspublic, $postsprivate);

      $getfriends = $this->friendshipModel->getfriendlist($_SESSION['user_id']);
      $fppost =[]; $friendarray = [];
      foreach ($getfriends as $f) {
        if(($f->id_user1 == $_SESSION['user_id']) && (!in_array($f->id_user2, $friendarray))){
          $tmp = $this->postModel->getPrivatePosts($f->id_user2);
          $fppost = array_merge($fppost, $tmp);
          array_push($friendarray, $f->id_user2);
        } elseif(($f->id_user2 == $_SESSION['user_id']) && (!in_array($f->id_user1, $friendarray))){
          $tmp = $this->postModel->getPrivatePosts($f->id_user1);
          $fppost = array_merge($fppost, $tmp);
          array_push($friendarray, $f->id_user1);
        }
      }
      $Posts = array_merge($Posts, $fppost);
      
      $data = [
        'getfriends' => $getfriends,
        'posts' => $Posts
      ];
      
      $this->view('posts/index', $data);
    }

    // Show Single Post
    public function show($id){
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);
      $nbofview = $this->postModel->likeamout($post->id);
      $comments = $this->postModel->getPostComments($id);

      $data = [
        'post' => $post,
        'nbofview' => $nbofview,
        'user' => $user,
        'comments' => $comments,
        'body' => '',
        'body_err' => ''
      ];

      $this->view('posts/show', $data);
    }

    // Add Post
    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'visibility' => trim($_POST['viewable']),
          'img_p_blob' => file_get_contents($_FILES['img_p_blob']['tmp_name']),
          'size' => round(filesize($_FILES["img_p_blob"]["tmp_name"]) /1024, 5),
          'extension' => pathinfo($_FILES['img_p_blob']['name'], PATHINFO_EXTENSION),
          'title_err' => '',
          'body_err' => '',
          'img_p_blob_err' => '',
          'size_err' => '',
          'extension_err' => ''
        ];

        if(empty($data['img_blob'])) {
          $data['img_blob'] = '';
        } else {
          // Check extension
          if(empty($data['extension'])){
            $data['extension_err'] = "Votre image doit porter une extension";
          } elseif($data['extension'] != "jpg" && $data['extension'] != "png" && $data['extension'] != "jpeg" && $data['extension'] != "gif" ) {
              $data['extension_err'] = "Le format de l'image n'est pas supporter.";
          }
          // Limit size to 1mb
          if($data['size']>1000){
            $data['size_err'] = "Votre image pese plus de 1Mb.";
          }
        }
        
        // Validate email
        if(empty($data['title'])){
          $data['title_err'] = 'Veuiller entrer le titre';
          // Validate name
          if(empty($data['body'])){
            $data['body_err'] = 'Ecrire ici';
          }
        }

        // Make sure there are no errors
        if(empty($data['title_err']) && empty($data['body_err']) && empty($data['size_err']) && empty($data['extension_err']) && empty($data['body_err'])){
          // Validation passed
          
          
          //Execute
          if($this->postModel->addPost($data)){
            // Redirect to login
            flash('post_added', 'Post Ajouter');
            redirect('posts');
          } else {
            die('bug');
          }
        } else {
          // Load view with errors
          $this->view('posts/add', $data);
        }
      } else {
        $data = [
          'title' => '',
          'body' => '',
          'user_id' =>'',
          'visibility' => '',
          'img_p_blob' => '',
          'size' => '',
          'extension' => '',
          'title_err' => '',
          'body_err' => '',
          'img_p_blob_err' => '',
          'size_err' => '',
          'extension_err' => ''
        ];

        $this->view('posts/add', $data);
      }
    }

    // Edit Post
    public function edit($id){
      // Get post from model
      $post = $this->postModel->getPostById($id);

      // Check for owner
      if($post->user_id != $_SESSION['user_id']){
        redirect('posts');
      }
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'visibility' => trim($_POST['viewable']),
          'img_p_blob' => file_get_contents($_FILES['img_p_blob']['tmp_name']),
          'size' => round(filesize($_FILES["img_p_blob"]["tmp_name"]) /1024, 5),
          'extension' => pathinfo($_FILES['img_p_blob']['name'], PATHINFO_EXTENSION),
          'title_err' => '',
          'body_err' => '',
          'img_p_blob_err' => '',
          'size_err' => '',
          'extension_err' => ''
        ];

        if(empty($data['img_blob'])) {
          $data['img_blob'] = '';
        } else {
          // Check extension
          if(empty($data['extension'])){
            $data['extension_err'] = "Votre image doit porter une extension";
          } elseif($data['extension'] != "jpg" && $data['extension'] != "png" && $data['extension'] != "jpeg" && $data['extension'] != "gif" ) {
              $data['extension_err'] = "Le format de l'image n'est pas supporter.";
          }
          // Limit size to 1mb
          if($data['size']>1000){
            $data['size_err'] = "Votre image pese plus de 1Mb.";
          }
        }

        
        // Validate email
        if(empty($data['title'])){
          $data['title_err'] = 'Veuiller entrer le titre';
          // Validate name
          if(empty($data['body'])){
            $data['body_err'] = 'Ecrire ici';
          }
        }

        // Make sure there are no errors
        if(empty($data['title_err']) && empty($data['body_err']) && empty($data['size_err']) && empty($data['extension_err']) && empty($data['body_err'])){
          // Validation passed
          
          
          //Execute
          if($this->postModel->updatePostimg($data)){
            // Redirect to login
            flash('post_message', 'Post MAJ');
            redirect('posts');
          } else {
            die('bug');
          }
        } else {
          // Load view with errors
          $this->view('posts/edit', $data);
        }
      } else {
        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body,
          'visibility' => $post->visibility,
          'user_id' => $_SESSION['user_id'],
          'img_p_blob' => '',
          'size' => '',
          'extension' => '',
          'title_err' => '',
          'body_err' => '',
          'img_p_blob_err' => '',
          'size_err' => '',
          'extension_err' => ''
        ];

        $this->view('posts/edit', $data);
      }
    }

    // Delete Post
    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Execute
        if(($this->postModel->deletePost($id)) && ($this->postModel->rmlikespost($id)) && ($this->postModel->rmpostcomments($id))){
          // Redirect to login
          flash('post_message', 'Post Supprimer');
          redirect('posts');
          } else {
            die('Bug');
          }
      } else {
        redirect('posts');
      }
    }

    // Add like
    public function addlike($id){
      $data = [
        'id_post' => $id, 
        'id_user' => $_SESSION['user_id']
      ];
      if(!$this->postModel->isliked($data)){
        $this->postModel->addlikes($data);
      } else {
        $this->postModel->rmlikes($data);
      }
      redirect('posts/index');
    }
    
    // Add comment
    public function addcomment($id){
      $post = $this->postModel->getPostById($id);
      // Check if POST
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				$data = [
          'post' => $post,
          'nbofview' => $this->postModel->likeamout($post->id),
          'user' => $this->userModel->getUserById($post->user_id),
          'body' => trim($_POST['body']),
          'body_err' => ''
				];
				
				if(empty($data['body'])){
          $data['body_err'] = "Veiller entrer un commentaire";
        }

				// Make sure errors are empty
				if(empty($data['body_err'])){
          if($this->postModel->addcomments($data)){
            flash('post_comment_added', 'Commentaire ajouter');
            redirect('posts');
          } else {
            // Load View
            flash('post_comment_not_added', 'Commentaire non ajouter');
            redirect('posts');
          }            
				} else {
          // Load View
          flash('post_comment_not_added', 'Commentaire non ajouter');
					redirect('posts');
				}
			} else {
				// IF NOT A POST REQUEST

				// Init data
				$data = [
					'post' => $post,
          'nbofview' => $this->postModel->likeamout($post->id),
          'user' => $this->userModel->getUserById($post->user_id),
          'body' => '',
          'body_err' => ''
				];

				// Load View
				redirect('posts');
			}
    }
  }