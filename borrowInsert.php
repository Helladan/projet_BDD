<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();

	/* PROCESS */
	if(isset($_POST['save']) && $_POST['save'])
	{
		$test = TRUE;
		if(isset($_POST['exemplaire']))
		{
			$exemplaire = $_POST['exemplaire'];
			echo '<br>Exemplaire : '. $exemplaire;
			if($exemplaire == 0)
			{
				$errorMsg['exemplaire'] = 'Vous devez selectionner une exemplaire';
				$test = FALSE;
			}
		}
		if(isset($_POST['adherent']))
		{
			$adherent = $_POST['adherent'];
			echo '<br>Adhérent : '.$adherent;
			if($adherent == 0)
			{
				$errorMsg['adherent'] = 'Vous devez selectionner un adhérent';
				$test = FALSE;
			}
		}
		if(isset($_POST['dateEmprunt']))
		{
			$dateEmprunt = $_POST['dateEmprunt'];
			if(!dateValidator($dateEmprunt, 'Y-m-d'))
			{
				$errorMsg['dateEmprunt'] = 'Date invalide';
				$test = FALSE;
			}
		}
		else
		{
			$errorMsg['dateEmprunt'] = 'La date d\'emprunt doit être renseignée.';
			$test = FALSE;
		}

	}
	if(isset($test) and $test)
	{
		$req = 'INSERT INTO EMPRUNT(idAdherent,
								   	 noExemplaire,
								   	 dateEmprunt)
				VALUES ("'.$adherent.'", 
					   "'.$exemplaire.'", 
					   "'.$dateEmprunt.'")';

		$que = $link->exec($req) or die('L\'enregistrement n\'a pas pu s\'effectuer');

		$enregistrement = TRUE;
	}


	// Récupération de la liste des exemplaires et de leurs infos
	$req = 'SELECT EXEMPLAIRE.noExemplaire,
 				   OEUVRE.titre,	
				   AUTEUR.nomAuteur
			FROM EXEMPLAIRE
			NATURAL JOIN OEUVRE
			NATURAL JOIN AUTEUR
			WHERE EXEMPLAIRE.noExemplaire NOT IN 
			(
				SELECT noExemplaire 
				FROM EMPRUNT
				WHERE dateRendu IS NULL 
			)
			ORDER BY AUTEUR.nomAuteur, OEUVRE.titre, EXEMPLAIRE.noExemplaire';

	$que = $link->query($req);
	$listeExemplaires = $que->fetchAll();


	// Récupération de la liste des adhérents
	$req = "SELECT idAdherent, nomAdherent
			FROM ADHERENT";

	$que = $link->query($req);
	$listeAdherents = $que->fetchAll();


	if(!isset($date))
	{
		$date = date('Y-m-d');
	}

?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Enregistrement d\'un emprunt') ?>
<?php include "include/menu.php"; ?>
	<!-- DISPLAY -->
<?php if(isset($enregistrement) && $enregistrement): ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				L'enregistrement a été effectué.
			</div>
		</div>
	</div>

<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<h1>
					Enregistrement d'un emprunt
				</h1>
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="borrowInsert.php"
					  method="post">
					<div class="row">
						<!-- exemplaire -->
						<div class="large-6 medium-6 small-12 columns">
							<label for="exemplaire">
								Exemplaire
								<select name="exemplaire"
										id="exemplaire"
										style="margin-bottom: 0">
									<option value="0">
										Selectionnez un exemplaire
									</option>
									<?php foreach($listeExemplaires as $item => $value): ?>
										<option value="<?= $value['noExemplaire'] ?>"
											<?php if(isset($exemplaire) and $exemplaire == $value['noExemplaire'])
											{
												echo 'selected';
											} ?>>
											<?= $value['nomAuteur'].' - '.$value['titre'].' - '.$value['noExemplaire'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</label>
							<?php if(isset($errorMsg['exemplaire'])): ?>
								<small class="error">
									<?= $errorMsg['exemplaire'] ?>
								</small>
							<?php endif; ?>
						</div>
						<!-- adherent -->
						<div class="large-6 medium-6 small-12 columns">
							<label for="adherent">
								Adhérent
								<select name="adherent"
										id="adherent"
										style="margin-bottom: 0">
									<option value="0">
										Selectionnez l'adhérent
									</option>
									<?php foreach($listeAdherents as $item => $value): ?>
										<option value="<?= $value['idAdherent'] ?>"
											<?php if(isset($adherent) and $adherent == $value['idAdherent'])
											{
												echo 'selected';
											} ?>>
											<?= $value['nomAdherent'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</label>
							<?php if(isset($errorMsg['adherent'])): ?>
								<small class="error">
									<?= $errorMsg['adherent'] ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					<div class="row">
						<!-- dateEmprunt -->
						<div class="large-4 medium-4 small-4 columns">
							<label for="jourEmprunt">
								Date d'emprunt :
								<input type="date"
									   id="dateEmprunt"
									   name="dateEmprunt"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($date)) echo 'value="'.$date.'"' ?>>
							</label>
							<?php if(isset($errorMsg['dateEmprunt'])): ?>
								<small class="error">
									<?= $errorMsg['dateEmprunt'] ?>
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