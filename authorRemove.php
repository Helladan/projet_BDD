<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();
	
	if(isset($_POST['del']))
	{
		if($_POST['del'] == 'Oui')
		{
			$req = 'DELETE FROM AUTEUR
			        WHERE idAuteur = '.$_GET['author'];
			
			$link->exec($req);
			$delete = TRUE;	
		}
		else
			goPage("authorDisplay.php");
	}
	
	$author_id = $_GET['author'];
	
	$req = 'SELECT nomAuteur, prenomAuteur
	        FROM AUTEUR
	        WHERE idAuteur = '.$author_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();

	$req = 'SELECT noOeuvre
	        FROM OEUVRE
	        WHERE idAuteur = ' . $author_id;

	$que = $link->query($req);
	$nb_oeuvre = count($que->fetchAll());
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'un Autheur') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(isset($delete) && $delete): ?>
				L'auteur a bien été supprimé. Retour à la liste des auteurs dans quelques instants...
			<?php goPageTimer("authorDisplay.php", 4000); ?>
			<?php elseif(count($data) == 1): ?>
				<h3><?= $data[0]['nomAuteur'].' '.$data[0]['prenomAuteur'] ?></h3>
				
				<?php if($nb_oeuvre == 0): ?>
					<br>
					<p>
						Confirmer la suppression de cet auteur ?
					</p>

					<form action="authorRemove.php?author=<?= $author_id ?>"
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
					Cet auteur possède déjà des oeuvres, impossible de le supprimer. Retour à la liste des auteurs dans quelques instants...
				<?php goPageTimer("authorDisplay.php", 5000); ?>
				<?php endif; ?>
			<?php else: ?>
				Erreur sur la requête
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
