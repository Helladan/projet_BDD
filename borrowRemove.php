<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$adherent_id = $_GET['idAdherent'];
	$book_id = $_GET['noExemplaire'];
	$emprunt_date = $_GET['dateEmprunt'];

	if(isset($_POST['del']))
	{
		if($_POST['del'] == 'Oui')
		{
			$req = 'DELETE FROM EMPRUNT
	                WHERE idAdherent = '.$adherent_id.' AND 
                          noExemplaire = '.$book_id.' AND 
                          dateEmprunt LIKE "'.$emprunt_date.'"';

			$link->exec($req);
			$delete = TRUE;
		}
		else
			goPage("borrowDisplay.php");
	}

	$req = "SELECT *
			FROM EMPRUNT
			NATURAL JOIN ADHERENT
			NATURAL JOIN EXEMPLAIRE
			INNER JOIN OEUVRE
			INNER JOIN AUTEUR
			WHERE ADHERENT.idAdherent = ".$adherent_id." AND
				  EXEMPLAIRE.noExemplaire = ".$book_id." AND
				  EMPRUNT.dateEmprunt LIKE '".$emprunt_date."' AND
				  EXEMPLAIRE.noOeuvre = OEUVRE.noOeuvre AND 
				  OEUVRE.idAuteur = AUTEUR.idAuteur AND
				  EMPRUNT.dateRendu IS NULL ";

	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'un Autheur') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(isset($delete) && $delete): ?>
				L'emprunt a bien été supprimé. Retour à la liste des emprunts dans quelques instants...
			<?php goPageTimer("borrowDisplay.php", 4000); ?>
			<?php elseif(count($data) == 1): ?>
				<h3><?= $data[0]['titre'].' par '.$data[0]['nomAdherent'] ?></h3>

				<p>
					Confirmer la suppression de cet emprunt datant du 
					<?= $emprunt_date ?> ?
				</p>
					<form action="borrowRemove.php?idAdherent=<?= $adherent_id ?>&noExemplaire=<?= $book_id ?>&dateEmprunt=<?= $emprunt_date ?>"
					      method="POST">
						<input type="submit"
							   name="del"
							   value="Oui"
							   class="button small">
						<input type="submit"
							   name="del"
							   value="Non"
							   class="button small">
					</form>
			<?php else:?>
				Erreur sur la requête.
			<?php endif; ?>
		</div>
	</div>
</div>
