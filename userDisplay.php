<?php include "include/functions.php"; ?>

<?php // PROCESS
	$link = connectDB();

	$req = 'SELECT idAdherent, nomAdherent, adresse, datePaiement
			FROM ADHERENT
			ORDER BY nomAdherent';

	$que = $link->query($req);
	$data = $que->fetchAll();
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Liste des adhérents') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<h1>
				Liste des adhérents
			</h1>
			<table style="width: 100%; ">
				<tr>
					<th style="width: 10%; ">N° Adhérent</th>
					<th style="width: 20%; ">Nom</th>
					<th style="width: 30%; ">Adresse</th>
					<th style="width: 10%; ">Nombre d'emprunts</th>
					<th style="width: 20%; ">Date de paiement</th>
					<th style="width: 10%; "></th>
				</tr>
				<?php foreach($data as $row): ?>
					<?php
					// Requete pour savoir le nombre d'emprunts de l'adhérent
					$req = 'SELECT * 
							FROM EMPRUNT
							WHERE idAdherent = '.$row['idAdherent'];

					$que = $link -> query($req);

					$nbLine = count($que->fetchAll());
					?>
					<tr>
						<td><?= $row['idAdherent'] ?></td>
						<td><?= $row['nomAdherent'] ?></td>
						<td><?= $row['adresse'] ?></td>
						<td><?= $nbLine ?></td>
						<td><?= date('d/m/Y', strtotime($row['datePaiement'])) ?></td>
						<td>
							<a href="userMod.php?user=<?= $row['idAdherent'] ?>">
								Modifier
							</a>
							<a href="userRemove.php?user=<?= $row['idAdherent'] ?>">
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
