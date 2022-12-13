<section class="inscriptionForm" id="orderForm">
	<?php $message = SessionFlash::get('error') ?>
	<?= ($message == '') ? '' : '<div class="errorContainer"><div class="error">' . $message . '</div></div>'; ?>
	<form method="POST" action="" class="orderForm">
		<legend>Demande de devis</legend>
		<input type="text" name="name" placeholder="Nom*" value="<?= $lastname ?? '' ?>" required pattern="^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$">
		<?= empty($errors['name']) ? '' : '<div class="errorMessage">' . $errors['name'] . '</div>' ?>
		<input type="text" name="firstname" placeholder="Prénom*" value="<?= $firstname ?? '' ?>" required pattern="^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$">
		<?= empty($errors['firstname']) ? '' : '<div class="errorMessage">' . $errors['firstname'] . '</div>' ?>
		<input type="email" name="email" placeholder="Adresse mail*" value="<?= $email ?? '' ?>" required pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z-]+\.[a-zA-Z-.]+$">
		<?= empty($errors['email']) ? '' : '<div class="errorMessage">' . $errors['email'] . '</div>' ?>
		<input type="phone" name="phone" placeholder="Numéro de téléphone*" value="<?= $phoneNb ?? '' ?>" required pattern="^[0][1-9]-?[0-9]{2}-?[0-9]{2}-?[0-9]{2}-?[0-9]{2}$">
		<?= empty($errors['phoneNb']) ? '' : '<div class="errorMessage">' . $errors['phoneNb'] . '</div>' ?>
		<input type="date" name="date" value="<?= $date ?? '' ?>" pattern="^<?= date('Y', time()) ?>-<?= date('m', time()) ?>-[0-3][0-9]$" required>
		<?= empty($errors['date']) ? '' : '<div class="errorMessage">' . $errors['date'] . '</div>' ?>
		<select name="time" pattern="^[1-8]$" required>
			<optgroup selected label="Réserver pour le midi">
				<option value="1" <?= (isset($time) && $time == 1) ? 'selected' : '' ?>>12h00</option>
				<option value="2" <?= (isset($time) && $time == 2) ? 'selected' : '' ?>>12h30</option>
				<option value="3" <?= (isset($time) && $time == 3) ? 'selected' : '' ?>>13h00</option>
				<option value="4" <?= (isset($time) && $time == 4) ? 'selected' : '' ?>>13h30</option>
			</optgroup>
			<optgroup label="Réserver pour le soir">
				<option value="5" <?= (isset($time) && $time == 5) ? 'selected' : '' ?>>19h00</option>
				<option value="6" <?= (isset($time) && $time == 6) ? 'selected' : '' ?>>19h30</option>
				<option value="7" <?= (isset($time) && $time == 7) ? 'selected' : '' ?>>20h00</option>
				<option value="8" <?= (isset($time) && $time == 8) ? 'selected' : '' ?>>20h30</option>
			</optgroup>
		</select>
		<?= empty($errors['time']) ? '' : '<div class="errorMessage">' . $errors['time'] . '</div>' ?>

		<div class="dishes">
			<script>
				fetch(`/getDishesAjax`)
				.then(response => response.json())
				.then(data => {
						console.log(data);
						// Tri les plats par type de plat du plus petit au plus grand
						data.sort(
							(p1, p2) =>
							(p1.id_dishes_types < p2.id_dishes_types) ? -1 : (p1.id_dishes_types > p2.id_dishes_types) ? 1 : 0);
						let div =
							`<div class="dish">`;
						let select =
							`<select name="dishList[]">`;


						let select2 =
							`<select name="quantity[]">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
							</select>`;
						let del =
							`<div class="del">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
							</div>`;
						data.forEach(element => {
							select += `<option value="${element.id}">${element.title}</option>`;
						});
						select += `</select>`;
						div += select + select2 + del + `</div>`;
						dishesContainer.innerHTML += div;

						let deleteDishes = document.querySelectorAll('.reservation .del');
						deleteDishes.forEach(element => {
							element.addEventListener('click', () => {
								element.parentNode.remove();
							})
						});
					})
			</script>
		</div>

		<div class="addDish">+</div>
		<div class="errorMessage"><?= $errors['cgu'] ?? '' ?></div>
		<div class="errorMessage"><?= $errors['newsletter'] ?? '' ?></div>
		<button type="submit">Demander un devis</button>
	</form>
</section>
</main>
<script src="../../public/assets/js/orderForm.js"></script>
<script src="../../public/assets/js/menuBurger.js"></script>
</body>

</html>