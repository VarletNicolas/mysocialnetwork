<?php require APPROOT . '/views/inc/header.php';?>
<?php foreach($data['profile'] as $arrdataprofile) : ?>
  <?php foreach($arrdataprofile as $key => $value) : ?>
    <?php 
      if($key == "id"){ $id=$value; }
      if($key == "fname"){ $fname=$value; }
      if($key == "lname"){ $lname=$value; }  
      if($key == "gender"){ $gender=$value; } 
      if($key == "birthday"){ $birthday=$value; }
      if($key == "created_at"){ $created_at=$value; }
      if($key == "city"){ $city=$value; }  
      if($key == "state"){ $state=$value; }  
      if($key == "country"){ $country=$value; }  
      if($key == "zipcode"){ $zipcode=$value; }  
      if($key == "intro"){ $intro=$value; }
      if($key == "website"){ $website=$value; } 
      if($key == "school"){ $school=$value; } 
      if($key == "work"){ $work=$value; } 
      if($key == "relationship"){ $relationship=$value; } 
      if($key == "img_p_blob"){ $img_p_blob=$value; }  
      if($key == "img_bg_blob"){ $img_bg_blob=$value; } 
    ?>
  <?php endforeach; ?>
<?php endforeach; ?>
<?php foreach($data['imageProfile'] as $arr) : ?>
  <?php foreach($arr as $keys => $val) : ?>
  <?php if($keys == "img_blob"){ $img_blobprofile = $val; } ?>
  <?php endforeach; ?>
<?php endforeach; ?>
<?php foreach($data['imageBackground'] as $ar) : ?>
  <?php foreach($ar as $key1 => $val1) : ?>
  <?php if($key1 == "img_blob"){ $img_blobbg = $val1; } ?>
  <?php endforeach; ?>
<?php endforeach; ?>
<?php $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  $idu2 = current(array_reverse(explode('/', $url))); // http://geoffray.be/blog/php/only-variables-should-be-passed-by-reference ?>


<style>
.product-holder {
  position: relative;
  display: block;
}

.sur-1 {
  left: 2.5%;
  top: 47.33%;
  position: absolute;
}
.sur-2 {
  left: 60%;
  top: 50%;
  position: absolute;
}
.sur-3 {
  left: 60%;
  top: 62%;
  position: absolute;
}
.sur-4 {
  color: white;
  font-size: 22px;
  left: 4%;
  top: 35%;
  position: absolute;
  background: rgba(70, 68, 92, 0.5);
}
.nav-item1 {
  border-bottom: 1px solid silver;
  border-right: 1px solid silver;
  border-left: 1px solid silver;
  padding-right: 15px; 
}
.nav-item2 {
  padding-right: 15px; 
}
.contentarea {
  position: relative;
  width: 851px !important;
}
.borderadddd {
  position: relative;
  margin-left: 15px !important;
}
</style>




<div class="row">
  <?php flash('change_info'); flash('image_profile_uploaded'); flash('image_background_uploaded'); flash('image_bg_uploaded'); flash('change_info_relationship'); flash('change_info_school'); flash('change_info_work'); flash('Friend_Request_Send'); ?>
  <div class="col-md contentarea">
    <?php  echo '<img src="data:image/png;base64,'.base64_encode($img_blobbg).'" width="851" height="315" class="product-holder">'; ?>
    <?php  echo '<img src="data:image/png;base64,'.base64_encode($img_blobprofile).'" width="168" height="168" class="sur-1" style="border:4px solid white">'; ?>
    <a class="btn btn-primary pull-right sur-2" href="<?php echo URLROOT; ?>/profiles/info"><i class="fas fa-edit" aria-hidden="true"></i> Modifier le profile</a>
    <?php if($_SESSION['user_id'] != $id) : ?>
      <?php if($data['friend'] === false ) : ?>
      <? else: ?>
        <form class="pull-right" action="<?php echo URLROOT; ?>/friendships/addFR/<?php echo $idu2; ?>" method="post">
          <button class="btn btn-primary pull-right sur-3" type="submit"><i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter</button>
        </form>
      <?php endif;?>
    <?php endif;?>
    <?php if($_SESSION['user_id'] != $id) : ?>
      <?php if($data['friend'] === true ) : ?>
      <? else: ?>
        <form class="pull-right" action="<?php echo URLROOT; ?>/friendships/rmFR/<?php echo $idu2; ?>" method="post">
          <button class="btn btn-primary pull-right sur-3" type="submit"><i class="fas fa-user-times"></i> Supprimer</button>
        </form>
      <?php endif;?>
    <?php endif;?>
    
    
    <p class="sur-4"><?php echo $lname.' '.$fname?></p>
    <nav class="navbar navbar-light nav-item1 justify-content-center contentarea">
      <ul class="nav" >
        <li class="nav-item2">
          <a class="nav-link active" href="<?php echo URLROOT; ?>/profiles/p/<?php echo $idu2; ?>">Journal</a>
        </li>
        <li class="nav-item2">
          <a class="nav-link" href="<?php echo URLROOT; ?>/profiles/i/<?php echo $idu2; ?>">A propos</a>
        </li>
        <li class="nav-item2">
          <a class="nav-link" href="<?php echo URLROOT; ?>/profiles/f/<?php echo $idu2; ?>">Amis</a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="col-md" style="top: 15px;">
    <div class="row">
      <div class="col-3">
        <div class="card" style="width: 18rem; border-color: silver;">
          <div class="card-body">
            <center> <h6 class="card-title"><i class="fas fa-info"></i> - Infos:</h5> </center>
            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-child"></i> Intro</h6>
            <p class="card-text"><?php echo $intro; ?></p>
            <p><i class="fab fa-google"></i> <a href="<?php echo ' '.$website; ?>"><?php echo ' '.$website; ?></a></p>
            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-globe"></i> De <?php if(!empty($city) && !empty($state) && !empty($country)) : ?> <a class="card-text"><?php echo $city.','.$state.','.$country; ?></a> <?php endif; ?></h6>
          </div>
        </div>
      </div>
      <div class="col-5 borderadddd">
        <div class="card" style="width: 34.5rem; border-color: silver;">
          <ul class="nav justify-content-center">
            <li class="nav-item">
              <a class="nav-link active" href="<?php echo URLROOT; ?>/profiles">Voir vos postes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="<?php echo URLROOT; ?>/profiles/addpost">Ajouter un poste</a>
            </li>
          </ul>
          <div class="container">
            <?php foreach($data['postuser'] as $postuser) : ?>
            
              <div class="nav">
                <?php if($postuser->user_id == $_SESSION['user_id']) : ?>
                  <a class="btn btn-dark mb-3 nav-item" href="<?php echo URLROOT; ?>/posts/edit/<?php echo $postuser->id; ?>">Editer</a>
                  <form class="pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $postuser->id; ?>" method="post">
                    <input type="submit" class="btn btn-danger mb-3 nav-item" value="Supprimer">
                  </form>
                <?php endif; ?>
              </div>
              <br>
              <h1><?php echo $postuser->title; //var_dump($data); ?></h1>
              <div class="bg-secondary text-white p-2 mb-3">
                Ecrit par <?php echo $data['profile'][0]->fname; ?> <?php echo $data['profile'][0]->lname; ?> sur <?php echo $postuser->created_at; ?>
                <a class="btn btn-primary pull-right" href="<?php echo URLROOT; ?>/posts/addlike/<?php echo $postuser->id; ?>"><i class="far fa-thumbs-up" aria-hidden="true"></i></a>
              </div>
              <?php if(!empty($postuser->img_p_blob)) : ?>
                <p class="card-text"><?php  echo '<img src="data:image/png;base64,'.base64_encode($postuser->img_p_blob).'">'; ?></p>
              <?php endif;?>
              <p><?php echo $postuser->body; ?></p></br>

            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>