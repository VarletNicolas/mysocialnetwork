<?php
    class Image {
		private $db;
		
		public function __construct(){
            $this->db = new Database; 
        }
        
        public function addprofilealbum($data){
            // Prepare Query
            $this->db->query('INSERT INTO albums (id_user, name) VALUES (:id_user, :name)');

            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            $this->db->bind(':name', $data['name']);
            
            //Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function addGenImage($data){
            // Prepare Query
            $this->db->query('INSERT INTO images (id_user, size, complete_img_name, extension, name, type_usage, img_blob) 
            VALUES (:id_user, :size, :complete_img_name, :extension, :name, :type_usage, :img_blob)');

            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            $this->db->bind(':size', $data['size']);
            $this->db->bind(':complete_img_name', $data['complete_img_name']);
            $this->db->bind(':extension', $data['extension']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':type_usage', $data['type_usage']);
            $this->db->bind(':img_blob', $data['img_blob']);
            
            //Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function addpimage($data){
            // Prepare Query
            $this->db->query('INSERT INTO images (id_user, size, complete_img_name, extension, name, type_usage, img_blob) 
            VALUES (:id_user, :size, :complete_img_name, :extension, :name, :type_usage, :img_blob)');

            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            $this->db->bind(':size', $data['size']);
            $this->db->bind(':complete_img_name', $data['complete_img_name']);
            $this->db->bind(':extension', $data['extension']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':type_usage', $data['type_usage']);
            $this->db->bind(':img_blob', $data['img_blob']);
            
            //Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function addBGImage($data){
            // Prepare Query
            $this->db->query('INSERT INTO images (id_user, size, complete_img_name, extension, name, type_usage, img_blob) 
            VALUES (:id_user, :size, :complete_img_name, :extension, :name, :type_usage, :img_blob)');

            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            $this->db->bind(':size', $data['size']);
            $this->db->bind(':complete_img_name', $data['complete_img_name']);
            $this->db->bind(':extension', $data['extension']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':type_usage', $data['type_usage']);
            $this->db->bind(':img_blob', $data['img_blob']);
            
            //Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function getProfileimg($id){
			$this->db->query("SELECT img_blob FROM images WHERE id_user = :id_user AND type_usage = 'Profile' ");
			$this->db->bind(':id_user', $id);

			$results = $this->db->resultset();
            return $results;
        }
        
        public function getBackgroundimg($id){
			$this->db->query("SELECT img_blob FROM images WHERE id_user = :id_user AND type_usage = 'Background' ");
			$this->db->bind(':id_user', $id);

			$results = $this->db->resultset();
            return $results;
		}

        public function getImages($id){
			$this->db->query("SELECT * FROM images WHERE id_user = :id_user");
			$this->db->bind(':id_user', $id);

			$results = $this->db->resultset();

            return $results;
        }
        
        public function checkPImage($data){
            // Prepare Query
            $this->db->query('SELECT * FROM images WHERE id_user = :id_user AND type_usage = "Profile" ');


            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            
            $row = $this->db->single();

            //Check Rows
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function checkBGImage($data){
            // Prepare Query
            $this->db->query('SELECT * FROM images WHERE id_user = :id_user AND type_usage = "Background" ');


            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            
            $row = $this->db->single();

            //Check Rows
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function rmpimage($data){
            // Prepare Query
            $this->db->query('DELETE FROM images WHERE id_user = :id_user AND type_usage = "Profile"');

            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            
            //Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function rmBGImage($data){
            // Prepare Query
            $this->db->query('DELETE FROM images WHERE id_user = :id_user AND type_usage = "Background"');

            // Bind Values
            $this->db->bind(':id_user', $data['id_user']);
            
            //Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function havePImage($id){
            // Prepare Query
            $this->db->query('SELECT * FROM Images WHERE id_user = :id_user AND type_usage = "Profile"');


            // Bind Values
            $this->db->bind(':id_user', $id);
            
            $row = $this->db->single();

            //Check Rows
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function haveBGImage($id){
            // Prepare Query
            $this->db->query('SELECT * FROM Images WHERE id_user = :id_user AND type_usage = "Background"');


            // Bind Values
            $this->db->bind(':id_user', $id);
            
            $row = $this->db->single();

            //Check Rows
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }            
        }

        public function getDefaultProfileimg(){
			$this->db->query("SELECT img_blob FROM images WHERE id_user = 0 AND type_usage = 'Profile' ");

			$results = $this->db->resultset();
            return $results;
        }

        public function getDefaultBackgroundimg(){
			$this->db->query("SELECT img_blob FROM images WHERE id_user = 0 AND type_usage = 'Background' ");

			$results = $this->db->resultset();
            return $results;
        }
        /*
        public function add_album($data){

        }

        public function add_image_to_album($data){

        }
        
        public function add_view_albun(){

        }

        public function add_view_image(){
            
        }

        public function update_image($data){

        }

        public function update_album_info($data){

        }

        public function delete_album($data){

        }

        public function count_viewer_album($data){

        }

        public function count_number_of_image($data){

        }

        public function count_viewer_image($data){

        }

        public function get_viewer_album($data){

        }

        public function get_viewer_image($data){

        }

        public function get_image_from_album($data){

        }
        */
    }
?>