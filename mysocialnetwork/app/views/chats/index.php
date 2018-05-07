<!-- Par Varlet Nicolas et Duhamel Antoine -->
<?php require APPROOT . '/views/inc/header.php';?>
	<?php flash('message_send'); ?>
	<?php //var_dump($data['friendlist']);?>
	<div class="card card-body bg-light mt-5">
		<form action="<?php echo URLROOT; ?>/chats/index" method="post" enctype="multipart/form-data">
			<h2>Envoyer un message</h2>
			<div class="form-group">
				<select name="dest">
					<option value="">-----------------</option>
					<?php
						foreach($data['friendlist'] as $arr):
							echo '<option value="'.$arr->id.'">'.$arr->lname.' '.$arr->fname.'</option>'; //close your tags!!
						endforeach;
					?>
				</select>
			</div>
			<div class="form-group">
				<label>Message:<sup>*</sup></label>
				<textarea id="message" name="message" class="form-control form-control-lg <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>" placeholder="Ajouter du texte..."><?php echo $data['message']; ?></textarea>
				<span class="invalid-feedback"><?php echo $data['message_err']; ?></span>
			</div>
			<input type="submit" class="btn btn-success" name="submit" id="submit"value="Envoyez votre message !"/>
		</form>
		<form action="<?php echo URLROOT; ?>/chats/viewconv" method="post" enctype="multipart/form-data">
			<h2>Voir une conversation</h2>
			<div class="form-group">
				<select id="dest" name="dest">
					<option value="">-----------------</option>
					<?php
						foreach($data['friendlist'] as $arr):
							echo '<option value="'.$arr->id.'">'.$arr->lname.' '.$arr->fname.'</option>'; //close your tags!!
						endforeach;
					?>
				</select>
			</div>
			
			<input type="submit" class="btn btn-success" name="submit" id="submit"value="Envoyez votre message !"/>
		</form>
	</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>