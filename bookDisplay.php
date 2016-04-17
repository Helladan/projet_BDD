<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT ex.noExemplaire, ex.etat, ex.dateAchat, ex.prix,
				   oe.titre, oe.dateParution,
				   au.nomAuteur, au.prenomAuteur
			FROM EXEMPLAIRE ex
			NATURAL JOIN OEUVRE oe
			NATURAL JOIN AUTEUR au
			ORDER BY noExemplaire';

	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des exemplaires') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<table>
				<tr>
					<th width="10%">N° Exemplaire</th>
					<th width="10%">Titre</th>
					<th width="14%">Nom auteur</th>
					<th width="13%">Date de parution</th>
					<th width="13%">Date d'achat</th>
					<th width="10%">Etat</th>
					<th width="10%">Prix</th>
					<th width="10%"></th>
				</tr>
				<?php foreach($data as $row): ?>
					<tr>
						<td><?= $row['noExemplaire'] ?></td>
						<td><?= $row['titre'] ?></td>
						<td><?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?></td>
						<td><?= date('d/m/Y', strtotime($row['dateParution'])) ?></td>
						<td><?= date('d/m/Y', strtotime($row['dateAchat'])) ?></td>
						<td><?= $row['etat'] ?></td>
						<td><?= $row['prix'] ?></td>
						<td>
							<a href="bookMod.php?book=<?= $row['noExemplaire'] ?>">
								Modifier
							</a>
							<a href="bookRemove.php?book=<?= $row['noExemplaire'] ?>">
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
