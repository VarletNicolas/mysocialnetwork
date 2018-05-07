<!-- Par Varlet Nicolas et Duhamel Antoine -->
<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="nav">
    <a href="<?php echo URLROOT; ?>" class="btn btn-light mb-3 nav-item"><i class="fa fa-backward" aria-hidden="true"></i> Retour</a>
    <?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
      <a class="btn btn-dark mb-3 nav-item" href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>">Editer</a>
      <form class="pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
        <input type="submit" class="btn btn-danger mb-3 nav-item" value="Supprimer">
      </form>
    <?php endif; ?>
  </div>
  <br>
  <h1><?php echo $data['post']->title; //var_dump($data); ?></h1>
  <div class="bg-secondary text-white p-2 mb-3">
    Ecrit par <?php echo $data['user']->fname; ?> <?php echo $data['user']->lname; ?> sur <?php echo $data['post']->created_at; ?>
    <a class="btn btn-primary pull-right" href="<?php echo URLROOT; ?>/posts/addlike/<?php echo $data['post']->id; ?>"><i class="far fa-thumbs-up" aria-hidden="true"></i></a>
    <?php echo $data['nbofview']; ?>
  </div>
  
  <?php if(!empty($data['post']->img_p_blob)) : ?>
    <p class="card-text"><?php  echo '<img src="data:image/png;base64,'.base64_encode($data['post']->img_p_blob).'">'; ?></p>
  <?php endif;?>
  <p><?php echo $data['post']->body; ?></p></br>
  
  <?php foreach($data['comments'] as $comments) : ?>
    <div class="card card-body mb-3" style="margin-left: 200px;">
      <div class="bg-light p-2 mb-3">
        Ecrit par <?php echo $comments->fname; ?> <?php echo $comments->lname; ?> sur <?php echo $comments->time; ?>
      </div>
      <p><?php echo $comments->comment_text; ?></p>
    </div>
  <?php endforeach; ?>


  </br>
  <form action="<?php echo URLROOT; ?>/posts/addcomment/<?php echo $data['post']->id; ?>" method="post" style="margin-left: 200px;">
    <div class="form-group">
      <label>Commentaire:<sup>*</sup></label>
        <input type="text" name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['body']; ?>">
        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
    </div>
    <input type="submit" class="btn btn-success" value="Publier">
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>