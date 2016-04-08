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
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<table>
				<tr>
					<th>N° Exemplaire</th>
					<th>Titre</th>
					<th>Nom auteur</th>
					<th>Date de parution</th>
					<th>Date d'achat</th>
					<th>Etat</th>
					<th>Prix</th>
				</tr>
				<?php foreach($data as $row): ?>
					<tr>
						<td><?= $row['noExemplaire'] ?></td>
						<td><?= $row['titre'] ?></td>
						<td><?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?></td>
						<td><?= $row['dateParution'] ?></td>
						<td><?= $row['dateAchat'] ?></td>
						<td><?= $row['etat'] ?></td>
						<td><?= $row['prix'] ?></td>
						<td>
							<a href="bookRemove.php">
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
