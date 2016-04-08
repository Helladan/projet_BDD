<?php include "include/functions.php"; ?>

<?php
if()
{
	$surname = $_POST[];
	$address = $_POST[];
	$datePay = $_P0ST[];

	$query = 'INSERT INTO ADHERENT(idAdherent, nomAdherent, adresse, datePaiement)
	          VALUES(NULL, \'' . $surname . '\', \'' . $address . '\', \'' . $datePay . '\')';
}
?>

<?php setPageTitle('Ajout d\'utilisateur')?>
<?php include "include/header.php"; ?>
<?php include "include/menu.php"; ?>


<?php include "include/footer.php"; ?>
