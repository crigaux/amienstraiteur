<div class="userProfil">
	<h1>COMMENTAIRES</h1>

	<h2>Modifier</h2>
	<div class="openBurger">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
			<!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
			<path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
		</svg>
	</div>

	<form method="POST" action="/profil/commentaire/edit/<?=$id?>">
		<input type="text" name="title" placeholder="Titre*" required value="<?= $review->title ?>">
		<textarea name="review" cols="30" rows="10" required placeholder="Écrivez votre commentaire ici*" ><?= $review->content ?></textarea>
		<button type="submit">Envoyer</button>
	</form>
</div>

<script src="../../../public/assets/js/menuBurgerDB.js"></script>