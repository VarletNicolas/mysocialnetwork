<!-- Par Varlet Nicolas et Duhamel Antoine -->
<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('post_message'); flash('post_comment_not_added'); flash('post_comment_added'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
    <h1>Fil d'actualité</h1>
    </div>
    <div class="col-md-6">
      <a class="btn btn-primary pull-right" href="<?php echo URLROOT; ?>/posts/add"><i class="far fa-edit" aria-hidden="true"></i> Ajouter un Poste</a>
    </div>
  </div>
  <?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
      <h4 class="card-title"><?php echo $post->title; ?></h4>
      <div class="bg-light p-2 mb-3">
        Ecrit par <?php echo $post->fname; ?> <?php echo $post->lname; ?> sur <?php echo $post->created_at; ?>
      </div>
      <?php if(!empty($post->img_p_blob)) : ?>
        <p class="card-text"><?php  echo '<img src="data:image/png;base64,'.base64_encode($post->img_p_blob).'">'; ?></p>
      <?php endif;?>
      <p><?php echo $post->body; ?></p>
      <a class="btn btn-dark" href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>">Plus</a>
    </div>
  <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>