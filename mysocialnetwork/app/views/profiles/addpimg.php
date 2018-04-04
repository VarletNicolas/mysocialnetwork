<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <form action="<?php echo URLROOT; ?>/profiles/addpimg" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <center><label for="complete_img_name"><h3>Ajouter votre image de profile</h3></label></center>
                <input type="file" name="complete_img_name" class="form-control form-control-lg <?php echo (!empty($data['complete_img_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['complete_img_name']; ?>">
                <span class="invalid-feedback"><?php echo $data['complete_img_name_err']; ?></span>
            </div>
            <div class="form-row">
                <div class="col">
                    <input type="submit" class="btn btn-success btn-block" value="Changer l'image de profile">
                </div>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>