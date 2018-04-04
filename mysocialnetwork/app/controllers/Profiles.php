<?php 
	class Profiles extends Controller {
		public function __construct(){
		  if(!isset($_SESSION['user_id'])){
			redirect('users/login');
		  }
		  // Load Models
		  $this->profileModel = $this->model('Profile');
			$this->userModel = $this->model('User');
			$this->imageModel = $this->model('Image');
		}
		// load profile of current user
		public function index(){
			$profile = $this->profileModel->getProfile($_SESSION['user_id']);
			$images = $this->imageModel->getProfileimg($_SESSION['user_id']);
			$imagesbg = $this->imageModel->getBackgroundimg($_SESSION['user_id']);
			$data = [
				'profile' => $profile,
				'imageProfile' => $images,
				'imageBackground' => $imagesbg
			];
			
			$this->view('profiles/index', $data);
		}

		public function edit(){
			$data = [];
			// Load View
			$this->view('profiles/edit', $data);
		}

		public function addpimg(){
      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // trim() Strip whitespace (or other characters) from the beginning and end of a string
        $data = [
          'complete_img_name' => $_FILES['complete_img_name']['name'],
          'id_user' => $_SESSION['user_id'],
          'name' => pathinfo($_FILES['complete_img_name']['name'], PATHINFO_FILENAME),
          'extension' => pathinfo($_FILES['complete_img_name']['name'], PATHINFO_EXTENSION),
					'type_usage' => 'Profile',
					// kilobytes with two digits
          'size' => round(filesize($_FILES["complete_img_name"]["tmp_name"]) /1024, 5),
          'img_blob' => '',
          'name_err' => '',
          'extension_err' => '',
          'type_usage_err' => '',
          'size_err' => '',
          'img_blob_err' => '',
          'complete_img_name_err' => ''
				];
				
				// Check if he have a file
				if(empty($data['complete_img_name'])){
					$data['complete_img_name_err'] = "Aucun fichier selectionner.";
				}

				if(empty($data['name'])){
					$data['name_err'] = "Votre image doit porter un nom";
				}

				if(empty($data['extension'])){
					$data['extension_err'] = "Votre image doit porter une extension";
				}

				// Limit size to 1mb
        if($data['size']>1000){
					$data['size_err'] = "Votre image pese plus de 1Mb.";
				}

				// Allow certain file formats
				if($data['extension'] != "jpg" && $data['extension'] != "png" && $data['extension'] != "jpeg" && $data['extension'] != "gif" ) {
					$data['extension_err'] = "Le format de l'image n'est pas supporter.";
				}
				

        // Make sure errors are empty
        if(empty($data['desc_err']) && empty($data['name_err']) && empty($data['extension_err']) && empty($data['viewed_number_err']) && empty($data['type_usage_err']) && empty($data['size_err']) && empty($data['complete_img_name_err'])){
					// SUCCESS - Proceed to insert
					// Send image to database
					$data['img_blob'] = file_get_contents($_FILES['complete_img_name']['tmp_name']);
					if(empty($data['img_blob'])) {
						$data['img_blob_err'] = "Choisisser une image.";
					}
					$this->imageModel->addpimage($data);
					// Redirect to login
					flash('image_profile_uploaded', "L'image de profile a bien ete mis a jour.");
					redirect('profiles/edit');			
        } else {
           // Load View
           $this->view('profiles/addpimg', $data);
        }
      } else {
        // IF NOT A POST REQUEST

        // Init data
        $data = [
          'complete_img_name' => '',
          'id_user' => '',
          'name' => '',
          'extension' => '',
          'type_usage' => '',
          'size' => '',
          'img_blob' => '',
          'name_err' => '',
          'extension_err' => '',
          'type_usage_err' => '',
          'size_err' => '',
          'img_blob_err' => '',
          'complete_img_name_err' => ''
        ];

        // Load View
        $this->view('profiles/addpimg', $data);
      }
		}
		
		public function addbgimg(){
			  // Check if POST
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					// Sanitize POST
					$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					// trim() Strip whitespace (or other characters) from the beginning and end of a string
					$data = [
						'complete_img_name' => $_FILES['complete_img_name']['name'],
						'id_user' => $_SESSION['user_id'],
						'name' => pathinfo($_FILES['complete_img_name']['name'], PATHINFO_FILENAME),
						'extension' => pathinfo($_FILES['complete_img_name']['name'], PATHINFO_EXTENSION),
						'type_usage' => 'Background',
						// kilobytes with two digits
						'size' => round(filesize($_FILES["complete_img_name"]["tmp_name"]) /1024, 5),
						'img_blob' => '',
						'name_err' => '',
						'extension_err' => '',
						'type_usage_err' => '',
						'size_err' => '',
						'img_blob_err' => '',
						'complete_img_name_err' => ''
					];
					
					// Check if he have a file
					if(empty($data['complete_img_name'])){
						$data['complete_img_name_err'] = "Aucun fichier selectionner.";
					}
	
					if(empty($data['name'])){
						$data['name_err'] = "Votre image doit porter un nom";
					}
	
					if(empty($data['extension'])){
						$data['extension_err'] = "Votre image doit porter une extension";
					}
	
					// Limit size to 1mb
					if($data['size']>1000){
						$data['size_err'] = "Votre image pese plus de 1Mb.";
					}
	
					// Allow certain file formats
					if($data['extension'] != "jpg" && $data['extension'] != "png" && $data['extension'] != "jpeg" && $data['extension'] != "gif" ) {
						$data['extension_err'] = "Le format de l'image n'est pas supporter.";
					}
					
	
					// Make sure errors are empty
					if(empty($data['desc_err']) && empty($data['name_err']) && empty($data['extension_err']) && empty($data['viewed_number_err']) && empty($data['type_usage_err']) && empty($data['size_err']) && empty($data['complete_img_name_err'])){
						// SUCCESS - Proceed to insert
						// Send image to database
						$data['img_blob'] = file_get_contents($_FILES['complete_img_name']['tmp_name']);
						if(empty($data['img_blob'])) {
							$data['img_blob_err'] = "Choisisser une image.";
						}
						$this->imageModel->addpimage($data);
						// Redirect to login
						flash('image_bg_uploaded', "L'image de fond du profile a bien ete mis a jour.");
						redirect('profiles/edit');			
					} else {
						 // Load View
						 $this->view('profiles/addbgimg', $data);
					}
				} else {
					// IF NOT A POST REQUEST
	
					// Init data
					$data = [
						'complete_img_name' => '',
						'id_user' => '',
						'name' => '',
						'extension' => '',
						'type_usage' => '',
						'size' => '',
						'img_blob' => '',
						'name_err' => '',
						'extension_err' => '',
						'type_usage_err' => '',
						'size_err' => '',
						'img_blob_err' => '',
						'complete_img_name_err' => ''
					];
	
					// Load View
					$this->view('profiles/addbgimg', $data);
				}
    }
	}
?>