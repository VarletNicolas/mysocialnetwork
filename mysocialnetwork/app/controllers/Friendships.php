<?php 
	/*
		Par Varlet Nicolas et Duhamel Antoine
	*/

	class Friendships extends Controller {
		public function __construct(){
			if(!isset($_SESSION['user_id'])){
				redirect('users/login');
			}
			// Load Models
			$this->friendshipModel = $this->model('Friendship');
		}

		public function addFR($id){
			// https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
			// https://stackoverflow.com/questions/4471975/get-the-integer-inside-the-url-in-php
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				
				$data = [
					'id_user1' => $_SESSION['user_id'],
					'id_user2' => $id,
					'id_user2_err' => ''
				];

				if(empty($data['id_user2'])){
					$data['id_user2_err'] = "Probleme lors de l'ajout d'amis.";
				} else {
					if($this->friendshipModel->IsFriends($data['id_user1'], $data['id_user2'])){
						$data['id_user2_err'] = "Vous ete deja amis.";
					} else {
						if($this->friendshipModel->IsFRSent($data)){
							$data['id_user2_err'] = "Demande Deja envoyer.";
						}
					}
				}
				if($data['id_user2'] == $data['id_user1']){
					$data['id_user2_err'] = "Vous ne pouvez pas vous ajouter vous meme en amis.";
				}

				// Make sure there are no errors
				if(empty($data['id_user2_err'])){
					// Validation passed	
					//Execute
					if($this->friendshipModel->addFriendRequest($data)){
						// Redirect to login
						flash('Friend_Request_Send', "Demande D'amis envoyer.");
						redirect('profiles');
					} else {
						die('bug');
					}
				} else {
					redirect('profiles/friend');
				}
			} else {
				// IF NOT A POST REQUEST

				// Init data
				$data = [
					'id_user1' => $_SESSION['user_id'],
					'id_user2' => $id,
					'id_user2_err' => ''
				];

				redirect('profiles/friend');
			}
		}

		public function rmFR($id){
			// https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
			// https://stackoverflow.com/questions/4471975/get-the-integer-inside-the-url-in-php
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Sanitize POST
				$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				// trim() Strip whitespace (or other characters) from the beginning and end of a string
				
				$data = [
					'id_user1' => $_SESSION['user_id'],
					'id_user2' => $id,
					'id_user2_err' => ''
				];

				if(empty($data['id_user2'])){
					$data['id_user2_err'] = "Probleme lors de l'ajout d'amis.";
				} else {
					if(!$this->friendshipModel->IsFriends($data['id_user1'], $data['id_user2'])){
						$data['id_user2_err'] = "Vous n'ete pas amis.";
					} 
				}
				if($data['id_user2'] == $data['id_user1']){
					$data['id_user2_err'] = "Vous ne pouvez pas vous supprime vous meme de votre liste amis.";
				}

				// Make sure there are no errors
				if(empty($data['id_user2_err'])){
					// Validation passed	
					//Execute
					if($this->friendshipModel->rmfriedship($data['id_user1'], $id)){
						// Redirect to login
						flash('Friend_Request_Send', "Suppression effective.");
						redirect('profiles');
					} else {
						die('bug');
					}
				} else {
					redirect('profiles/friend');
				}
			} else {
				// IF NOT A POST REQUEST

				// Init data
				$data = [
					'id_user1' => $_SESSION['user_id'],
					'id_user2' => $id,
					'id_user2_err' => ''
				];

				redirect('profiles/friend');
			}
		}
	}
?>