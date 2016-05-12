<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();
	
	if(isset($_POST['del']))
	{
		if($_POST['del'] == 'Oui')
		{
			$req = 'DELETE FROM OEUVRE
			        WHERE noOeuvre = '.$_GET['work'];
			
			$link->exec($req);
		}
		else
			goPage("workDisplay.php");
		
		$delete = TRUE;
	}

	$work_id = $_GET['work'];
	
	$req = 'SELECT titre
            FROM OEUVRE
            WHERE noOeuvre = '.$work_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();

	$req = 'SELECT COUNT(noOeuvre)
            FROM EXEMPLAIRE
            WHERE noOeuvre = '.$work_id;

	$que = $link->query($req);
	$book = $que->fetch(); $book = $book['COUNT(noOeuvre)'];
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'une oeuvre') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php if(isset($delete) && $delete): ?>
				L'oeuvre a été supprimée. Retour à la liste des oeuvres dans quelques instant ...
			<?php goPageTimer("workDisplay.php", 3000); ?>
			<?php elseif($book > 0): ?>
				<h3><?= $data[0]['titre'] ?></h3>
				Cette oeuvre ne peut être supprimée car des exemplaires y sont associés. Retour à la liste des oeuvres dans quelques instants...
			<?php goPageTimer("workDisplay.php", 5000); ?>
			<?php elseif(count($data) == 1): ?>
				<h1>Suppression d'un exemplaire</h1>
				<h3><?= $data[0]['titre'] ?></h3>
			
				<br>
				<p>
					Confirmer la suppression de cette oeuvre ?
				</p>

				<form action="workRemove.php?work=<?= $work_id ?>"
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
