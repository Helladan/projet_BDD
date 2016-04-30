<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();

	/* PROCESS */
	if(isset($_POST['save']) && $_POST['save'])
	{
		$test = TRUE;

		if(isset($_POST['authorName']))
		{
			$authorName = $_POST['authorName'];
		}
		else
		{
			$errorMsg['prix'] = 'Le nom de l\'auteur doit être renseigné.';
			$test = FALSE;
		}

		if(isset($_POST['authorFirstName']))
		{
			$authorFirstName = $_POST['authorFirstName'];
		}
		else
		{
			$errorMsg['prix'] = 'Le prénom de l\'auteur doit être renseigné.';
			$test = FALSE;
		}
	}
	if(isset($test) and $test)
	{
		$req = 'INSERT INTO AUTEUR(nomAuteur, 
								   prenomAuteur)
				VALUES ("'.$authorName.'", 
					    "'.$authorFirstName.'")';


		$que = $link->exec($req) or die('L\'enregistrement n\'a pas pu s\'effectuer');

		$enregistrement = TRUE;
	}

?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Enregistrement d\'un auteur') ?>
<?php include "include/menu.php"; ?>
	<!-- DISPLAY -->
<?php if(isset($enregistrement) && $enregistrement): ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<p>L'enregistrement a été effectué.</p>
				<a href="workInsert.php">
					Ajouter une oeuvre
				</a>
			</div>
		</div>
	</div>

<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<h1>
					Enregistrement d'un auteur
				</h1>
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="authorInsert.php"
					  method="post">
					<div class="row">
						<div class="large-6 medium-6 small-12 columns">
							<label for="authorName">
								Nom de l'auteur :
								<input type="text"
									   id="authorName"
									   name="authorName"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($authorName)) echo 'value="'.$authorName.'"' ?>>
							</label>
							<?php if(isset($errorMsg['authorName'])): ?>
								<small class="error">
									<?= $errorMsg['authorName'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-6 medium-6 small-12 columns">
							<label for="authorFirstName">
								Prénom de l'auteur :
								<input type="text"
									   id="authorFirstName"
									   name="authorFirstName"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($authorFirstName)) echo 'value="'.$authorFirstName.'"' ?>>
							</label>
							<?php if(isset($errorMsg['authorFirstName'])): ?>
								<small class="error">
									<?= $errorMsg['authorFirstName'] ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					<input type="hidden"
						   name="save"
						   value="true">
					<input type="submit"
						   value="Enregistrer"
						   class="button expand"
						   style="font-weight: bold;
                                  margin-top: 20px; ">
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php include "include/footer.php"; ?>