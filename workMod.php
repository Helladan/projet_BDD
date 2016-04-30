<?php include "include/functions.php"; ?>

<?php
	$link = connectDB();
	
	if(isset($_GET['work']))
	{
		$noOeuvre = $_GET['work'];
	}
	else
	{
		goPage('index.php');
	}
	
	
	/* PROCESS */
	if(isset($_POST['save']) && $_POST['save'])
	{
		$test = TRUE;
		if(isset($_POST['auteur']))
		{
			$auteur = $_POST['auteur'];
			if($auteur == 0)
			{
				$errorMsg['auteur'] = 'Vous devez selectionner un auteur';
				$test = FALSE;
			}
		}
		if(isset($_POST['titre']))
		{
			$titre = $_POST['titre'];
			if($titre == "")
			{
				$errorMsg['titre'] = 'Vous devez renseigner un titre';
				$test = FALSE;
			}
		}
		if(isset($_POST['anneeParution']))
		{
			$annee = $_POST['anneeParution'];
			if(isset($_POST['moisParution']))
			{
				$mois = $_POST['moisParution'];
			}
			if(isset($_POST['moisParution']))
			{
				$jour = $_POST['jourParution'];
			}
			if(!is_numeric($annee) or !ctype_digit($annee))
			{
				$errorMsg['date'] = 'Il y a une erreur sur la date';
				$errorMsg['anneeParution'] = 'Année invalide';
				$test = FALSE;
			}
			else
			{
				if(isset($_POST['moisParution']))
				{
					$mois = $_POST['moisParution'];
					if($mois > 12 or $mois < 1 or !ctype_digit($mois))
					{
						$errorMsg['date'] = 'Il y a une erreur sur la date';
						$errorMsg['moisParution'] = 'Mois invalide';
						$test = FALSE;
					}
					else
					{
						if(isset($_POST['jourParution']))
						{
							$jour = $_POST['jourParution'];
							if(!checkdate($mois, $jour, $annee) or !ctype_digit($jour))
							{
								$errorMsg['date'] = 'Il y a une erreur sur la date';
								$errorMsg['jourParution'] = 'jour invalide';
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
	else
	{
		// Récupération des infos sur l'oeuvre à modifier
		$req = 'SELECT oe.titre, oe.dateParution,
				   au.idAuteur
			FROM OEUVRE oe
			NATURAL JOIN AUTEUR au
			WHERE noOeuvre = '.$noOeuvre;
		$que = $link->query($req);
		$infosOeuvre = $que->fetchAll();
		
		if(count($infosOeuvre) == 1)
		{
			$auteur = $infosOeuvre[0]['idAuteur'];
			$titre = $infosOeuvre[0]['titre'];
			$dateParution = date('d/m/Y', strtotime($infosOeuvre[0]['dateParution']));
			$jour = explode('/', $dateParution)[0];
			$mois = explode('/', $dateParution)[1];
			$annee = explode('/', $dateParution)[2];
		}
		else
		{
			die('Erreur sur la requête, veuillez s\'il vous plait contacter l\'administrateur.');
		}
	}
	if(isset($test) and $test)
	{
		$req = 'UPDATE OEUVRE 
				SET idAuteur = "'.$auteur.'",
					titre = "'.$titre.'",
					dateParution = "'.$annee.'-'.$mois.'-'.$jour.'"
				WHERE noOeuvre = "'.$noOeuvre.'"';
		
		$que = $link->exec($req) or die('La modification n\'a pas pu s\'effectuer, veuillez contacter l\'administrateur');
		
		$enregistrement = TRUE;
		echo 'test';
	}
	
	
	// Récupération de la liste des auteurs
	$req = "SELECT idAuteur, nomAuteur, prenomAuteur
			FROM AUTEUR
			ORDER BY nomAuteur, prenomAuteur";
	
	$que = $link->query($req);
	$listeAuteurs = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Modification d\'un exemplaire') ?>
<?php include "include/menu.php"; ?>
	<!-- DISPLAY -->
<?php if(isset($enregistrement) && $enregistrement): ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				La modification a été effectuée. Retour à la liste des oeuvres dans un instant.
			</div>
		</div>
	</div>
	<?php goPageTimer("workDisplay.php", 3000); ?>
<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<h1>
					Modification de l'oeuvre n°<?= $noOeuvre ?>
				</h1>
				<?php if(isset($errorMsg)): ?>
					<small class="error">
						Attention, certaines valeurs sont incorrectes
					</small>
				<?php endif; ?>
				<form action="workMod.php?work=<?= $noOeuvre ?>"
					  method="post">
					<div class="row">
						<div class="large-6 medium-6 small-12 columns">
							<label for="auteur">
								Auteur
								<select name="auteur"
										id="auteur"
										style="margin-bottom: 0">
									<option value="0">
										Selectionnez un auteur
									</option>
									<?php foreach($listeAuteurs as $item => $value): ?>
										<option value="<?= $value['idAuteur'] ?>"
											<?php if(isset($auteur) and $auteur == $value['idAuteur'])
											{
												echo 'selected';
											} ?>>
											<?= $value['nomAuteur'].', '.$value['prenomAuteur'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</label>
							<a href="authorInsert.php">
								Ajouter un auteur qui n'est pas dans la liste
							</a>
							<?php if(isset($errorMsg['auteur'])): ?>
								<small class="error">
									<?= $errorMsg['auteur'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-6 medium-6 small-12 columns">
							<label for="titre">
								Titre de l'oeuvre
								<input type="text"
									   name="titre"
									   id="titre"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($titre)) echo 'value="'.$titre.'"' ?>>
							</label>
							<?php if(isset($errorMsg['titre'])): ?>
								<small class="error">
									<?= $errorMsg['titre'] ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					Date de parution :
					<div class="row">
						<div class="large-1 medium-2 small-4 columns">
							<label for="jourParution">
								Jour
								<input type="number"
									   id="jourParution"
									   name="jourParution"
									   min="1"
									   max="31"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($jour)) echo 'value="'.$jour.'"' ?>>
							</label>
							<?php if(isset($errorMsg['jourParution'])): ?>
								<small class="error">
									<?= $errorMsg['jourParution'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-1 medium-2 small-4 columns">
							<label for="moisParution">
								Mois
								<input type="number"
									   id="moisParution"
									   name="moisParution"
									   min="1"
									   max="12"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($mois)) echo 'value="'.$mois.'"' ?>>
							</label>
							<?php if(isset($errorMsg['moisParution'])): ?>
								<small class="error">
									<?= $errorMsg['moisParution'] ?>
								</small>
							<?php endif; ?>
						</div>
						<div class="large-2 medium-4 small-4 columns end">
							<label for="anneeAchat">
								Année
								<input type="number"
									   id="anneeParution"
									   name="anneeParution"
									   style="margin-bottom: 0"
									   required
									<?php if(isset($annee)) echo 'value="'.$annee.'"' ?>>
							</label>
							<?php if(isset($errorMsg['anneeParution'])): ?>
								<small class="error">
									<?= $errorMsg['anneeParution'] ?>
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