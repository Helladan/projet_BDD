<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();

	if(isset($_GET['book']))
	{
		$noExemplaire = $_GET['book'];
	}
	else
	{
		goPage('index.php');
	}


	/* PROCESS */
	if(isset($_POST['save']) && $_POST['save'])
	{
		$test = TRUE;
		if(isset($_POST['oeuvre']))
		{
			$oeuvre = $_POST['oeuvre'];
			if($oeuvre == 0)
			{
				$errorMsg['oeuvre'] = 'Vous devez selectionner une oeuvre';
				$test = FALSE;
			}
		}
		if(isset($_POST['etat']))
		{
			$etat = $_POST['etat'];
			if($etat == "0")
			{
				$errorMsg['etat'] = 'Vous devez selectionner l\'état du livre';
				$test = FALSE;
			}
		}
		if(isset($_POST['anneeAchat']))
		{
			$annee = $_POST['anneeAchat'];
			if(!is_numeric($annee) or !ctype_digit($annee))
			{
				$errorMsg['date'] = 'Il y a une erreur sur la date';
				$errorMsg['anneeAchat'] = 'Année invalide';
				$test = FALSE;
			}
			else
			{
				if(isset($_POST['moisAchat']))
				{
					$mois = $_POST['moisAchat'];
					if($mois > 12 or $mois < 1 or !ctype_digit($mois))
					{
						$errorMsg['date'] = 'Il y a une erreur sur la date';
						$errorMsg['moisAchat'] = 'Mois invalide';
						$test = FALSE;
					}
					else
					{
						if(isset($_POST['jourAchat']))
						{
							$jour = $_POST['jourAchat'];
							if(!checkdate($mois, $jour, $annee) or !ctype_digit($jour))
							{
								$errorMsg['date'] = 'Il y a une erreur sur la date';
								$errorMsg['jourAchat'] = 'jour invalide';
								$test = FALSE;
							}
						}
					}
				}
			}
		}
		else
		{
			$errorMsg['date'] = 'Il y a une erreur sur la date';
			$errorMsg['annee'] = 'L\'année doit être renseignée.';
			$test = FALSE;
		}

		if(isset($_POST['prix']))
		{
			$prix = $_POST['prix'];
			if(!is_numeric($prix))
			{
				$errorMsg['prix'] = 'Le prix doit être un nombre';
				$test = FALSE;
			}
			else
			{
				if($prix < 0)
				{
					$errorMsg['prix'] = 'Le prix doit être un nombre positif';
					$test = FALSE;
				}
			}
		}
		else
		{
			$errorMsg['prix'] = 'Le prix d\'achat doit être renseigné.';
			$test = FALSE;
		}
	}
	if(isset($test) and $test)
	{
		$req = 'UPDATE EXEMPLAIRE 
				SET noOeuvre = "'.$oeuvre.'",
					etat = "'.$etat.'", 
					dateAchat = "'.$annee.'-'.$mois.'-'.$jour.'",
					prix = "'.$prix.'"
				WHERE noExemplaire = "'.$noExemplaire.'"';

		$que = $link->exec($req) or die('La modification n\'a pas pu s\'effectuer, veuillez contacter l\'administrateur');

		$enregistrement = TRUE;
		echo 'test';
	}


	// Récupération des infos sur l'exemplaire à modifier
	$req = 'SELECT ex.noOeuvre, ex.etat, ex.dateAchat, ex.prix,
				   oe.titre,
				   au.prenomAuteur, au.nomAuteur
			FROM EXEMPLAIRE ex
			NATURAL JOIN OEUVRE oe
			NATURAL JOIN AUTEUR au
			WHERE noExemplaire = '.$noExemplaire;
	$que = $link->query($req);
	$infosExemplaire = $que->fetchAll();

	if(count($infosExemplaire) == 1)
	{
		$oeuvre = $infosExemplaire[0]['noOeuvre'];
		$etat = $infosExemplaire[0]['etat'];
		$dateAchat = date('d/m/Y', strtotime($infosExemplaire[0]['dateAchat']));
		$jour = explode('/', $dateAchat)[0];
		$mois = explode('/', $dateAchat)[1];
		$annee = explode('/', $dateAchat)[2];
		$prix = $infosExemplaire[0]['prix'];
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
				La modification a été effectuée. Retour à la liste des exemplaires dans un instant.
			</div>
		</div>
	</div>
	<?php goPageTimer("bookDisplay.php", 3000); ?>
<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<h1>
					Modification de l'exemplaire n°<?= $noExemplaire ?>
				</h1>
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="bookMod.php?book=<?= $noExemplaire ?>"
					  method="post">
					<div class="row">
						<div class="large-6 medium-6 small-12 columns">
							<label for="oeuvre">
								Oeuvre
								<select name="oeuvre"
										id="oeuvre"
										style="margin-bottom: 0">
									<option value="0">
										Selectionnez une oeuvre
									</option>
									<?php foreach($listeOeuvres as $item => $value): ?>
										<option value="<?= $value['noOeuvre'] ?>"
											<?php if(isset($oeuvre) and $oeuvre == $value['noOeuvre'])
											{
												echo 'selected';
											} ?>>
											<?= $value['nomAuteur'].' - '.$value['titre'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</label>
							<a href="workInsert.php">
								Ajouter une oeuvre qui n'est pas dans la liste
							</a>
							<?php if(isset($errorMsg['oeuvre'])): ?>
								<small class="error">
									<?= $errorMsg['oeuvre'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-6 medium-6 small-12 columns">
							<label for="etat">
								État du livre
								<select name="etat"
										id="etat"
										style="margin-bottom: 0">
									<option value="0">
										Selectionnez l'état du livre
									</option>
									<option value="neuf"
										<?php if(isset($etat) and $etat == 'neuf')
										{
											echo 'selected';
										} ?>>
										Neuf
									</option>
									<option value="bon"
										<?php if(isset($etat) and $etat == 'bon')
										{
											echo 'selected';
										} ?>>
										Bon
									</option>
									<option value="moyen"
										<?php if(isset($etat) and $etat == 'moyen')
										{
											echo 'selected';
										} ?>>
										Moyen
									</option>
									<option value="mauvais"
										<?php if(isset($etat) and $etat == 'mauvais')
										{
											echo 'selected';
										} ?>>
										Mauvais
									</option>
								</select>
							</label>
							<?php if(isset($errorMsg['etat'])): ?>
								<small class="error">
									<?= $errorMsg['etat'] ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					Date d'achat :
					<div class="row">
						<div class="large-1 medium-2 small-4 columns">
							<label for="jourAchat">
								Jour
								<input type="number"
									   id="jourAchat"
									   name="jourAchat"
									   min="1"
									   max="31"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($jour)) echo 'value="'.$jour.'"' ?>>
							</label>
							<?php if(isset($errorMsg['jourAchat'])): ?>
								<small class="error">
									<?= $errorMsg['jourAchat'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-1 medium-2 small-4 columns">
							<label for="moisAchat">
								Mois
								<input type="number"
									   id="moisAchat"
									   name="moisAchat"
									   min="1"
									   max="12"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($mois)) echo 'value="'.$mois.'"' ?>>
							</label>
							<?php if(isset($errorMsg['moisAchat'])): ?>
								<small class="error">
									<?= $errorMsg['moisAchat'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-2 medium-4 small-4 columns">
							<label for="anneeAchat">
								Année
								<input type="number"
									   id="anneeAchat"
									   name="anneeAchat"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($annee)) echo 'value="'.$annee.'"' ?>>
							</label>
							<?php if(isset($errorMsg['anneeAchat'])): ?>
								<small class="error">
									<?= $errorMsg['anneeAchat'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-2 medium-4 small-6 large-offset-2 end columns">
							<label for="prix">
								Prix du livre
								<input type="number"
									   name="prix"
									   id="prix"
									   step="0.01"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($prix)) echo 'value="'.$prix.'"' ?>>
							</label>
							<?php if(isset($errorMsg['prix'])): ?>
								<small class="error">
									<?= $errorMsg['prix'] ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					<input type="hidden"
						   name="save"
						   value="true">
					<input type="submit"
						   value="Modifier"
						   class="button expand"
						   style="font-weight: bold;
                                  margin-top: 20px; ">
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php include "include/footer.php"; ?>