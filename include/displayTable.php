<?php
	function authorDisplay($authors)
	{
		$link = connectDB();
		?>
		<table style="width: 100%; ">
			<tr>
				<th style="width: 10%; ">N° Auteur</th>
				<th style="width: 35%; ">Nom</th>
				<th style="width: 35%; ">Prénom</th>
				<th style="width: 10%">Nombre d'oeuvres</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($authors as $row):

				$req = "SELECT *
						FROM OEUVRE
						WHERE OEUVRE.idAuteur=".$row['idAuteur'];

				$que = $link->query($req);
				$numWorks = $que->rowCount();
				?>
				<tr>
					<td><?= $row["idAuteur"] ?></td>
					<td>
						<a href="workByAuthor.php?idAuteur=<?= $row['idAuteur'] ?>">
							<?= $row["nomAuteur"] ?>
						</a>
					</td>
					<td><?= $row["prenomAuteur"] ?></td>
					<td><?= $numWorks ?></td>
					<td>
						<a href="authorMod.php?author=<?= $row["idAuteur"] ?>">
							Modifier
						</a>
						<a href="authorRemove.php?author=<?= $row["idAuteur"] ?>">
							Supprimer
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>';
		<?php
	}
	
	function bookDisplay($books)
	{ ?>
		<table style="width: 100%; ">
			<tr>
				<th style="width: 10%; ">N° Exemplaire</th>
				<th style="width: 10%; ">Titre</th>
				<th style="width: 14%; ">Nom auteur</th>
				<th style="width: 13%; ">Date de parution</th>
				<th style="width: 13%; ">Date d'achat</th>
				<th style="width: 10%; ">Etat</th>
				<th style="width: 10%; ">Prix</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($books as $row): ?>
				<tr>
					<td><?= $row['noExemplaire'] ?></td>
					<td><?= $row['titre'] ?></td>
					<td>
						<a href="workByAuthor.php?idAuteur=<?= $row['idAuteur'] ?>">
							<?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?>
						</a>
					</td>
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
		<?php
	}

	function bookByConditionDisplay($books)
	{ ?>
		<table style="width: 100%; ">
			<tr>
				<th style="width: 10%; ">N° Exemplaire</th>
				<th style="width: 45%; ">Titre</th>
				<th style="width: 35%; ">Nom auteur</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($books as $row): ?>
				<tr>
					<td><?= $row['noExemplaire'] ?></td>
					<td><?= $row['titre'] ?></td>
					<td><?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?></td>
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
		<?php
	}

	function userDisplay($users)
	{
		$link = connectDB();
		?>
		<table style="width: 100%; ">
			<tr>
				<th style="width: 10%; ">N° Adhérent</th>
				<th style="width: 20%; ">Nom</th>
				<th style="width: 30%; ">Adresse</th>
				<th style="width: 10%; ">Nombre d'emprunts</th>
				<th style="width: 20%; ">Date de paiement</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($users as $row): ?>
				<?php
				// Requete pour savoir le nombre d'emprunts de l'adhérent
				$req = 'SELECT * 
						FROM EMPRUNT
						WHERE idAdherent = '.$row['idAdherent'];
				
				$que = $link->query($req);
				
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
		<?php
	}
	
	function workDisplay($works)
	{
		$link = connectDB();
		?>
		<table style="width: 100%;">
			<tr>
				<th style="width: 10%; ">N° Oeuvre</th>
				<th style="width: 35%; ">Titre</th>
				<th style="width: 25%; ">Nom auteur</th>
				<th style="width: 10%; ">Date de parution</th>
				<th style="width: 10%">Nombre d'exemplaires</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($works as $row):

				$req = "SELECT *
					    FROM EXEMPLAIRE
					    WHERE EXEMPLAIRE.noOeuvre=".$row['noOeuvre'];

				$que = $link->query($req);
				$numbBooks = $que->rowCount();
				?>
				<tr>
					<td><?= $row['noOeuvre'] ?></td>
					<td><?= $row['titre'] ?></td>
					<td>
						<a href="workByAuthor.php?idAuteur=<?= $row['idAuteur'] ?>">
							<?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?>
						</a>
					</td>
					<td><?= date('d/m/Y', strtotime($row['dateParution'])) ?></td>
					<td><?= $numbBooks ?></td>
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
		<?php
	}
	
	function workByAuthorDisplay($works)
	{
		$link = connectDB();
		?>
		<table style="width: 100%;">
			<tr>
				<th style="width: 10%; ">N° Oeuvre</th>
				<th style="width: 50%; ">Titre</th>
				<th style="width: 20%; ">Date de parution</th>
				<th style="width: 10%">Nombre d'exemplaires</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($works as $row):
				
				$req = "SELECT *
					    FROM EXEMPLAIRE
					    WHERE EXEMPLAIRE.noOeuvre=".$row['noOeuvre'];
				
				$que = $link->query($req);
				$numbBooks = $que->rowCount();
				?>
				<tr>
					<td><?= $row['noOeuvre'] ?></td>
					<td><?= $row['titre'] ?></td>
					<td><?= date('d/m/Y', strtotime($row['dateParution'])) ?></td>
					<td><?= $numbBooks ?></td>
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
		<?php
	}

	function borrowDisplay($borrows)
	{ ?>
		<table style="width: 100%; ">
			<tr>
				<th style="width: 10%; ">N° Exemplaire</th>
				<th style="width: 30%; ">Titre</th>
				<th style="width: 20%; ">Nom de l'auteur</th>
				<th style="width: 20%; ">Nom de l'adhérent</th>
				<th style="width: 10%; ">Date d'emprunt</th>
				<th style="width: 10%; ">Jours d'emprunt</th>
				<th style="width: 10%; "></th>
			</tr>
			<?php foreach($borrows as $row):
				$dateDiff = date_diff(date_create($row['dateEmprunt']),
									  date_create(date('Y/m/d')));
				$diffDay = $dateDiff->format('%a');

				if($diffDay > 45)
				{
					$notOK = 'style = "background-color : #f94d4d; 
									   font-weight: bold; "';
				}
				else
				{
					$notOK = "";
				}

				$idEmprunt = $row['noExemplaire'].'_'.$row['idAdherent'].'_'.$row['dateEmprunt']
				?>
				<tr>
					<td><?= $row['noExemplaire'] ?></td>
					<td><?= $row['titre'] ?></td>
					<td><?= $row['nomAuteur'] ?>, <?= $row['prenomAuteur'] ?></td>
					<td><?= $row['nomAdherent'] ?></td>
					<td><?= date('d/m/Y', strtotime($row['dateEmprunt'])) ?></td>
					<td <?= $notOK ?> ><?= $diffDay ?></td>
					<td>
						<a href="borrowReturn.php?idAdherent=<?= $row['idAdherent'] ?>&noExemplaire=<?= $row['noExemplaire'] ?>&dateEmprunt=<?= $row['dateEmprunt'] ?>">
							Rendre
						</a>
						<a href="borrowRemove.php?idAdherent=<?= $row['idAdherent'] ?>&noExemplaire=<?= $row['noExemplaire'] ?>&dateEmprunt=<?= $row['dateEmprunt'] ?>">
							Supprimer
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php
	}
