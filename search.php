<?php include "include/functions.php"; ?>
<?php
	// S'il n'y pas de POST search de défini, retour à la page d'accueil
	if(!isset($_POST['search']))
	{
		goPage('index.php');
	}

	$link = connectDB();

	$search = $_POST['search'];

	$etoileDebut =FALSE;
	$etoileFin = FALSE;

	if(substr($search, -1) == '*')
	{
		$etoileFin = TRUE;
	}
	if($search[0] == '*')
	{
		$etoileDebut = TRUE;
	}
	$search = trim($search, '*');

	if($etoileDebut && !$etoileFin)
	{
		$search = '^.*'.$search.'$';
	}
	else if(!$etoileDebut && $etoileFin)
	{
		$search = '^'.$search.'.*$';
	}


	/* Recherche dans la table ADHERENT */
	$req = 'SELECT * 
			FROM ADHERENT
			WHERE idAdherent REGEXP "'.$search.'" OR
				  nomAdherent REGEXP "'.$search.'" OR
				  adresse REGEXP "'.$search.'" OR
				  datePaiement REGEXP "'.$search.'"
			ORDER BY nomAdherent';

	$que = $link->query($req) or die('Erreur sur la requête, veuillez contacter l\'administrateur');

	$adherent = $que->fetchAll();

	if(count($adherent) == 0)
	{
		$adherentSearch = FALSE;
	}
	else
	{
		$adherentSearch = TRUE;
	}
	/*****************************************************************/


	// Recherche dans la table AUTEUR
	$req = 'SELECT * 
			FROM AUTEUR
			WHERE idAuteur REGEXP "'.$search.'" OR
				  nomAuteur REGEXP "'.$search.'" OR
				  prenomAuteur REGEXP "'.$search.'"
			ORDER BY nomAuteur, prenomAuteur';

	$que = $link->query($req) or die('Erreur sur la requête, veuillez contacter l\'administrateur');

	$auteur = $que->fetchAll();

	if(count($auteur) == 0)
	{
		$auteurSearch = FALSE;
	}
	else
	{
		$auteurSearch = TRUE;
	}
	/*****************************************************************/

	// Recherche dans la table EXEMPLAIRE
	$req = 'SELECT *
			FROM EXEMPLAIRE
			NATURAL JOIN OEUVRE
			NATURAL JOIN AUTEUR
			WHERE noExemplaire REGEXP "'.$search.'" OR
				  etat REGEXP "'.$search.'" OR
				  dateAchat REGEXP "'.$search.'" OR
				  titre REGEXP "'.$search.'" OR
				  nomAuteur REGEXP "'.$search.'" OR
				  prenomAuteur REGEXP "'.$search.'"
			ORDER BY AUTEUR.nomAuteur, AUTEUR.prenomAuteur, OEUVRE.titre, EXEMPLAIRE.noExemplaire';

	$que = $link->query($req) or die('Erreur sur la requête, veuillez contacter l\'administrateur');

	$exemplaire = $que->fetchAll();

	if(count($exemplaire) == 0)
	{
		$exemplaireSearch = FALSE;
	}
	else
	{
		$exemplaireSearch = TRUE;
	}
	/*****************************************************************/

	// Recherche dans la table OEUVRE
	$req = 'SELECT * 
			FROM OEUVRE
			NATURAL JOIN AUTEUR
			WHERE noOeuvre REGEXP "'.$search.'" OR 
				  titre REGEXP "'.$search.'" OR
				  dateParution REGEXP "'.$search.'" OR
				  nomAuteur REGEXP "'.$search.'" OR
				  prenomAuteur REGEXP "'.$search.'" OR
				  titre REGEXP "'.$search.'"
			ORDER BY AUTEUR.nomAuteur, AUTEUR.prenomAuteur, OEUVRE.titre, OEUVRE.dateParution';

	$que = $link->query($req) or die('Erreur sur la requête, veuillez contacter l\'administrateur');

	$oeuvre = $que->fetchAll();

	if(count($oeuvre) == 0)
	{
		$oeuvreSearch = FALSE;
	}
	else
	{
		$oeuvreSearch = TRUE;
	}
	/*****************************************************************/

	if(empty($search))
	{
		$search = 'Toute la bibliothèque';
	}
?>


<?php include "include/header.php"; ?>
<?php setPageTitle('Recherche') ?>
<?php include "include/menu.php"; ?>

<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<div class="panel">
			<p>
				Cliquez sur les labels pour afficher ou cacher les résultats de la recherche
			</p>
			<p>
				Recherche : <?= $_POST['search'] ?>
			</p>
			<ul class="accordion"
				data-accordion>
				<li class="accordion-navigation">
					<a href="#adherents">
						Adhérents
					</a>
					<div id="adherents"
						 class="content">
						<?php if($adherentSearch): // Si il y a des résultats dans la recherche d'adhérents ?>
							<table style="width: 100%; ">
								<tr>
									<th style="width: 10%; ">N° Adhérent</th>
									<th style="width: 20%; ">Nom</th>
									<th style="width: 30%; ">Adresse</th>
									<th style="width: 10%; ">Nombre d'emprunts</th>
									<th style="width: 20%; ">Date de paiement</th>
									<th style="width: 10%; "></th>
								</tr>
								<?php foreach($adherent as $row): ?>
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
						<?php else: ?>
							<p>
								Pas de résultats dans la recherche
							</p>
						<?php endif; ?>
					</div>
				</li>
				<li class="accordion-navigation">
					<a href="#auteurs">
						Auteurs
					</a>
					<div id="auteurs"
						 class="content">
						<?php if($auteurSearch): // Si il y a des résultats dans la recherche d'adhérents ?>
							<table style="width: 100%; ">
								<tr>
									<th style="width:10%; ">N° Auteur</th>
									<th style="width:40%; ">Nom</th>
									<th style="width:40%; ">Prénom</th>
									<th style="width:10%; "></th>
								</tr>
								<?php foreach($auteur as $row): ?>
									<tr>
										<td><?= $row['idAuteur'] ?></td>
										<td><?= $row['nomAuteur'] ?></td>
										<td><?= $row['prenomAuteur'] ?></td>
										<td>
											<a href="authorMod.php?author=<?= $row['idAuteur'] ?>">
												Modifier
											</a>
											<a href="authorRemove.php?author=<?= $row['idAuteur'] ?>">
												Supprimer
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</table>
						<?php else: ?>
							<p>
								Pas de résultats dans la recherche
							</p>
						<?php endif; ?>
					</div>
				</li>
				<li class="accordion-navigation">
					<a href="#exemplaires">
						Exemplaires
					</a>
					<div id="exemplaires"
						 class="content">
						<?php if($exemplaireSearch): // Si il y a des résultats dans la recherche d'adhérents ?>
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
								<?php foreach($exemplaire as $row): ?>
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
						<?php else: ?>
							<p>
								Pas de résultats dans la recherche
							</p>
						<?php endif; ?>
					</div>
				</li>
				<li class="accordion-navigation">
					<a href="#oeuvres">
						Oeuvres
					</a>
					<div id="oeuvres"
						 class="content">
						<?php if($oeuvreSearch): // Si il y a des résultats dans la recherche d'adhérents ?>
							<table style="width: 100%;">
								<tr>
									<th style="width: 10%; ">N° Oeuvre</th>
									<th style="width: 40%; ">Titre</th>
									<th style="width: 30%; ">Nom auteur</th>
									<th style="width: 10%; ">Date de parution</th>
									<th style="width: 10%; "></th>
								</tr>
								<?php foreach($oeuvre as $row): ?>
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
						<?php else: ?>
							<p>
								Pas de résultats dans la recherche
							</p>
						<?php endif; ?>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<?php include "include/footer.php"; ?>
