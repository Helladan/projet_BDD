<?php include "include/functions.php"; ?>
<?php include "include/displayTable.php"; ?>

<?php
	// S'il n'y pas de POST search de défini, retour à la page d'accueil
	if(!isset($_POST['search']))
	{
		goPage('index.php');
	}

	$link = connectDB();

	$search = $_POST['search'];

	$etoileDebut = FALSE;
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
	else
	{
		if(!$etoileDebut && $etoileFin)
		{
			$search = '^'.$search.'.*$';
		}
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

	$users = $que->fetchAll();

	if(count($users) == 0)
	{
		$usersSearch = FALSE;
	}
	else
	{
		$usersSearch = TRUE;
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

	$authors = $que->fetchAll();

	if(count($authors) == 0)
	{
		$authorsSearch = FALSE;
	}
	else
	{
		$authorsSearch = TRUE;
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

	$books = $que->fetchAll();

	if(count($books) == 0)
	{
		$booksSearch = FALSE;
	}
	else
	{
		$booksSearch = TRUE;
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

	$works = $que->fetchAll();

	if(count($works) == 0)
	{
		$worksSearch = FALSE;
	}
	else
	{
		$worksSearch = TRUE;
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
						<?php if($usersSearch): // Si il y a des résultats dans la recherche d'adhérents
							userDisplay($users);
						else: ?>
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
						<?php if($authorsSearch): // Si il y a des résultats dans la recherche d'adhérents

							authorDisplay($authors);
						else: ?>
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
						<?php if($booksSearch): // Si il y a des résultats dans la recherche d'adhérents
							bookDisplay($books);
						else: ?>
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
						<?php if($worksSearch): // Si il y a des résultats dans la recherche d'adhérents
							workDisplay($works);
						else: ?>
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
