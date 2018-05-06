<?php require APPROOT . '/views/inc/header.php'; ?>
  <center>
  <?php if(!empty($data['pattern_err'])):?>
    <?php echo $data['pattern_err']; ?>
  </center>
  <?php else: ?>
    <?php foreach($data['searchresult'] as $arr2): ?>

      <?php if(!array_key_exists('title', $arr2)): ?>
        <a href="<?php echo URLROOT; ?>/profiles/p/<?php echo $arr2->id; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
          <big>Utilisateur: <?php echo $arr2->fname.' '.$arr2->lname; ?></big>
          <button type="button" class="btn btn-info">Voir le profile</button>
        </a></br>
      <?php else: ?>
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $arr2->PID; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
          <big>Ecrit part: <?php echo $arr2->fname.' '.$arr2->lname; ?></big>
          <center><big>Titre: <?php echo $arr2->title?></big></center>
          <center><small><?php echo $arr2->body?></small></center>
          <button type="button" class="btn btn-info">Voir le post complet</button>
        </a></br>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>