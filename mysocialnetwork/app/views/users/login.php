<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- Par Varlet Nicolas et Duhamel Antoine -->
<div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <?php flash('register_success'); flash('update_password_success');?>
        <h2>Connexion</h2>
        <p>Sil vous plait entrer vos identifiant.</p>
        <form action="<?php echo URLROOT; ?>/users/login" method="post">
          <div class="form-group">
            <label>Email:<sup>*</sup></label>
            <input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php if(isset($_COOKIE["user_email"])) { echo $_COOKIE["user_email"]; } ?><?php echo $data['email']; ?>">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>    
          <div class="form-group">
            <label>Mot de passe:<sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php if(isset($_COOKIE["user_password"])) { echo $_COOKIE["user_password"]; } ?><?php echo $data['password']; ?>">
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          </div>
          <div class="form-row">
            <input type="submit" class="btn btn-success btn-block" value="Login">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">Pas de compte? Inscription</a>
              <a href="<?php echo URLROOT; ?>/users/recover" class="btn btn-light btn-block">Mot de Passe oublier?</a>
            </div>
          </div>
          <br>
          <div class="form-group">
            <div class="form-check">
              <center><label class="form-check-label"> <input class="form-check-input" type="checkbox" name="save" id="save" value="<?php echo $data['save']; ?>" <?php if(isset($_COOKIE["user_email"])) { ?> checked <?php } ?>>Se souvenir de moi</label></center>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
