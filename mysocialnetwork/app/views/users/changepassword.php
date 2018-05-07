<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- Par Varlet Nicolas et Duhamel Antoine -->
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <div class="text-center">
        <h3><i class="fa fa-lock fa-4x"></i></h3>
        <p>S'il vous plait entrer votre nouveau mot de passe:</p>
        <form action="<?php echo URLROOT; ?>/users/changepassword" id="changepassword"  method="post" role="form" autocomplete="off">
          <div class="form-group">
              <input type="hidden" name="email" id="email" tabindex="1" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" placeholder="Addresse E-mail" value="<?php echo $data['email']; ?>" autocomplete="off"/>
              <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="changepassword">Nouveau mot de passe</label>
            <input type="password" name="password" id="password" tabindex="1" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" placeholder="Mot de passe" value="<?php echo $data['password']; ?>" autocomplete="off"/>
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_changepassword">Confirmer le nouveau mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" tabindex="1" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" placeholder="Confirmer votre mot de passe" value="<?php echo $data['confirm_password']; ?>" autocomplete="off"/>
            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-lg-6 col-sm-6 col-xs-6">
                <input type="submit" name="password-submit" id="password-submit" tabindex="2" class="form-control btn btn-success" value="Reinitialiser le MDP"/>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>