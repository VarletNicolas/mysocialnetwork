<?php require APPROOT . '/views/inc/header.php'; ?>
<?php foreach($data['profile'] as $arrdataprofile) : ?>
  <?php foreach($arrdataprofile as $key => $value) : ?>
    <?php 
      if($key == "fname"){ $fname=$value; }
      if($key == "lname"){ $lname=$value; }  
      if($key == "gender"){ $gender=$value; } 
      if($key == "birthday"){ $birthday=$value; } 
      if($key == "city"){ $city=$value; } 
      if($key == "created_at"){ $created_at=$value; }
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
</style>




<div class="row">
  <div class="col-md contentarea">
    <?php  echo '<img src="data:image/png;base64,'.base64_encode($img_blobbg).'" width="851" height="315" class="product-image">'; ?>
    <?php  echo '<img src="data:image/png;base64,'.base64_encode($img_blobprofile).'" width="168" height="168" class="sur-1" style="border:4px solid white">'; ?>
    <a class="btn btn-primary pull-right sur-2" href="<?php echo URLROOT; ?>/profiles/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier le profile</a>
    <a class="btn btn-primary pull-right sur-3" href="<?php echo URLROOT; ?>/users/addfriend"><i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter</a>
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
        <li class="nav-item2">
          <a class="nav-link" href="<?php echo URLROOT; ?>/profiles/gallery">Photos</a>
        </li>
      </ul>
    </nav>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>