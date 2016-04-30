<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();

	if(isset($_GET['author']))
	{
		$idAuteur = $_GET['author'];
	}
	else
	{
		goPage('index.php');
	}


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
		$req = 'UPDATE AUTEUR 
				SET nomAuteur = "'.$authorName.'",
					prenomAuteur = "'.$authorFirstName.'"
				WHERE idAuteur = "'.$idAuteur.'"';

		$que = $link->exec($req) or die('La modification n\'a pas pu s\'effectuer, veuillez contacter l\'administrateur');

		$enregistrement = TRUE;
		echo 'test';
	}


	// Récupération des infos sur l'auteur à modifier
	$req = 'SELECT prenomAuteur, nomAuteur
			FROM AUTEUR
			WHERE idAuteur = '.$idAuteur;
	$que = $link->query($req);
	$infosAuteur = $que->fetchAll();

	if(count($infosAuteur) == 1)
	{
		$authorFirstName = $infosAuteur[0]['prenomAuteur'];
		$authorName = $infosAuteur[0]['nomAuteur'];
	}
	else
	{
		die('Erreur sur la requête, veuillez s\'il vous plait contacter l\'administrateur.');
	}

	// Récupération de la liste des oeuvres
	$req = "SELECT OEUVRE.noOeuvre, OEUVRE.titre, 
				   AUTEUR.nomAuteur
			FROM OEUVRE
			NATURAL JOIN AUTEUR
			ORDER BY AUTEUR.nomAuteur, OEUVRE.titre";

	$que = $link->query($req);
	$listeOeuvres = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Modification d\'un exemplaire') ?>
<?php include "include/menu.php"; ?>
	<!-- DISPLAY -->
<?php if(isset($enregistrement) && $enregistrement): ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				La modification a été effectuée. Retour à la liste des auteurs dans un instant.
			</div>
		</div>
	</div>
	<?php goPageTimer("authorDisplay.php", 3000) ?>

<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<h1>
					Modification de l'auteur n°<?= $noExemplaire ?>
				</h1>
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="authorMod.php?author=<?= $idAuteur ?>"
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