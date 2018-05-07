<!-- Par Varlet Nicolas et Duhamel Antoine -->
<?php require APPROOT . '/views/inc/header.php'; ?>
<?php foreach($data['profile'] as $arrdataprofile) : ?>
  <?php foreach($arrdataprofile as $key => $value) : ?>
    <?php 
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
  <?php flash('change_info'); flash('image_profile_uploaded'); flash('image_background_uploaded'); flash('image_bg_uploaded'); flash('change_info_relationship'); flash('change_info_school'); flash('change_info_work'); ?>
  <div class="col-md contentarea">
    <?php  echo '<img src="data:image/png;base64,'.base64_encode($img_blobbg).'" width="851" height="315" class="product-holder">'; ?>
    <?php  echo '<img src="data:image/png;base64,'.base64_encode($img_blobprofile).'" width="168" height="168" class="sur-1" style="border:4px solid white">'; ?>
    <a class="btn btn-primary pull-right sur-2" href="<?php echo URLROOT; ?>/profiles/info"><i class="fas fa-edit" aria-hidden="true"></i> Modifier le profile</a>
    <form class="pull-right" action="<?php echo URLROOT; ?>/friendships/addFR/<?php echo $idu2; ?>" method="post">
      <button class="btn btn-primary pull-right sur-3" type="submit"><i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter</button>
    </form>
    <p class="sur-4"><?php echo $lname.' '.$fname?></p>
    <nav class="navbar navbar-light nav-item1 justify-content-center contentarea">
      <ul class="nav" >
        <li class="nav-item2">
          <a class="nav-link active" href="<?php echo URLROOT; ?>/profiles">Journal</a>
        </li>
        <li class="nav-item2">
          <a class="nav-link" href="<?php echo URLROOT; ?>/profiles/info">A propos</a>
        </li>
        <li class="nav-item2">
          <a class="nav-link" href="<?php echo URLROOT; ?>/profiles/friend">Amis</a>
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
          <div class="card card-body bg-light">
            <form action="<?php echo URLROOT; ?>/posts/add" method="post" enctype="multipart/form-data">
            <h2>Ajouter un Poste avec image</h2>
            <p>Creer un poste avec ce formulaire</p>
            <div class="form-group">
              <label>Titre:<sup>*</sup></label>
              <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>" placeholder="Ajouter un titre...">
              <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
            </div>    
            <div class="form-group">
              <label>Corp:<sup>*</sup></label>
              <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>" placeholder="Ajouter du texte..."><?php echo $data['body']; ?></textarea>
              <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
            </div>
            <div class="form-group">
              <label>Image:<sup>*</sup></label>
              <p>Attention vous ne pourrez plus modifier l'image une fois poster</p>
              <input type="file" name="img_p_blob" class="form-control form-control-lg <?php echo ((!empty($data['img_p_blob_err'])) || (!empty($data['extension_err'])) || (!empty($data['size_err']))) ? 'is-invalid' : ''; ?>" value="<?php echo $data['img_p_blob']; ?>">
              <span class="invalid-feedback"><?php echo $data['img_p_blob_err']; echo $data['extension_err']; echo $data['size_err'];?></span>
            </div>
            <div class="form-group">
              <label for="viewable">Visibilite</label>
              <select class="form-control" id="viewable" name="viewable">
              <option>Private</option>
              <option>Public</option>
              <option>Friends</option>
              <option>YouOnly</option>
              </select>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Publier avec image">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>