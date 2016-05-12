<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();
	
	if(isset($_POST['del']))
	{
		if($_POST['del'] == 'Oui')
		{
			$req = 'DELETE FROM ADHERENT
			        WHERE idAdherent = '.$_GET['user'];
			
			$link->exec($req);
		}
		else
			goPage("userDisplay.php");
		
		$delete = TRUE;
	}

	$adherent_id = $_GET['user'];
	
	$req = 'SELECT nomAdherent
            FROM ADHERENT
            WHERE idAdherent = '.$adherent_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();

	$req = 'SELECT COUNT(idAdherent)
	        FROM EMPRUNT
	        WHERE idAdherent = '.$adherent_id;

	$que = $link->query($req);
	$emprunt = $que->fetch(); $emprunt = $emprunt['COUNT(idAdherent)'];
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'un utilisateur') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(isset($delete) && $delete): ?>
				L'adhérent a été supprimé. Retour à la liste des adhérents dans quelques secondes...
			<?php goPageTimer("userDisplay.php", 3000); ?>
			<?php elseif($emprunt > 0): ?>
				<h3><?= $data[0]['nomAdherent'] ?></h3>
				Cet adhérent a des emprunts en cours, impossible de le supprimer. Retour à la liste des adhérents dans quelques secondes...
			<?php goPageTimer("userDisplay.php", 4000); ?>
			<?php elseif(count($data) == 1): ?>
				<h3><?= $data[0]['nomAdherent'] ?></h3>
				
				<br>
				<p>
					Confirmer la suppression de cet adhérent ?
				</p>

				<form action="userRemove.php?user=<?= $adherent_id ?>"
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
