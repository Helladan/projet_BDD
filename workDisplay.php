<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT OEUVRE.noOeuvre, OEUVRE.titre, OEUVRE.dateParution,
				   AUTEUR.nomAuteur, AUTEUR.prenomAuteur
			FROM OEUVRE
			NATURAL JOIN AUTEUR
			ORDER BY AUTEUR.nomAuteur, AUTEUR.prenomAuteur, OEUVRE.titre, OEUVRE.dateParution';

	$que = $link->query($req);
	$works = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des oeuvres') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel" style="overflow: auto;">
			<h1>
				Liste des oeuvres
			</h1>
			<?php workDisplay($works) ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
