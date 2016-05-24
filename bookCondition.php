<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php
	if(!isset($_GET['condition']))
	{
		goPage('index.php');
	}

	// PROCESS
	$condition = $_GET['condition'];
	$link = connectDB();

	$req = "SELECT *
			FROM EXEMPLAIRE
			NATURAL JOIN OEUVRE
			NATURAL JOIN AUTEUR
			WHERE etat LIKE '".$condition."'
			ORDER BY AUTEUR.nomAuteur, AUTEUR.prenomAuteur, OEUVRE.titre, EXEMPLAIRE.noExemplaire";

	$que = $link->query($req);
	$books = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des exemplaires en état '.$condition) ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des exemplaires en état <?= $condition ?>
			</h1>
			<p>
				Afficher la liste des livres suivant leur état :
				<?php if($condition != 'neuf'): ?>
				<a href="bookCondition.php?condition=neuf">
					neuf
				</a>-
				<?php endif; ?>
				<?php if($condition != 'bon'): ?>
				<a href="bookCondition.php?condition=bon">
					bon
				</a>-
				<?php endif; ?>
				<?php if($condition != 'moyen'): ?>
				<a href="bookCondition.php?condition=moyen">
					moyen
				</a> -
				<?php endif; ?>
				<?php if($condition != 'mauvais'): ?>
				<a href="bookCondition.php?condition=mauvais">
					mauvais
				</a>
				<?php endif; ?>
			</p>
			<?php bookByConditionDisplay($books); ?>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
