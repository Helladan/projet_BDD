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
			header('Location: ./workDisplay.php');
		
		$delete = TRUE;
	}
	
	$work_id = $_GET['work'];
	
	$req = 'SELECT titre
	        FROM OEUVRE
	        WHERE noOeuvre = '.$work_id;
	
	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'une oeuvre') ?>
<?php include "include/menu.php"; ?>

<?php if(isset($delete) && $delete): ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 solumns">
			<div class="panel">
				L'oeuvre a étée supprimée. Vous allez être redirigé dans un instant ...
			<div>
		</div>
	</div>

<?php goPageTimer('workDisplay.php', 3000); ?>

<?php else: ?>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<div class="panel">
				<?php if(count($data) == 1): ?>
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
<?php endif; ?>
<?php include "include/footer.php"; ?>
