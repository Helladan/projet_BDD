<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT EXEMPLAIRE.noExemplaire, EXEMPLAIRE.etat, EXEMPLAIRE.dateAchat, EXEMPLAIRE.prix,
				   OEUVRE.titre, OEUVRE.dateParution,
				   AUTEUR.nomAuteur, AUTEUR.prenomAuteur
			FROM EXEMPLAIRE
			NATURAL JOIN OEUVRE
			NATURAL JOIN AUTEUR
			ORDER BY AUTEUR.nomAuteur, AUTEUR.prenomAuteur, OEUVRE.titre, EXEMPLAIRE.noExemplaire';

	$que = $link->query($req);
	$books = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des exemplaires') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des exemplaires
			</h1>
			<?php bookDisplay($books); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
