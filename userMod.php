<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();

	if(isset($_GET['user']))
	{
		$idAdherent = $_GET['user'];
	}
	else
	{
		goPage('index.php');
	}


	/* PROCESS */
	if(isset($_POST['save']) && $_POST['save'])
	{
		$test = TRUE;
		if(isset($_POST['nom']))
		{
			$nom = $_POST['nom'];
			if($nom == '')
			{
				$errorMsg['nom'] = 'Vous devez renseigner un nom';
				$test = FALSE;
			}
		}
		if(isset($_POST['adresse']))
		{
			$adresse = $_POST['adresse'];
			if($adresse == '')
			{
				$errorMsg['adresse'] = 'Vous devez renseigner une adresse';
				$test = FALSE;
			}
		}
		if(isset($_POST['anneePaiement']))
		{
			$annee = $_POST['anneePaiement'];
			if(!is_numeric($annee) or !ctype_digit($annee))
			{
				$errorMsg['date'] = 'Il y a une erreur sur la date';
				$errorMsg['anneePaiement'] = 'Année invalide';
				$test = FALSE;
			}
			else
			{
				if(isset($_POST['moisPaiement']))
				{
					$mois = $_POST['moisPaiement'];
					if($mois > 12 or $mois < 1 or !ctype_digit($mois))
					{
						$errorMsg['date'] = 'Il y a une erreur sur la date';
						$errorMsg['moisPaiement'] = 'Mois invalide';
						$test = FALSE;
					}
					else
					{
						if(isset($_POST['jourPaiement']))
						{
							$jour = $_POST['jourPaiement'];
							if(!checkdate($mois, $jour, $annee) or !ctype_digit($jour))
							{
								$errorMsg['date'] = 'Il y a une erreur sur la date';
								$errorMsg['jourPaiement'] = 'jour invalide';
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

	}
	if(isset($test) and $test)
	{
		$req = 'UPDATE ADHERENT 
				SET nomAdherent = "'.$nom.'",
					adresse = "'.$adresse.'", 
					datePaiement = "'.$annee.'-'.$mois.'-'.$jour.'"
				WHERE idAdherent = "'.$idAdherent.'"';

		$que = $link->exec($req) or die('La modification n\'a pas pu s\'effectuer, veuillez contacter l\'administrateur');

		$enregistrement = TRUE;
		echo 'test';
	}


	// Récupération des infos sur l'adhérent à modifier
	$req = 'SELECT nomAdherent, adresse, datePaiement
			FROM ADHERENT 
			WHERE idAdherent = '.$idAdherent;
	$que = $link->query($req);
	$infosAdherent = $que->fetchAll();

	if(count($infosAdherent) == 1)
	{
		$nom = $infosAdherent[0]['nomAdherent'];
		$adresse = $infosAdherent[0]['adresse'];
		$datePaiement = date('d/m/Y', strtotime($infosAdherent[0]['datePaiement']));
		$jour = explode('/', $datePaiement)[0];
		$mois = explode('/', $datePaiement)[1];
		$annee = explode('/', $datePaiement)[2];
	}
	else
	{
		die('Erreur sur la requête, veuillez s\'il vous plait contacter l\'administrateur.');
	}
	
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Modification d\'un exemplaire') ?>
<?php include "include/menu.php"; ?>
	<!-- DISPLAY -->
<?php if(isset($enregistrement) && $enregistrement): ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				La modification a été effectuée. Retour à la liste des adhérents dans un instant.
			</div>
		</div>
	</div>
	<?php goPageTimer("userDisplay.php", 3000); ?>
<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<h1>
					Modification de l'adhérent n°<?= $idAdherent ?>
				</h1>
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="userMod.php?user=<?= $idAdherent ?>"
					  method="post">
					<div class="row">
						<div class="large-4 medium-4 small-12 columns">
							<label for="nom">
								Nom
								<input type="text"
									   name="nom"
									   id="nom"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($nom)) echo 'value="'.$nom.'"' ?>>
							</label>
							<?php if(isset($errorMsg['name'])): ?>
								<small class="error">
									<?= $errorMsg['name'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-8 medium-8 small-12 columns">
							<label for="adresse">
								Adresse
								<input type="text"
									   name="adresse"
									   id="adresse"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($adresse)) echo 'value="'.$adresse.'"' ?>>
							</label>
							<?php if(isset($errorMsg['adresse'])): ?>
								<small class="error">
									<?= $errorMsg['adresse'] ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					Date de paiement :
					<div class="row">
						<div class="large-1 medium-2 small-4 columns">
							<label for="jourPaiement">
								Jour
								<input type="number"
									   id="jourPaiement"
									   name="jourPaiement"
									   min="1"
									   max="31"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($jour)) echo 'value="'.$jour.'"' ?>>
							</label>
							<?php if(isset($errorMsg['jourPaiement'])): ?>
								<small class="error">
									<?= $errorMsg['jourPaiement'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-1 medium-2 small-4 columns">
							<label for="moisPaiement">
								Mois
								<input type="number"
									   id="moisPaiement"
									   name="moisPaiement"
									   min="1"
									   max="12"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($mois)) echo 'value="'.$mois.'"' ?>>
							</label>
							<?php if(isset($errorMsg['moisPaiement'])): ?>
								<small class="error">
									<?= $errorMsg['moisPaiement'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-2 medium-4 small-4 columns end">
							<label for="anneeAchat">
								Année
								<input type="number"
									   id="anneePaiement"
									   name="anneePaiement"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($annee)) echo 'value="'.$annee.'"' ?>>
							</label>
							<?php if(isset($errorMsg['anneePaiement'])): ?>
								<small class="error">
									<?= $errorMsg['anneePaiement'] ?>
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