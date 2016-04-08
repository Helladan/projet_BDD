<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();


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
					$errorMsg['prix'] = 'Le prix doit être un positif';
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
		$req = 'INSERT INTO EXEMPLAIRE(noOeuvre, 
									   etat, 
									   dateAchat, 
									   prix)
				VALUES ('.$oeuvre.', 
					   "'.$etat.'", 
					   "'.$annee.'-'.$mois.'-'.$jour.'", 
					   "'.$prix.'")';
		
		$req = $link->exec($req) or die('L\'enregistrement n\'a pas pu s\'effectuer');

		$enregistrement = TRUE;
	}


	$req = "SELECT OEUVRE.noOeuvre, OEUVRE.titre, 
				   AUTEUR.nomAuteur
			FROM OEUVRE
			NATURAL JOIN AUTEUR
			ORDER BY AUTEUR.nomAuteur, OEUVRE.titre";

	$que = $link->query($req);
	$listeOeuvres = $que->fetchAll();

	if(!isset($jour))
	{
		$jour = date('d');
	}
	if(!isset($mois))
	{
		$mois = date('m');
	}
	if(!isset($annee))
	{
		$annee = date('Y');
	}

?>

<?php include "include/header.php"; ?>
	<?php setPageTitle('Enregistrement d\'un exemplaire')?>
<?php include "include/menu.php"; ?>
	<!-- DISPLAY -->
<?php if($enregistrement): ?>
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
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="bookInsert.php"
					  method="post">
					<div class="row">
						<div class="large-6 medium-6 small-6 columns">
							<label for="oeuvre">
								Oeuvre
								<select name="oeuvre"
										id="oeuvre"
										name="oeuvre"
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
							<?php if(isset($errorMsg['oeuvre'])): ?>
								<small class="error">
									<?= $errorMsg['oeuvre'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-6 medium-6 small-6 columns">
							<label for="etat">
								État du livre
								<select name="etat"
										id="etat"
										style="margin-bottom: 0">
									<option value="0">
										Selectionnez l'état du livre
									</option>
									<option value="NEUF"
										<?php if(isset($etat) and $etat == 'NEUF')
										{
											echo 'selected';
										} ?>>
										Neuf
									</option>
									<option value="BON"
										<?php if(isset($etat) and $etat == 'BON')
										{
											echo 'selected';
										} ?>>
										Bon
									</option>
									<option value="MOYEN"
										<?php if(isset($etat) and $etat == 'MOYEN')
										{
											echo 'selected';
										} ?>>
										Moyen
									</option>
									<option value="MAUVAIS"
										<?php if(isset($etat) and $etat == 'MAUVAIS')
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
						<div class="large-1 medium-2 small-2 columns">
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
						<div class="large-1 medium-2 small-2 columns">
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
						<div class="large-2 medium-4 small-4 large-offset-2 end columns">
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