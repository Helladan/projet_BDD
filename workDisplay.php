<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT OEUVRE.noOeuvre, OEUVRE.titre, OEUVRE.dateParution,
				   AUTEUR.nomAuteur, AUTEUR.prenomAuteur
			FROM OEUVRE
			NATURAL JOIN AUTEUR
			ORDER BY AUTEUR.nomAuteur, AUTEUR.prenomAuteur, OEUVRE.titre, OEUVRE.dateParution';

	$que = $link->query($req);
	$data = $que->fetchAll();
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
			<table style="width: 100%;">
				<tr>
					<th style="width: 10%; ">N° Oeuvre</th>
					<th style="width: 40%; ">Titre</th>
					<th style="width: 30%; ">Nom auteur</th>
					<th style="width: 10%; ">Date de parution</th>
					<th style="width: 10%; "></th>
				</tr>
				<?php foreach($data as $row): ?>
					<tr>
						<td><?= $row['noOeuvre'] ?></td>
						<td><?= $row['titre'] ?></td>
						<td><?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?></td>
						<td><?= date('d/m/Y', strtotime($row['dateParution'])) ?></td>
						<td>
							<a href="workMod.php?work=<?= $row['noOeuvre'] ?>">
								Modifier
							</a>
							<a href="workRemove.php?work=<?= $row['noOeuvre'] ?>">
								Supprimer
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
