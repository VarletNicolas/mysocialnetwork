<?php
  class Images extends Controller{
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            redirect('users/login');
        }
        // Load Models
        $this->imageModel = $this->model('Image');
        $this->userModel = $this->model('User');
    }

    

    public function addbgimg(){

    }

    public function addalbum(){
      
    }
    
    public function defaultprofileimage(){

    }

    public function defaultbackgroundimage(){

    }

    public function addimgtoalbum(){

    }

    public function rmimgfromalbum(){

    }
  }