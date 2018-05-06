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
			$this->postModel = $this->model('Post');
			$this->friendshipModel = $this->model('Friendship');
		}
		// load profile of current user
		public function index(){
			$profile = $this->profileModel->getProfile($_SESSION['user_id']);
			$defaultemail = $this->userModel->getEmailById($_SESSION['user_id']);

			if($this->imageModel->havePImage($_SESSION['user_id'])){
				$images = $this->imageModel->getProfileimg($_SESSION['user_id']);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($_SESSION['user_id'])){
				$imagesbg = $this->imageModel->getBackgroundimg($_SESSION['user_id']);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			
			$postuser = $this->postModel->getPostsUser($_SESSION['user_id']);
			foreach($profile as $key => $value) {
				if($key == "id"){ $id=$value; }
			}
			$isfriend = $this->friendshipModel->IsFriends($_SESSION['user_id'], $profile[0]->id);

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				$data = [
					'postuser' => $postuser,
					'friend' => $isfriend,
					'profile' => $profile,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,	
					'defaultemail' => $defaultemail,
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
				// IF NOT A POST REQUEST

				// Init data
				$data = [
					'postuser' => $postuser,
					'friend' => $isfriend,
					'profile' => $profile,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,	
					'defaultemail' => $defaultemail,
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

				// Load View
				$this->view('profiles/index', $data);
			}
			
		}

		// this function == index with id for search system
		public function p($id){
			$profile = $this->profileModel->getProfile($id);
			$defaultemail = $this->userModel->getEmailById($id);

			if($this->imageModel->havePImage($id)){
				$images = $this->imageModel->getProfileimg($id);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($id)){
				$imagesbg = $this->imageModel->getBackgroundimg($id);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			
			$postuser = $this->postModel->getPostsUser($id);

			foreach($profile as $key => $value) {
				if($key == "id"){ $id=$value; }
			}
			$isfriend = $this->friendshipModel->IsFriends($_SESSION['user_id'], $profile[0]->id);

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				$data = [
					'postuser' => $postuser,
					'friend' => $isfriend,
					'profile' => $profile,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,	
					'defaultemail' => $defaultemail,
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
				// IF NOT A POST REQUEST

				// Init data
				$data = [
					'postuser' => $postuser,
					'friend' => $isfriend,
					'profile' => $profile,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,	
					'defaultemail' => $defaultemail,
					'title' => '',
					'body' => '',
					'user_id' => '',
					'visibility' => '',
					'img_p_blob' => '',
					'size' => '',
					'extension' =>'',
					'title_err' => '',
					'body_err' => '',
					'img_p_blob_err' => '',
					'size_err' => '',
					'extension_err' => ''
				];

				// Load View
				$this->view('profiles/p', $data);
			}
			
		}

		public function info(){
			$profile = $this->profileModel->getProfile($_SESSION['user_id']);
			$defaultemail = $this->userModel->getEmailById($_SESSION['user_id']);

			if($this->imageModel->havePImage($_SESSION['user_id'])){
				$images = $this->imageModel->getProfileimg($_SESSION['user_id']);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($_SESSION['user_id'])){
				$imagesbg = $this->imageModel->getBackgroundimg($_SESSION['user_id']);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}

			// Check if POST
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				switch($_POST['submit']) {
					case "Changer les informations": 
						
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => trim($_POST['fname']),
							'lname' => trim($_POST['lname']),
							'email' => trim($_POST['email']),
							'password' => trim($_POST['password']),
							'confirm_password' => trim($_POST['confirm_password']),
							'secretquestion' => $_POST['secretquestion'],
							'secretanswer' => trim($_POST['secretanswer']),
							'confirm_secretanswer' => trim($_POST['confirm_secretanswer']),
							'birthdate' => trim($_POST['birthdate']),
							'tel' => $_POST['tel'],
							'city' => trim($_POST['city']),
							'state' => trim($_POST['state']),
							'country' => trim($_POST['country']),
							'zipcode' => $_POST['zipcode'],
							'intro' => trim($_POST['intro']),
							'website' => trim($_POST['website']),
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => '',
							'relationship_err' => '',
							'work' => '',
							'work_err' => '',
							'school' =>  '',
							'school_err' => ''
						];

						// Validate city
						if(empty($data['city'])){
							$data['city_err'] = 'Le champ Ville ne peut pas etre vide.';
						}

						// Validate state
						if(empty($data['state'])){
							$data['state_err'] = 'Le champ Region ne peut pas etre vide.';
						}

						// Validate city
						if(empty($data['country'])){
							$data['country_err'] = 'Le champ Pays ne peut pas etre vide.';
						}

						// Validate city
						if(empty($data['zipcode'])){
							$data['zipcode_err'] = 'Le champ Code Postale ne peut pas etre vide.';
						} elseif(strlen($data['zipcode']) < 4){
							$data['zipcode_err'] = 'Le Code Postale doit contenir plus de 4 carracteres.';
						}
				
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
							if($data['email'] == $data['defaultemail']){
								$data['sameE'] = 'ok';
							} else {
								if(($this->userModel->findUserByEmail($data['email'])) && (empty($data['sameE']))){
									$data['email_err'] = 'Email deja prise.';
								}
							}       					
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

						// Validate tel
						if(empty($data['tel'])){
							$data['tel_err'] = 'Le numero de telephone ne peut pas etre vide.';
						} elseif(strlen($data['tel']) < 6){
							$data['tel_err'] = 'Le numero de telephone doit contenir 10 numeros: 06.xx.xx.xx.xx ou 07.xx.xx.xx.xx';
						}
				
						// Make sure errors are empty
						if(empty($data['website_err']) && empty($data['intro_err']) && empty($data['tel_err']) && empty($data['zipcode_err']) && empty($data['country_err']) && empty($data['state_err']) && empty($data['city_err']) && empty($data['birthdate_err']) && empty($data['confirm_secretanswer_err']) && empty($data['secretquestion_err']) && empty($data['secretanswer_err']) && empty($data['fname_err']) && empty($data['lname_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
							// SUCCESS - Proceed to insert
				
							// Hash Password
							$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
							$data['secretanswer'] = password_hash($data['secretanswer'], PASSWORD_DEFAULT);
				
							//Execute
							if($this->profileModel->changeinfo($data)){
								// Redirect to login
								flash('change_info', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
							
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
					case "Changer":
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => '',
							'lname' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'secretquestion' => '',
							'secretanswer' => '',
							'confirm_secretanswer' => '',
							'birthdate' => '',
							'tel' => '',
							'city' => '',
							'state' => '',
							'country' => '',
							'zipcode' => '',
							'intro' => '',
							'website' => '',
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => trim($_POST['relationship']),
							'relationship_err' => '',
							'work' => '',
							'work_err' => '',
							'school' =>  '',
							'school_err' => ''
						];
				
						// Validate email
						if(empty($data['relationship'])){
							$data['relationship_err'] = 'Veiller entre votre status personnel.';
						} elseif(strlen($data['relationship']) < 6){
							$data['relationship_err'] = 'Votre status pesonnel doit contenir plus de 6 carracteres.';
						}
				
						// Make sure errors are empty
						if(empty($data['relationship_err'])){
							// SUCCESS - Proceed to insert
				
							//Execute
							if($this->profileModel->changeinforelationship($data)){
								// Redirect to login
								flash('change_info_relationship', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
					case "Changer lieu d'etude":
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => '',
							'lname' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'secretquestion' => '',
							'secretanswer' => '',
							'confirm_secretanswer' => '',
							'birthdate' => '',
							'tel' => '',
							'city' => '',
							'state' => '',
							'country' => '',
							'zipcode' => '',
							'intro' => '',
							'website' => '',
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => '',
							'relationship_err' => '',
							'work' =>  '',
							'work_err' => '',
							'school' =>  trim($_POST['school']),
							'school_err' => '',
						];
				
						// Validate email
						if(empty($data['school'])){
							$data['school_err'] = 'Veiller entre votre status personnel.';
						} elseif(strlen($data['school']) < 2){
							$data['school_err'] = 'Votre etablissement scolaire doit contenir plus de 2 carracteres.';
						}
				
						// Make sure errors are empty
						if(empty($data['school_err'])){
							// SUCCESS - Proceed to insert
				
							//Execute
							if($this->profileModel->changeinfoschool($data)){
								// Redirect to login
								flash('change_info_school', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
					case "Changer lieu de travail":
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => '',
							'lname' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'secretquestion' => '',
							'secretanswer' => '',
							'confirm_secretanswer' => '',
							'birthdate' => '',
							'tel' => '',
							'city' => '',
							'state' => '',
							'country' => '',
							'zipcode' => '',
							'intro' => '',
							'website' => '',
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => '',
							'relationship_err' => '',
							'work' => trim($_POST['work']),
							'work_err' => '',
							'school' =>  '',
							'school_err' => ''
						];
				
						// Validate email
						if(empty($data['work'])){
							$data['work_err'] = 'Veiller entre votre status personnel.';
						} elseif(strlen($data['work']) < 2){
							$data['work_err'] = 'Votre travail doit contenir plus de 2 carracteres.';
						}
				
						// Make sure errors are empty
						if(empty($data['work_err'])){
							// SUCCESS - Proceed to insert
				
							//Execute
							if($this->profileModel->changeinfowork($data)){
								// Redirect to login
								flash('change_info_work', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
				}
			} else {
				// IF NOT A POST REQUEST
		
				// Init data
				$data = [
					'profile' => $profile,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,
					'defaultemail' => $defaultemail,
					'fname' => '',
					'lname' => '',
					'email' => '',
					'password' => '',
					'confirm_password' => '',
					'secretquestion' => '',
					'secretanswer' => '',
					'confirm_secretanswer' => '',
					'tel' => '',
					'city' => '',
					'state' => '',
					'country' => '',
					'zipcode' => '',
					'intro' => '',
					'website' => '',
					'intro_err' => '',
					'website_err' => '',
					'zipcode_err' => '',
					'country_err' => '',
					'state_err' => '',
					'city_err' => '',
					'tel_err' => '',
					'fname_err' => '',
					'lname_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => '',
					'secretquestion_err' => '',
					'secretanswer_err' => '',
					'confirm_secretanswer_err',
					'birthdate' => '',
					'birthdate_err' => '',
					'sameE' => '',
					'relationship' => '',
					'relationship_err' => '',
					'work' => '',
					'work_err' => '',
					'school' =>  '',
					'school_err' => ''
				];
		
				// Load View
				$this->view('profiles/info', $data);
			}
		}

		public function i($id){
			$profile = $this->profileModel->getProfile($id);
			$defaultemail = $this->userModel->getEmailById($id);

			if($this->imageModel->havePImage($id)){
				$images = $this->imageModel->getProfileimg($id);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($id)){
				$imagesbg = $this->imageModel->getBackgroundimg($id);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			$isfriend = $this->friendshipModel->IsFriends($_SESSION['user_id'], $profile[0]->id);
			// Check if POST
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				switch($_POST['submit']) {
					case "Changer les informations": 
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'friend' => $isfriend,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => trim($_POST['fname']),
							'lname' => trim($_POST['lname']),
							'email' => trim($_POST['email']),
							'password' => trim($_POST['password']),
							'confirm_password' => trim($_POST['confirm_password']),
							'secretquestion' => $_POST['secretquestion'],
							'secretanswer' => trim($_POST['secretanswer']),
							'confirm_secretanswer' => trim($_POST['confirm_secretanswer']),
							'birthdate' => trim($_POST['birthdate']),
							'tel' => $_POST['tel'],
							'city' => trim($_POST['city']),
							'state' => trim($_POST['state']),
							'country' => trim($_POST['country']),
							'zipcode' => $_POST['zipcode'],
							'intro' => trim($_POST['intro']),
							'website' => trim($_POST['website']),
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => '',
							'relationship_err' => '',
							'work' => '',
							'work_err' => '',
							'school' =>  '',
							'school_err' => ''
						];

						// Validate city
						if(empty($data['city'])){
							$data['city_err'] = 'Le champ Ville ne peut pas etre vide.';
						}

						// Validate state
						if(empty($data['state'])){
							$data['state_err'] = 'Le champ Region ne peut pas etre vide.';
						}

						// Validate city
						if(empty($data['country'])){
							$data['country_err'] = 'Le champ Pays ne peut pas etre vide.';
						}

						// Validate city
						if(empty($data['zipcode'])){
							$data['zipcode_err'] = 'Le champ Code Postale ne peut pas etre vide.';
						} elseif(strlen($data['zipcode']) < 4){
							$data['zipcode_err'] = 'Le Code Postale doit contenir plus de 4 carracteres.';
						}
				
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
							if($data['email'] == $data['defaultemail']){
								$data['sameE'] = 'ok';
							} else {
								if(($this->userModel->findUserByEmail($data['email'])) && (empty($data['sameE']))){
									$data['email_err'] = 'Email deja prise.';
								}
							}       					
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

						// Validate tel
						if(empty($data['tel'])){
							$data['tel_err'] = 'Le numero de telephone ne peut pas etre vide.';
						} elseif(strlen($data['tel']) < 6){
							$data['tel_err'] = 'Le numero de telephone doit contenir 10 numeros: 06.xx.xx.xx.xx ou 07.xx.xx.xx.xx';
						}
				
						// Make sure errors are empty
						if(empty($data['website_err']) && empty($data['intro_err']) && empty($data['tel_err']) && empty($data['zipcode_err']) && empty($data['country_err']) && empty($data['state_err']) && empty($data['city_err']) && empty($data['birthdate_err']) && empty($data['confirm_secretanswer_err']) && empty($data['secretquestion_err']) && empty($data['secretanswer_err']) && empty($data['fname_err']) && empty($data['lname_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
							// SUCCESS - Proceed to insert
				
							// Hash Password
							$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
							$data['secretanswer'] = password_hash($data['secretanswer'], PASSWORD_DEFAULT);
				
							//Execute
							if($this->profileModel->changeinfo($data)){
								// Redirect to login
								flash('change_info', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
							
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
					case "Changer":
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'friend' => $isfriend,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => '',
							'lname' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'secretquestion' => '',
							'secretanswer' => '',
							'confirm_secretanswer' => '',
							'birthdate' => '',
							'tel' => '',
							'city' => '',
							'state' => '',
							'country' => '',
							'zipcode' => '',
							'intro' => '',
							'website' => '',
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => trim($_POST['relationship']),
							'relationship_err' => '',
							'work' => '',
							'work_err' => '',
							'school' =>  '',
							'school_err' => ''
						];
				
						// Validate email
						if(empty($data['relationship'])){
							$data['relationship_err'] = 'Veiller entre votre status personnel.';
						} elseif(strlen($data['relationship']) < 6){
							$data['relationship_err'] = 'Votre status pesonnel doit contenir plus de 6 carracteres.';
						}
				
						// Make sure errors are empty
						if(empty($data['relationship_err'])){
							// SUCCESS - Proceed to insert
				
							//Execute
							if($this->profileModel->changeinforelationship($data)){
								// Redirect to login
								flash('change_info_relationship', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
					case "Changer lieu d'etude":
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'friend' => $isfriend,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => '',
							'lname' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'secretquestion' => '',
							'secretanswer' => '',
							'confirm_secretanswer' => '',
							'birthdate' => '',
							'tel' => '',
							'city' => '',
							'state' => '',
							'country' => '',
							'zipcode' => '',
							'intro' => '',
							'website' => '',
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => '',
							'relationship_err' => '',
							'work' =>  '',
							'work_err' => '',
							'school' =>  trim($_POST['school']),
							'school_err' => '',
						];
				
						// Validate email
						if(empty($data['school'])){
							$data['school_err'] = 'Veiller entre votre status personnel.';
						} elseif(strlen($data['school']) < 2){
							$data['school_err'] = 'Votre etablissement scolaire doit contenir plus de 2 carracteres.';
						}
				
						// Make sure errors are empty
						if(empty($data['school_err'])){
							// SUCCESS - Proceed to insert
				
							//Execute
							if($this->profileModel->changeinfoschool($data)){
								// Redirect to login
								flash('change_info_school', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
					case "Changer lieu de travail":
						// gender default = "homme" 
						$data = [
							'profile' => $profile,
							'friend' => $isfriend,
							'imageProfile' => $images,
							'imageBackground' => $imagesbg,
							'defaultemail' => $defaultemail,
							'fname' => '',
							'lname' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'secretquestion' => '',
							'secretanswer' => '',
							'confirm_secretanswer' => '',
							'birthdate' => '',
							'tel' => '',
							'city' => '',
							'state' => '',
							'country' => '',
							'zipcode' => '',
							'intro' => '',
							'website' => '',
							'intro_err' => '',
							'website_err' => '',
							'zipcode_err' => '',
							'country_err' => '',
							'state_err' => '',
							'city_err' => '',
							'tel_err' => '',
							'fname_err' => '',
							'lname_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'secretquestion_err' => '',
							'secretanswer_err' => '',
							'confirm_secretanswer_err' => '',
							'birthdate_err' => '',
							'sameE' => '',
							'relationship' => '',
							'relationship_err' => '',
							'work' => trim($_POST['work']),
							'work_err' => '',
							'school' =>  '',
							'school_err' => ''
						];
				
						// Validate email
						if(empty($data['work'])){
							$data['work_err'] = 'Veiller entre votre status personnel.';
						} elseif(strlen($data['work']) < 2){
							$data['work_err'] = 'Votre travail doit contenir plus de 2 carracteres.';
						}
				
						// Make sure errors are empty
						if(empty($data['work_err'])){
							// SUCCESS - Proceed to insert
				
							//Execute
							if($this->profileModel->changeinfowork($data)){
								// Redirect to login
								flash('change_info_work', 'Vos informations ont ete mise a jour.');
								redirect('profiles/index');
							} else {
								die('Erreur sur le changement d\'informations');
							}
						} else {
							// Load View
							$this->view('profiles/info', $data);
						}
					break;
				}
			} else {
				// IF NOT A POST REQUEST
		
				// Init data
				$data = [
					'profile' => $profile,
					'friend' => $isfriend,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,
					'defaultemail' => $defaultemail,
					'fname' => '',
					'lname' => '',
					'email' => '',
					'password' => '',
					'confirm_password' => '',
					'secretquestion' => '',
					'secretanswer' => '',
					'confirm_secretanswer' => '',
					'tel' => '',
					'city' => '',
					'state' => '',
					'country' => '',
					'zipcode' => '',
					'intro' => '',
					'website' => '',
					'intro_err' => '',
					'website_err' => '',
					'zipcode_err' => '',
					'country_err' => '',
					'state_err' => '',
					'city_err' => '',
					'tel_err' => '',
					'fname_err' => '',
					'lname_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => '',
					'secretquestion_err' => '',
					'secretanswer_err' => '',
					'confirm_secretanswer_err',
					'birthdate' => '',
					'birthdate_err' => '',
					'sameE' => '',
					'relationship' => '',
					'relationship_err' => '',
					'work' => '',
					'work_err' => '',
					'school' =>  '',
					'school_err' => ''
				];
		
				// Load View
				$this->view('profiles/i', $data);
			}
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
					if($this->imageModel->checkPImage($data)){
						if($this->imageModel->rmpimage($data)){
							$this->imageModel->addpimage($data);
							flash('image_profile_uploaded', "L'image de profile a bien ete mis a jour.");
						}
						else {
							die("bug p image");
						}						
					} else {
						$this->imageModel->addpimage($data);
						flash('image_profile_uploaded', "L'image de profile a bien ete mis a jour.");
					}
					
					// Redirect to login
					
					redirect('profiles/index');
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
					if($this->imageModel->checkBGImage($data)){
						if($this->imageModel->rmBGImage($data)){
							$this->imageModel->addBGImage($data);
							flash('image_bg_uploaded', "L'image de fond du profile a bien ete mis a jour.");
						} else {
							die("bug bg image");
						}						
					} else {
						$this->imageModel->addBGImage($data);
						flash('image_bg_uploaded', "L'image de fond du profile a bien ete mis a jour.");
					}
					// Redirect to login
					
					redirect('profiles/index');			
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

		public function addpost(){
			$profile = $this->profileModel->getProfile($_SESSION['user_id']);
			$defaultemail = $this->userModel->getEmailById($_SESSION['user_id']);

			if($this->imageModel->havePImage($_SESSION['user_id'])){
				$images = $this->imageModel->getProfileimg($_SESSION['user_id']);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($_SESSION['user_id'])){
				$imagesbg = $this->imageModel->getBackgroundimg($_SESSION['user_id']);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'profile' => $profile,
					'imageProfile' => $images,
					'imageBackground' => $imagesbg,	
					'defaultemail' => $defaultemail,
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
				  $this->view('profiles/addpost', $data);
				}
			} else {
			$data = [
				'profile' => $profile,
				'imageProfile' => $images,
				'imageBackground' => $imagesbg,	
				'defaultemail' => $defaultemail,
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
	
			$this->view('profiles/addpost', $data);
			}
		}

		public function friend(){
			$profile = $this->profileModel->getProfile($_SESSION['user_id']);
			
			if($this->imageModel->havePImage($_SESSION['user_id'])){
				$images = $this->imageModel->getProfileimg($_SESSION['user_id']);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($_SESSION['user_id'])){
				$imagesbg = $this->imageModel->getBackgroundimg($_SESSION['user_id']);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			
			// IF NOT A POST REQUEST

			// Init data
			$data = [
				'profile' => $profile,
				'imageProfile' => $images,
				'imageBackground' => $imagesbg
			];

			// Load View
			$this->view('profiles/friend', $data);
		}

		public function ListeAmis(){
			$profile = $this->profileModel->getProfile($_SESSION['user_id']);
			
			if($this->imageModel->havePImage($_SESSION['user_id'])){
				$images = $this->imageModel->getProfileimg($_SESSION['user_id']);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($_SESSION['user_id'])){
				$imagesbg = $this->imageModel->getBackgroundimg($_SESSION['user_id']);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			
			$getfriends = $this->friendshipModel->getfriendlist($_SESSION['user_id']);
			$fpf =[]; $friendarray = [];
			foreach ($getfriends as $f) {
			  if(($f->id_user1 == $_SESSION['user_id']) && (!in_array($f->id_user2, $friendarray))){
				$tmp = $this->profileModel->getProfile($f->id_user2);
				$fpf = array_merge($fpf, $tmp);
				array_push($friendarray, $f->id_user2);
			  } elseif(($f->id_user2 == $_SESSION['user_id']) && (!in_array($f->id_user1, $friendarray))){
				$tmp = $this->profileModel->getProfile($f->id_user1);
				$fpf = array_merge($fpf, $tmp);
				array_push($friendarray, $f->id_user1);
			  }
			}
			
			// Init data
			$data = [
				'profile' => $profile,
				'imageProfile' => $images,
				'imageBackground' => $imagesbg,
				'tab' => $fpf
			];

			// Load View
			$this->view('profiles/ListeAmis', $data);
		}

		public function la($id){
			$profile = $this->profileModel->getProfile($id);
			
			if($this->imageModel->havePImage($id)){
				$images = $this->imageModel->getProfileimg($id);
			} else {
				$images = $this->imageModel->getDefaultProfileimg();
			}
			if($this->imageModel->haveBGImage($id)){
				$imagesbg = $this->imageModel->getBackgroundimg($id);
			} else {
				$imagesbg = $this->imageModel->getDefaultBackgroundimg();
			}
			
			$getfriends = $this->friendshipModel->getfriendlist($id);
			$fpf =[]; $friendarray = [];
			foreach ($getfriends as $f) {
			  if(($f->id_user1 == $id) && (!in_array($f->id_user2, $friendarray))){
				$tmp = $this->profileModel->getProfile($f->id_user2);
				$fpf = array_merge($fpf, $tmp);
				array_push($friendarray, $f->id_user2);
			  } elseif(($f->id_user2 == $id) && (!in_array($f->id_user1, $friendarray))){
				$tmp = $this->profileModel->getProfile($f->id_user1);
				$fpf = array_merge($fpf, $tmp);
				array_push($friendarray, $f->id_user1);
			  }
			}
			
			// Init data
			$data = [
				'profile' => $profile,
				'imageProfile' => $images,
				'imageBackground' => $imagesbg,
				'tab' => $fpf
			];

			// Load View
			$this->view('profiles/la', $data);
		}

		public function export($id){
			$getfriends = $this->friendshipModel->getfriendlist($id);
			$friendprofiles =[]; $friendarray = [];
			foreach ($getfriends as $f) {
				if(($f->id_user1 == $id) && (!in_array($f->id_user2, $friendarray))){
					$tmp = $this->profileModel->getProfile($f->id_user2);
					$friendprofiles = array_merge($friendprofiles, $tmp);
					array_push($friendarray, $f->id_user2);
				} elseif(($f->id_user2 == $id) && (!in_array($f->id_user1, $friendarray))){
					$tmp = $this->profileModel->getProfile($f->id_user1);
					$friendprofiles = array_merge($friendprofiles, $tmp);
					array_push($friendarray, $f->id_user1);
				}
			}

			$xml = xmlwriter_open_memory();
			xmlwriter_set_indent($xml, 1);
			$res = xmlwriter_set_indent_string($xml, ' ');
			xmlwriter_start_document($xml, '1.0', 'UTF-8');
			$xml->startDTD('html'); 
			// for XHTML 1.0 
			$xml->startDTD('html', '-//W3C//DTD XHTML 1.0 Strict//EN','https://github.com/VarletNicolas/mysocialnetwork/edit/master/mysocialnetwork/app/views/profiles/xml/mysocialnetwork.dtd'); // standards compliant 
			$xml->endDTD();
				
			$i=0;
			foreach ($friendprofiles as $p) {
				$xml->addChild('amies');
				$xml->amies[$i]->addChild('Nom', $p->fname);
				$xml->amies[$i]->addChild('Prenom', $p->lname);
				$xml->amies[$i]->addChild('genre', $p->gender);
				$xml->amies[$i]->addChild('intro', $p->intro);
				$xml->amies[$i]->addChild('email', $p->email);
				$xml->amies[$i]->addChild('date_anniversaire', $p->birthday);
				$xml->amies[$i]->addChild('compte_creer_le', $p->created_at);
				$xml->amies[$i]->addChild('ville', $p->city);
				$xml->amies[$i]->addChild('région', $p->state);
				$xml->amies[$i]->addChild('pays', $p->country);
				$xml->amies[$i]->addChild('code_postale', $p->zipcode);
				$xml->amies[$i]->addChild('site_web', $p->website);
				$xml->amies[$i]->addChild('école', $p->school);
				$xml->amies[$i]->addChild('relation', $p->relationship);
				$xml->amies[$i]->addChild('téléphone', $p->phonenb);
				$xml->amies[$i]->addChild('travail', $p->work);
				$i++;
			}
			$xml->asXML('friendsprofile.xml');
			$data = [
				'xml' => $xml
			];

			
			$this->view('profiles/export', $data);
		}
	}
?>