<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php
	if(!isset($_GET['idAuteur']))
	{
		goPage('index.php');
	}

	// PROCESS
	$idAuteur =$_GET['idAuteur'];

	$link = connectDB();

	$req = "SELECT OEUVRE.noOeuvre, OEUVRE.titre, OEUVRE.dateParution,
				   AUTEUR.nomAuteur, AUTEUR.prenomAuteur
			FROM OEUVRE
			NATURAL JOIN AUTEUR
			WHERE idAuteur=".$idAuteur."
			ORDER BY OEUVRE.titre, OEUVRE.dateParution";

	$que = $link->query($req);
	$works = $que->fetchAll();

	$req = "SELECT *
			FROM AUTEUR
			WHERE idAuteur=".$idAuteur;

	$que = $link->query($req);
	$auteur = $que->fetch();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des oeuvres') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel" style="overflow: auto;">
			<h1>
				Liste des oeuvres de <?= $auteur['prenomAuteur'].' '.$auteur['nomAuteur'] ?>
			</h1>
			<?php workByAuthorDisplay($works) ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
