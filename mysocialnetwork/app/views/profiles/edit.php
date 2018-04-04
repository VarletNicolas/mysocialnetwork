<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <?php 
            flash('image_profile_uploaded'); 
            flash('image_background_uploaded');
            flash('image_bg_uploaded');
        ?>
        <form method="get" action="<?php echo URLROOT; ?>/profiles/addpimg">
            <button type="submit">Ajouter une image de profile</button>
        </form>
        <form method="get" action="<?php echo URLROOT; ?>/profiles/addbgimg">
            <button type="submit">Ajouter une image de fond</button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>