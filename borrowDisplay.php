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
	
	$borrowsNumber = count($borrows);
	
	if($borrowsNumber > 0)
	{
		if($borrowsNumber == 1)
		{
			$text = 'Il y a un emprunt en cours :';
		}
		else
		{
			$text = 'Il y a '.$borrowsNumber.' emprunts en cours :';
		}
	}
	else
	{
		$text = 'Il n\'y a pas d\'emprunts en cours.';
	}
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
			<p>
				<?= $text ?>
			</p>
			<?php borrowDisplay($borrows); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
