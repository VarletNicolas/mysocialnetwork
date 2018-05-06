<?php
  class Chats extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('chats/index');
      }
      $this->chatModel = $this->model('Chat');
      $this->userModel = $this->model('User');
      $this->friendshipModel = $this->model('Friendship');
  }

  // Load Homepage
  public function index(){
      $messages = $this->chatModel->getMessages($_SESSION['user_id']);
      
      // si tu as un form et que tu exec
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
        $data = [
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
}