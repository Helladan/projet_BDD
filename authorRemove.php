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
		}
		
		header('Location: ./authorDisplay.php');
	}
	
	$author_id = $_GET['author'];
	
	$req = 'SELECT nomAuteur, prenomAuteur
	        FROM AUTEUR
	        WHERE idAuteur = '.$author_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'un Autheur') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(count($data) == 1): ?>
				<h3><?= $data[0]['nomAuteur'].' '.$data[0]['prenomAuteur'] ?></h3>
				
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
			<?php else: ?>
				Erreur sur la requête
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
