<!-- Par Varlet Nicolas et Duhamel Antoine -->
<?php require APPROOT . '/views/inc/header.php'; ?>
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
      if($key == "phonenb"){ $phonenb=$value; }
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

.contentareaedit {
  position: relative;
  width: 851px !important;
}
</style>




<div class="container">
    <div class="row">
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
            <p class="sur-4"><?php echo $lname.' '.$fname; ?></p>
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
    </div>
    <div class="row">
        <div class="col-md" style="top: 15px;">
            <div class="card contentareaedit" style="border-color: silver;">
                <div class="card">
                    <div class="card-header text-center">
                        <ul class="nav nav-tabs card-header-tabs">
                            <h5 class="card-header"><i class="fas fa-user"></i> À propos</h5>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="collapse" data-target="#indexve">Vue d'ensemble</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" data-target="#infogen">Information generale</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" data-target="#img">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" data-target="#sit">Situation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" data-target="#sco">Scolarite</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body collapse" id="indexve">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <p><i class="fas fa-graduation-cap"></i> <?php echo ' '.$school; ?></p>
                                    <p><i class="fas fa-briefcase"></i> <?php echo ' '.$work; ?></p>
                                    <p><i class="fas fa-globe"></i> De <?php if(!empty($city) && !empty($state) && !empty($country)) : ?> <a class="card-text"><?php echo $city.','.$state.','.$country; ?></a> <?php endif; ?></p>
                                </div>
                                <div class="col">
                                    <p><i class="fas fa-mobile-alt"></i> <?php echo ' '.$phonenb; ?></p>
                                    <p><i class="fas fa-birthday-cake"></i> <?php echo ' '.$birthday; ?></p>
                                    <p><i class="fas fa-venus-mars"></i> <?php echo ' '.$gender; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse" id="infogen">
                    <div class="container">
                            <div class="row">
                                <div class="col">
                                    <p><i class="fas fa-graduation-cap"></i> <?php echo ' '.$school; ?></p>
                                    <p><i class="fas fa-briefcase"></i> <?php echo ' '.$work; ?></p>
                                    <p><i class="fas fa-globe"></i> De <?php if(!empty($city) && !empty($state) && !empty($country)) : ?> <a class="card-text"><?php echo $city.','.$state.','.$country; ?></a> <?php endif; ?></p>
                                    <p><i class="fas fa-mobile-alt"></i> <?php echo ' '.$phonenb; ?></p>
                                    <p><i class="fas fa-birthday-cake"></i> <?php echo ' '.$birthday; ?></p>
                                </div>
                                <?php if($_SESSION['user_id'] == $id) : ?>
                                <form action="<?php echo URLROOT; ?>/profiles/info" method="post">
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="">Nom et Prenom:<sup>*</sup></span>
                                                </div>
                                                <input name="lname" class="form-control <?php echo (!empty($data['lname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['lname']; ?>">
                                                <span class="invalid-feedback"><?php echo $data['lname_err']; ?></span>
                                                <input type="text" name="fname" class="form-control <?php echo (!empty($data['fname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['fname']; ?>">
                                                <span class="invalid-feedback"><?php echo $data['fname_err']; ?></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <!-- http://www.daterangepicker.com/ -->
                                    <div class="form-group">
                                        <label>Date de naissance:<sup>*</sup></label>
                                        <div class="form-group">
                                            <input type="text" name="birthdate" class="form-control <?php echo (!empty($data['birthdate_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['birthdate']; ?>">
                                            <span class="invalid-feedback"><?php echo $data['birthdate_err']; ?></span>
                                            <script type="text/javascript">
                                                $(function() {
                                                    $('input[name="birthdate"]').daterangepicker({
                                                        minDate: '01/01/1930',
                                                        maxDate: '01/01/2018',
                                                        singleDatePicker: true,
                                                        locale: {
                                                            format: 'DD/MM/YYYY'
                                                        },
                                                        showDropdowns: true,
                                                        opens: "center"
                                                    }, 
                                                    function(start, end, label) {
                                                        var years = moment().diff(start, 'years');
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Addresse Email:<sup>*</sup></label>
                                        <input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                                    </div>    
                                    <div class="form-group">
                                        <label>Mot de passe:<sup>*</sup></label>
                                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmer le mot de passe:<sup>*</sup></label>
                                        <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Question secretre:<sup>*</sup></label>
                                        <input type="text" name="secretquestion" class="form-control form-control-lg <?php echo (!empty($data['secretquestion_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['secretquestion']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['secretquestion_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Reponse a la question secretre:<sup>*</sup></label>
                                        <input type="password" name="secretanswer" class="form-control form-control-lg <?php echo (!empty($data['secretanswer_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['secretanswer']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['secretanswer_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Comfirmer la reponse a la question secretre:<sup>*</sup></label>
                                        <input type="password" name="confirm_secretanswer" class="form-control form-control-lg <?php echo (!empty($data['confirm_secretanswer_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_secretanswer']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['confirm_secretanswer_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Numero de telephone:<sup>*</sup></label>
                                        <input type="number" name="tel" class="form-control form-control-lg <?php echo (!empty($data['tel_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['tel']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['tel_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Ville:<sup>*</sup></label>
                                        <input type="text" name="city" class="form-control form-control-lg <?php echo (!empty($data['city_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['city']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['city_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Code Postale:<sup>*</sup></label>
                                        <input type="number" name="zipcode" class="form-control form-control-lg <?php echo (!empty($data['zipcode_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['zipcode']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['zipcode_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Region:<sup>*</sup></label>
                                        <input type="text" name="state" class="form-control form-control-lg <?php echo (!empty($data['state_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['state']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['state_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Pays:<sup>*</sup></label>
                                        <input type="text" name="country" class="form-control form-control-lg <?php echo (!empty($data['country_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['country']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['country_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Intro:<sup>*</sup></label>
                                        <input type="text" name="intro" class="form-control form-control-lg <?php echo (!empty($data['intro_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['intro']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['intro_err']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Site Web:<sup>*</sup></label>
                                        <input type="text" name="website" class="form-control form-control-lg <?php echo (!empty($data['website_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['website']; ?>">
                                        <span class="invalid-feedback"><?php echo $data['website_err']; ?></span>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="submit" class="btn btn-success btn-block" name="submit" value="Changer les informations">
                                        </div>
                                    </div>
                                </form>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse" id="img">
                        <div class="row">
                            <div class="col-lg-6 mx-auto">
                            <?php if($_SESSION['user_id'] == $id) : ?>
                                <form method="get" action="<?php echo URLROOT; ?>/profiles/addpimg">
                                    <button type="submit">Ajouter une image de profile</button>
                                </form>
                                <form method="get" action="<?php echo URLROOT; ?>/profiles/addbgimg">
                                    <button type="submit">Ajouter une image de fond</button>
                                </form>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse" id="sit">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <p><i class="far fa-heart"></i> <?php echo ' '.$relationship; ?></p>
                                </div>
                                <div class="col">
                                    <?php if($_SESSION['user_id'] == $id) : ?>
                                    <form action="<?php echo URLROOT; ?>/profiles/info" method="post">
                                        <div class="form-group">
                                            <label>Situation personnel:<sup>*</sup></label>
                                            <input type="text" name="relationship" class="form-control form-control-lg <?php echo (!empty($data['relationship_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['relationship']; ?>">
                                            <span class="invalid-feedback"><?php echo $data['relationship_err']; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="col">
                                                <input type="submit" class="btn btn-success btn-block" name="submit" value="Changer">
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse" id="sco">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <p><i class="fas fa-graduation-cap"></i> <?php echo ' '.$school; ?></p>
                                    <p><i class="fas fa-briefcase"></i> <?php echo ' '.$work; ?></p>
                                </div>
                                <div class="col">
                                    <?php if($_SESSION['user_id'] == $id) : ?>
                                    <form action="<?php echo URLROOT; ?>/profiles/info" method="post">
                                        <div class="form-group">
                                            <label>Lieu d'etude:<sup>*</sup></label>
                                            <input type="text" name="school" class="form-control form-control-lg <?php echo (!empty($data['school_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['school']; ?>">
                                            <span class="invalid-feedback"><?php echo $data['school_err']; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="col">
                                                <input type="submit" class="btn btn-success btn-block" name="submit" value="Changer lieu d'etude">
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                <?php if($_SESSION['user_id'] == $id) : ?>
                                    <form action="<?php echo URLROOT; ?>/profiles/info" method="post">
                                        <div class="form-group">
                                            <label>Lieu de travail:<sup>*</sup></label>
                                            <input type="text" name="work" class="form-control form-control-lg <?php echo (!empty($data['work_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['work']; ?>">
                                            <span class="invalid-feedback"><?php echo $data['work_err']; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="col">
                                                <input type="submit" class="btn btn-success btn-block" name="submit" value="Changer lieu de travail">
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>