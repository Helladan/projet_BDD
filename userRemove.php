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
		
		header('Location: ./userDisplay.php');
	}
	
	$adherent_id = $_GET['user'];
	
	$req = 'SELECT nomAdherent
	        FROM ADHERENT
	        WHERE idAdherent = '.$adherent_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'un utilisateur') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(count($data) == 1): ?>
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
