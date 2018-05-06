<?php require APPROOT . '/views/inc/header.php';?>
	<?php flash('message_send'); ?>
	<script type="text/javascript">
	$('#envoi').click(function(e){
		e.preventDefault(); // on empêche le bouton d'envoyer le formulaire

		var pseudo = encodeURIComponent( $('#pseudo').val() ); // on sécurise les données
		var message = encodeURIComponent( $('#message').val() );
		var destinataire =encodeURIComponent( $('#dest').val() );

		if(pseudo != "" && message != "" && destinataire!=""){ // on vérifie que les variables ne sont pas vides
			$.ajax({
				url : "chat.php", // on donne l'URL du fichier de traitement
				type : "POST", // la requête est de type POST
				data : "pseudo=" + pseudo + "&message=" + message // et on envoie nos données
			});
			$('#messages').append("<p>" + pseudo + " dit : " + message  "</p>");
		}
	});
	</script>
	<?php //var_dump($data);?>
	<div class="card card-body bg-light mt-5">
		<form action="<?php echo URLROOT; ?>/chats/index" method="post" enctype="multipart/form-data">
			<h2>Envoyer un message</h2>
			<div class="form-group">
				<label>Destinataire:<sup>*</sup></label>
				<input type="text" id="dest" name="dest" class="form-control form-control-lg <?php echo (!empty($data['dest_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['dest']; ?>" placeholder="Ajouter un destinataire">
				<span class="invalid-feedback"><?php echo $data['dest_err']; ?></span>
			</div>    
			<div class="form-group">
				<label>Message:<sup>*</sup></label>
				<textarea id="message" name="message" class="form-control form-control-lg <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>" placeholder="Ajouter du texte..."><?php echo $data['message']; ?></textarea>
				<span class="invalid-feedback"><?php echo $data['message_err']; ?></span>
			</div>
			<input type="submit" class="btn btn-success" name="submit" id="submit"value="Envoyez votre message !"/>
		</form>
	</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>