<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT idAuteur, nomAuteur, prenomAuteur
			FROM AUTEUR
			ORDER BY nomAuteur, prenomAuteur';

	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des auteurs') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<table>
				<tr>
					<th width="10%">N° Auteur</th>
					<th width="40%">Nom</th>
					<th width="40%">Prénom</th>
					<th width="10%"></th>
				</tr>
				<?php foreach($data as $row): ?>
					<tr>
						<td><?= $row['idAuteur'] ?></td>
						<td><?= $row['nomAuteur'] ?></td>
						<td><?= $row['prenomAuteur'] ?></td>
						<td>
							<a href="authorMod.php?author=<?= $row['noExemplaire'] ?>">
								Modifier
							</a>
							<a href="authorRemove.php?author=<?= $row['noExemplaire'] ?>">
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
