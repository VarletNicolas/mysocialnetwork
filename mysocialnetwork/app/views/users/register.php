<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <h2>Creer un compte</h2>
      <p>Sil vous plait remplisser ce formulaire pour vous inscrire</p>
      <form action="<?php echo URLROOT; ?>/users/register" method="post">
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
        <div class="form-group">
          <label>Sexe:<sup>*</sup></label>
          <div class="form-group">
            <label class="radio inline" for="gender-0">
            <input name="gender" id="gender-0" value="Homme" checked="checked" type="radio"> Homme </label>
            <label class="radio inline" for="gender-1">
            <input name="gender" id="gender-1" value="Femme" type="radio"> Femme </label>
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
        <div class="form-row">
          <div class="col">
            <input type="submit" class="btn btn-success btn-block" value="Inscription">
          </div>
          <div class="col">
            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Vous avez un compte? Connexion</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  
<?php require APPROOT . '/views/inc/footer.php'; ?>