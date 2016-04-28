<?php include "include/functions.php"; ?>

<?php // PROCESS
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	$link = connectDB();

	if(isset($_POST['del_author']))
	{
		if($_POST['del_author'] == 'Oui')
		{
			$req = 'DELETE FROM AUTEUR
			        WHERE idAuteur = ' . $_GET['author'];

			$link->exec($req);
		}

		header('Location: ./authorDisplay.php');
	}

	$req = 'SELECT nomAuteur, prenomAuteur
	        FROM AUTEUR
	        WHERE idAuteur = ' . $_GET['author'];

	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'un Autheur')?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<?php foreach($data as $row): ?>
				<h3><?= $row['nomAuteur'] . ' ' . $row['prenomAuteur']?></h3>

				<br />

				<h5>Confirmer la suppression de cet auteur ?</h5>

				<form action="authorRemove.php?author=<?= $_GET['author'] ?>" method="POST">
					<input type="submit" name="del_author" value="Oui" />
					<input type="submit" name="del_author" value="Non" />
				</form>

			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
