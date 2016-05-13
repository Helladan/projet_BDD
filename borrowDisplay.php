<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php // PROCESS
	$link = connectDB();
	
	$req = 'SELECT *
			FROM EMPRUNT
			NATURAL JOIN ADHERENT
			NATURAL JOIN EXEMPLAIRE
			INNER JOIN OEUVRE
			INNER JOIN AUTEUR
			WHERE EXEMPLAIRE.noOeuvre = OEUVRE.noOeuvre AND 
				  OEUVRE.idAuteur = AUTEUR.idAuteur AND
				  EMPRUNT.dateRendu IS NULL 
			ORDER BY EMPRUNT.dateEmprunt';
	
	$que = $link->query($req);
	$borrows = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des emprunts en cours') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des emprunts en cours
			</h1>
			<?php borrowDisplay($borrows); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
