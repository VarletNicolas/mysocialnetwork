<?php
  class Users extends Controller{
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function index(){
      redirect('welcome');
    }

    public function recover(){
      // Check if logged in 
      if($this->isLoggedIn()){
        redirect('posts');
      }
      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // trim() Strip whitespace (or other characters) from the beginning and end of a string
        $data = [
          'email' => trim($_POST['email']),
          'verification' => '',
          'secretquestion' => '',
          'secretanswer' => '',
          'secretanswer_err' => '',
          'email_err' => '',
          'password' => '',
          'confirm_password' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Validate email
        if(empty($data['email'])){
          $data['email_err'] = 'Veiller entre votre email.';
        } else{
          // Check Email
          if(!$this->userModel->findUserByEmail($data['email'])){
            $data['email_err'] = 'Email inexistante.';
          }// Check Email
          if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $data['email_err'] = 'Format de l\'email non valide.';
          }
        }

        // Make sure errors are empty
        if(empty($data['email_err'])){
          // SUCCESS - Proceed to insert
          // Loas data a new page codevalidation (confirm secret answer)
            $data['secretquestion'] = $this->userModel->getUserSecretQuestion($data['email']);
            $data['verification'] = true;
            $this->view('users/codevalidation', $data);
        } else {
           // Load View
           $this->view('users/recover', $data);
        }
      } else {
        // IF NOT A POST REQUEST

        // Init data
        $data = [
          'email' => '',
          'verification' => '',
          'secretquestion' => '',
          'secretanswer' => '',
          'secretanswer_err' => '',
          'email_err' => '',
          'password' => '',
          'confirm_password' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Load View
        $this->view('users/recover', $data);
      }
    }

    public function codevalidation(){
      // Check if logged in 
      if($this->isLoggedIn()){
        redirect('posts');
      }

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // trim() Strip whitespace (or other characters) from the beginning and end of a string
        $data = [
          'email' => trim($_POST['email']),
          'verification' => '',
          'secretquestion' => '',
          'secretanswer' => trim($_POST['secretanswer']),
          'secretanswer_err' => '',
          'email_err' => '',
          'password' => '',
          'confirm_password' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Test secretanswer
        if(empty($data['secretanswer'])){
          $data['secretanswer_err'] = "Entrer une reponse!";
        }

        // Make sure errors are empty
        if(empty($data['secretanswer_err'])){
          // SUCCESS - Proceed to insert
          // Load data a new page codevalidation (confirm secret answer)

          // Compare secretanswer ...
          if(isset($data['secretanswer'])){
            $toto = $this->userModel->validate($data['email'], $data['secretanswer']);
            if($toto == false){
              $data['secretanswer_err'] = "Mauvaise reponse!";
              $this->view('users/recover', $data);
            } else {
              $this->view('users/changepassword', $data);
            }
          }
        } else {
           // Load View and restart all recover system
           $this->view('users/recover', $data);
        }
      } else {
        // IF NOT A POST REQUEST

        // Init data
        $data = [
          'email' => '',
          'verification' => '',
          'secretquestion' => '',
          'secretanswer' => '',
          'secretanswer_err' => '',
          'email_err' => '',
          'password' => '',
          'confirm_password' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Load View
        $this->view('users/codevalidation', $data);
      }
    }

    public function changepassword(){
      // Check if logged in 
      if($this->isLoggedIn()){
        redirect('posts');
      }

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // trim() Strip whitespace (or other characters) from the beginning and end of a string
        $data = [
          'email' => trim($_POST['email']),
          'verification' => '',
          'secretquestion' => '',
          'secretanswer' => '',
          'secretanswer_err' => '',
          'email_err' => '',
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        

        // Validate password
        if(empty($data['password'])){
          $data['password_err'] = 'Veiller entre votre mot de passe.';     
        } elseif(strlen($data['password']) < 6){
          $data['password_err'] = 'Le mot de passe doit contenir plus de 6 carracteres.';
        }

        // Validate confirm password
        if(empty($data['confirm_password'])){
          $data['confirm_password_err'] = 'Veiller confirmer le mot de passe.';     
        } else {
          if($data['password'] != $data['confirm_password']){
              $data['confirm_password_err'] = 'Les mots de passe ne corresponde pas.';
          }
        }

        if(empty($data['password_err']) && empty($data['confirm_password_err'])){
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          //Execute
          if($this->userModel->updatePassword($data)){
            // Redirect to login
            flash('update_password_success', 'Mot de passe modifier, vous pouvez vous connecter');
            redirect('users/login');
          } else {
            $this->view('users/changepassword', $data);
          }
        } else{
          // Load View
          $this->view('users/changepassword', $data);
        }
      } else {
        // IF NOT A POST REQUEST

        // Init data
        $data = [
          'email' => '',
          'verification' => '',
          'secretquestion' => '',
          'secretanswer' => '',
          'secretanswer_err' => '',
          'email_err' => '',
          'password' => '',
          'confirm_password' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Load View
        $this->view('users/changepassword', $data);
      }
    }

    public function register(){
      // Check if logged in 
      if($this->isLoggedIn()){
        redirect('posts');
      }

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		    // trim() Strip whitespace (or other characters) from the beginning and end of a string
		    // gender default = "homme" 
        $data = [
          'fname' => trim($_POST['fname']),
          'lname' => trim($_POST['lname']),
		      'gender' => trim($_POST['gender']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'secretquestion' => $_POST['secretquestion'],
          'secretanswer' => trim($_POST['secretanswer']),
          'confirm_secretanswer' => trim($_POST['confirm_secretanswer']),
          'birthdate' => trim($_POST['birthdate']),
          'fname_err' => '',
          'lname_err' => '',
		      'gender_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'secretquestion_err' => '',
          'secretanswer_err' => '',
          'confirm_secretanswer_err' => '',
          'birthdate_err' => ''
        ];

        // Validate email
        if(empty($data['email'])){
            $data['email_err'] = 'Veiller entre votre email';
            // Validate name
            if(empty($data['fname'])){
              $data['fname_err'] = 'Veiller entre votre prenom';
            }
            if(empty($data['lname'])){
              $data['lname_err'] = 'Veiller entre votre nom';
            }
        } else{
          // Check Email
          if($this->userModel->findUserByEmail($data['email'])){
            $data['email_err'] = 'Email deja prise.';
          }// Check Email
          if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $data['email_err'] = 'Format de l\'email non valide';
          }
        }

        // Validate password
        if(empty($data['password'])){
          $data['password_err'] = 'Veiller entre votre mot de passe.';     
        } elseif(strlen($data['password']) < 6){
          $data['password_err'] = 'Le mot de passe doit contenir plus de 6 carracteres.';
        }

        // Validate confirm password
        if(empty($data['confirm_password'])){
          $data['confirm_password_err'] = 'Veiller confirmer le mot de passe.';     
        } else {
          if($data['password'] != $data['confirm_password']){
              $data['confirm_password_err'] = 'Les mots de passe ne corresponde pas.';
          }
        }

        // Validate secret question
        if(empty($data['secretquestion'])){
          $data['secretquestion_err'] = 'La question secrete ne peut pas etre vide.';
        }

        // Validate secretanswer
        if(empty($data['secretanswer'])){
          $data['secretanswer_err'] = 'La reponse secrete ne peut pas etre vide.';
        } elseif(strlen($data['secretanswer']) < 6){
          $data['secretanswer_err'] = 'La reponse secrete doit contenir plus de 6 carracteres.';
        }

        // Validate confirm password
        if(empty($data['confirm_secretanswer'])){
          $data['confirm_secretanswer_err'] = 'Veiller confirmer la reponse secrete.';     
        } else {
          if($data['secretanswer'] != $data['confirm_secretanswer']){
              $data['confirm_secretanswer_err'] = 'Les reponses ne corresponde pas.';
          }
        }
        
        // Validate birthdate
        if(empty($data['birthdate'])){
          $data['birthdate_err'] = 'Veiller entre votre mot de passe.';     
        } elseif(strlen($data['birthdate']) < 10){
          $data['birthdate_err'] = 'La date n\'est pas complete.';
        }

        // Make sure errors are empty
        if(empty($data['birthdate_err']) && empty($data['confirm_secretanswer_err']) && empty($data['secretquestion_err']) && empty($data['secretanswer_err']) && empty($data['fname_err']) && empty($data['lname_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          // SUCCESS - Proceed to insert

          // Hash Password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          $data['secretanswer'] = password_hash($data['secretanswer'], PASSWORD_DEFAULT);

          //Execute
          if($this->userModel->register($data)){
            // Redirect to login
            flash('register_success', 'Vous vous ete inscrit, vous pouvez vous connecter');
            redirect('users/login');
          } else {
            die('Erreur sur l\'inscription');
          }
           
        } else {
          // Load View
          $this->view('users/register', $data);
        }
      } else {
        // IF NOT A POST REQUEST

        // Init data
        $data = [
          'fname' => '',
          'lname' => '',
		      'gender' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'secretquestion' => '',
          'secretanswer' => '',
          'confirm_secretanswer' => '',
          'fname_err' => '',
          'lname_err' => '',
		      'gender_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'secretquestion_err' => '',
          'secretanswer_err' => '',
          'confirm_secretanswer_err',
          'birthdate' => '',
          'birthdate_err' => ''
        ];

        // Load View
        $this->view('users/register', $data);
      }
    }

    public function login(){
      // Check if logged in
      if($this->isLoggedIn()){
        redirect('posts');
      }

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $data = [       
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),   
          'save' => trim($_POST['save']),     
          'email_err' => '',
          'password_err' => '',       
        ];
        if(isset($_POST['save']) && $_POST['save'] == 'save'){
          setcookie ("user_email",$_POST["email"],time()+ (10 * 365 * 24 * 60 * 60));
				  setcookie ("user_password",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
        } else {
          if(isset($_COOKIE["user_email"])) {
            setcookie ("user_email","");
          }
          if(isset($_COOKIE["user_password"])) {
            setcookie ("user_password","");
          }
        }

        // Check for email
        if(empty($data['email'])){
          $data['email_err'] = 'Veiller entre votre email.';
        }

        // Check for name
        if(empty($data['name'])){
          $data['name_err'] = 'Veiller entre votre nom.';
        }

        // Check for user
        if($this->userModel->findUserByEmail($data['email'])){
          // User Found
        } else {
          // No User
          $data['email_err'] = 'Cette email nest pas enregistre.';
        }

        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['password_err'])){

          // Check and set logged in user
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser){
            // User Authenticated!
            $this->createUserSession($loggedInUser);
           
          } else {
            $data['password_err'] = 'Mot de passe incorrecte.';
            // Load View
            $this->view('users/login', $data);
          }
           
        } else {
          // Load View
          $this->view('users/login', $data);
        }

      } else {
        // If NOT a POST

        // Init data
        $data = [
          'email' => '',
          'password' => '',
          'save' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // Load View
        $this->view('users/login', $data);
      }
    }

    // Create Session With User Info
    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email; 
      $_SESSION['user_name'] = $user->name;
      redirect('posts');
    }

    // Logout & Destroy Session
    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }

    // Check Logged In
    public function isLoggedIn(){
      if(isset($_SESSION['user_id'])){
        return true;
      } else {
        return false;
      }
    }
  }