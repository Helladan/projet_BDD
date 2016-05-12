<?php include "include/functions.php"; ?>


<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'exemplaire')?>
<?php include "include/menu.php"; ?>

<?php // PROCESS
	$link = connectDB();
	
	if(isset($_POST['del']))
	{
		if($_POST['del'] == 'Oui')
		{
			$req = 'DELETE FROM EXEMPLAIRE
			        WHERE noExemplaire = '.$_GET['book'];
			
			$link->exec($req);
			$delete = TRUE;
		}
		else
			goPage("bookDisplay.php");
	}
	
	$book_id = $_GET['book'];
	
	$req = 'SELECT OEUVRE.titre
	        FROM EXEMPLAIRE
	        INNER JOIN OEUVRE ON OEUVRE.noOeuvre = EXEMPLAIRE.noOeuvre
	        WHERE noExemplaire = '.$book_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();

	$req = 'SELECT COUNT(noExemplaire)
	        FROM EMPRUNT
	        WHERE noExemplaire = '.$book_id;

	$que = $link->query($req);
	$emprunt = $que->fetch(); $emprunt = $emprunt['COUNT(noExemplaire)'];
?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(isset($delete) && $delete): ?>
				L'exemplaire a bien été supprimé. Retour à la liste des exemplaires dans quelques instants...
			<?php goPageTimer("bookDisplay.php", 3000); ?>
			<?php elseif($emprunt > 0): ?>
				<h3><?= $data[0]['titre'] ?></h3>
				Cet exemplaire est en cours d'emprunt, impossible de le supprimer. Retour à la liste des exemplaires dans quelques instants...
			<?php goPageTimer("bookDisplay.php", 5000); ?>
			<?php elseif(count($data) == 1): ?>
				<h3><?= $data[0]['titre'] ?></h3>
				
				<br>
				<p>
					Confirmer la suppression de cet exemplaire ?
				</p>

				<form action="bookRemove.php?book=<?= $book_id ?>"
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
			<?php else: ?>
				Erreur sur la requête
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
