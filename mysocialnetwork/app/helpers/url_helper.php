<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

  // Simple page redirect 
  function redirect($page){
    header('location: '.URLROOT.'/'.$page);
  }