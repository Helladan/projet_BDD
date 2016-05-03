<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT idAdherent, nomAdherent, adresse, datePaiement
			FROM ADHERENT
			ORDER BY nomAdherent';

	$que = $link->query($req);
	$users = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des adhérents') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des adhérents
			</h1>
			<?php userDisplay($users); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
