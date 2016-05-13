<?php include "include/functions.php"; ?>

<?php
	if(!isset($_GET['idAdherent']) OR
		!isset($_GET['noExemplaire']) OR
		!isset($_GET['dateEmprunt'])
	)
	{
		goPage('index.php');
	}


	// PROCESS
	$link = connectDB();

	if(isset($_POST['return']))
	{
		if($_POST['return'] == 'Oui')
		{
			$req = "UPDATE EMPRUNT 
					SET dateRendu = '".date("Y-m-d")."'
					WHERE idAdherent = ".$_POST['idAdherent']." AND
						  noExemplaire = ".$_POST['noExemplaire']." AND
						  dateEmprunt = '".$_POST['dateEmprunt']."'";

			$link->exec($req) or die($req);
			$return = TRUE;
		}
		else
		{
			goPage("borrowDisplay.php");
		}
	}

	if(!isset($return))
	{
		$idAdherent = $_GET['idAdherent'];
		$noExemplaire = $_GET['noExemplaire'];
		$dateEmprunt = $_GET['dateEmprunt'];

		$req = "SELECT *
				FROM EMPRUNT
				NATURAL JOIN ADHERENT
				NATURAL JOIN EXEMPLAIRE
				INNER JOIN OEUVRE
				INNER JOIN AUTEUR
				WHERE ADHERENT.idAdherent = ".$idAdherent." AND
					  EXEMPLAIRE.noExemplaire = ".$noExemplaire." AND
					  EMPRUNT.dateEmprunt = '".$dateEmprunt."' AND
					  EXEMPLAIRE.noOeuvre = OEUVRE.noOeuvre AND 
					  OEUVRE.idAuteur = AUTEUR.idAuteur AND
					  EMPRUNT.dateRendu IS NULL ";

		$que = $link->query($req);
		$data = $que->fetchAll();
	}
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Retour d\'un exemplaire') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(isset($return) && $return): ?>
				L'exemplaire a bien été rendu.
			<?php elseif(count($data) == 1): ?>
				<h3><?= $data[0]['titre'] ?> par <?= $data[0]['nomAuteur'].' '.$data[0]['prenomAuteur'] ?></h3>
				<h3>Exemplaire n°<?= $noExemplaire ?></h3>
				<h3>Emprunté par <?= $data[0]['nomAdherent'] ?></h3>

				<br>
				<p>
					Confirmer le retour de cet exemplaire ?
				</p>

				<form action="borrowReturn.php"
					  method="POST">
					<input type="hidden"
						   name="idAdherent"
						   value="<?= $idAdherent ?>">
					<input type="hidden"
						   name="noExemplaire"
						   value="<?= $noExemplaire ?>">
					<input type="hidden"
						   name="dateEmprunt"
						   value="<?= $dateEmprunt ?>">
					<input type="submit"
						   name="return"
						   value="Oui"
						   class="button small">
					<input type="submit"
						   name="return"
						   value="Non"
						   class="button small">
				</form>
			<?php else: ?>
				Erreur sur la requête
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
