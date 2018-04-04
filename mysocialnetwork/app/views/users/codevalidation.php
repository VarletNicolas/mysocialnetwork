<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <div class="text-center">
        <h3><i class="fa fa-lock fa-4x"></i></h3>
        <p>S'il vous plait entrer votre reponse secrete:</p>
        <form action="<?php echo URLROOT; ?>/users/codevalidation" id="checksecretanswer"  method="post" role="form" autocomplete="off">
          <div class="form-group">
            <label><?php echo $data['secretquestion']; ?></label>
          </div>
          <div class="form-group">
              <input type="hidden" name="email" id="email" tabindex="1" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" placeholder="Addresse E-mail" value="<?php echo $data['email']; ?>" autocomplete="off"/>
              <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="secretanswer">Question Secrete</label>
            <input type="password" name="secretanswer" id="secretanswer" tabindex="1" class="form-control <?php echo (!empty($data['secretanswer_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['secretanswer']; ?>" autocomplete="off"/>
            <span class="invalid-feedback"><?php echo $data['secretanswer_err']; ?></span>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-lg-6 col-sm-6 col-xs-6">
                <input type="submit" name="recover-submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="Reinitialiser le MDP"/>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>