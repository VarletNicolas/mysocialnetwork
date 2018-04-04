<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php if($data['verification'] == "toto") : ?>
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center"><h2><b> Entrer le code que vous avez recu par e-mail :</b></h2></div></br>
                            <form action="<?php echo URLROOT; ?>/users/resetpassword" id="register-form"  method="post" role="form" autocomplete="off">
                                <div class="form-group">
                                    <input type="text" name="code" id="code" tabindex="1" class="form-control" placeholder="Entrer le code ici" value="" autocomplete="off" required/>
                                </div>
                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-lg-6 col-sm-6 col-xs-6">
                                            <input type="submit" name="code-cancel" id="code-cancel" tabindex="2" class="form-control btn btn-danger" value="Annuler" />
    
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-xs-6">
                                            <input type="submit" name="code-submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="Continuer" />
                                            
                                        </div>

                                    </div>
                                </div>
                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php else : ?>
            <div class="text-center">
                <h3><i class="fa fa-lock fa-4x"></i></h3>
                <h2 class="text-center">Mot de passe oublier?</h2></br>
                <p>S'il vous plait entrer l'email associer au compte utilisateur.</p>
                <form action="<?php echo URLROOT; ?>/users/resetpassword" id="register-form"  method="post" role="form" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Addresse E-mail</label>
                        <input type="email" name="emailreset" id="emailreset" tabindex="1" class="form-control <?php echo (!empty($data['emailreset_err'])) ? 'is-invalid' : ''; ?>" placeholder="Addresse E-mail" value="<?php echo $data['emailreset']; ?>" autocomplete="off"/>
                        <span class="invalid-feedback"><?php echo $data['emailreset_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-6">
                                <input type="submit" name="cancel-submit" id="cencel-submit" tabindex="2" class="form-control btn btn-danger" value="Annuler"/>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6">
                                <input type="submit" name="recover-submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="Reinitialiser le MDP"/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="hide" name="token" id="token" value="<?php echo $this->userModel->createToken() ;?>">
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
