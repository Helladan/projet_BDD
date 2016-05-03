<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT idAuteur, nomAuteur, prenomAuteur
			FROM AUTEUR
			ORDER BY nomAuteur, prenomAuteur';

	$que = $link->query($req);
	$authors = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des auteurs') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des auteurs
			</h1>
			<?php authorDisplay($authors); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
