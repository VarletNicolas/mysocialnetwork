<?php
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

    class Searchs extends Controller{
        public function __construct(){
            if(!isset($_SESSION['user_id'])){
                redirect('users/login');
            }
            // Load Models
            $this->searchModel = $this->model('Search');
        }

        // Load Searchpage
        public function searchpattern(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST
                $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    
                $data = [
                    'pattern' => $_POST['pattern'],
                    'searchresult' => '',
                    'pattern_err' => ''
                ];

                if(empty($data['pattern'])) {
                    $data['pattern_err'] = 'recherche vide';
                } 

                // Make sure there are no errors
                if(empty($data['pattern_err'])){
                    // Validation passed
                    
                    
                    //Execute
                    $data['searchresult'] = array_merge($this->searchModel->searchpost($data['pattern']), $this->searchModel->searchuser($data['pattern']));
                    $this->view('searchs/searchpattern', $data);
                } else {
                    // Load view with errors
                    $this->view('searchs/searchpattern', $data);
                }
            } else {
                $data = [
                    'pattern' => '',
                    'searchresult' => '',
                    'pattern_err' => ''
                ];

                $this->view('searchs/searchpattern', $data);
            }
        }
    } 
?>