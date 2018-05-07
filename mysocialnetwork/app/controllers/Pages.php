<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

  class Pages extends Controller{
    public function __construct(){
     
  }

  // Load Homepage
  public function index(){
    // If logged in, redirect to posts
    if(isset($_SESSION['user_id'])){
      redirect('posts');
    }

    //Set Data
    $data = [
      'title' => 'Bienvenu sur MySocialNetwork',
      'description' => 'Projet de reseaux social fait maison a l\'aide de php oop, mysql, fonde sur une architecture mvc'
    ];

    // Load homepage/index view
    $this->view('pages/index', $data);
  }

  public function about(){
    //Set Data
    $data = [
      'version' => '0.1.0'
    ];

    // Load about view
    $this->view('pages/about', $data);
  }
}