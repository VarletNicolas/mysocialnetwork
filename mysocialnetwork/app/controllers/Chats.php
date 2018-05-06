<?php
  class Chats extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('chats/index');
      }
      $this->chatModel = $this->model('Chat');
      $this->userModel = $this->model('User');
      $this->friendshipModel = $this->model('Friendship');
      $this->profileModel = $this->model('Profile');
  }

  // Load Homepage
  public function index(){
    $getfriends = $this->friendshipModel->getfriendlist($_SESSION['user_id']);
    $friendprofiles =[]; $friendarray = [];
    foreach ($getfriends as $f) {
      if(($f->id_user1 == $_SESSION['user_id']) && (!in_array($f->id_user2, $friendarray))){
        $tmp = $this->profileModel->getProfile($f->id_user2);
        $friendprofiles = array_merge($friendprofiles, $tmp);
        array_push($friendarray, $f->id_user2);
      } elseif(($f->id_user2 == $_SESSION['user_id']) && (!in_array($f->id_user1, $friendarray))){
        $tmp = $this->profileModel->getProfile($f->id_user1);
        $friendprofiles = array_merge($friendprofiles, $tmp);
        array_push($friendarray, $f->id_user1);
      }
    }
    $messages = $this->chatModel->getMessages($_SESSION['user_id']);
    
    // si tu as un form et que tu exec
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          
      $data = [
        'friendlist' => $friendprofiles,
        'messages' => $messages,
        'dest' => trim($_POST['dest']),
        'message' => trim($_POST['message']),
        'emmeteur' => $_SESSION['user_id'],
        'dest_err' => '',
        'message_err' => ''
      ];

      // Validate dest
      if(empty($data['dest'])){
        $data['dest_err'] = 'Veuiller entrer le destinataire';
      }
      // Validate message
      if(empty($data['message'])){
        $data['message_err'] = 'Veuiller entrer le message';
      }

      // Make sure there are no errors
      if(empty($data['message_err']) && empty($data['dest_err'])){
        // Validation passed
                  
        //Execute
        if($this->chatModel->addMessage($data)){
          // Redirect to login
          flash('message_send', 'Message Envoyer');
          redirect('chats/index');
        } else {
          die('bug');
        }
      } else {
        // Load view with errors
        $this->view('chats/index', $data);
      }
    } else {
      $data = [
        'friendlist' => $friendprofiles,
        'messages' => $messages,
        'dest' => '',
        'message' => '',
        'emmeteur' => '',
        'dest_err' => '',
        'message_err' => ''
      ];

      $this->view('chats/index', $data);
    }
  }

  // Load Homepage
  public function viewconv(){
    $messages = [];
    $data = [
      'dest' => $_POST['dest'],
      'messages' => $messages
    ];
    $data['messages'] = $this->chatModel->getMessages($_SESSION['user_id'], $data['dest']);

    $this->view('chats/viewconv', $data);
  }
}