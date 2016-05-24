<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php 
	if(!isset($_GET['noOeuvre']))
	{
		goPage('index.php');
	}
	
	$noOeuvre = $_GET['noOeuvre'];
	
	// PROCESS
	$link = connectDB();
	
	$req = "SELECT *
			FROM EXEMPLAIRE
			NATURAL JOIN OEUVRE
			NATURAL JOIN AUTEUR
			WHERE EXEMPLAIRE.noOeuvre = ".$noOeuvre."
			ORDER BY EXEMPLAIRE.noExemplaire";
	
	$que = $link->query($req);
	$books = $que->fetchAll();
	
	$req = "SELECT OEUVRE.titre
			FROM OEUVRE
			WHERE noOeuvre = ".$noOeuvre;
	
	$que = $link->query($req);
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des exemplaires') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des exemplaires de l'oeuvre <?= $oeuvre ?>
			</h1>
			<p>
				Afficher la liste des livres suivant leur état :
				<a href="bookCondition.php?condition=neuf">
					neuf
				</a>-
				<a href="bookCondition.php?condition=bon">
					bon
				</a>-
				<a href="bookCondition.php?condition=moyen">
					moyen
				</a>-
				<a href="bookCondition.php?condition=mauvais">
					mauvais
				</a>
			</p>
			<?php bookDisplay($books); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
