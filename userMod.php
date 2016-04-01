<?php
if()
{
	$id = $_POST[]
	$surname = $_POST[];
	$address = $_POST[];
	$datePay = $_POST[];

	$query = 'UPDATE ADHERENT
	          SET nomAdherent = \'' .. $surname '\', adresse = \'' . $address . '\', datePaiement = \'' . $datePay . '\'
	          WHERE idAdherent = ' . $id;
}
?>

<?php include "include/header.php"; ?>
<?php include "include/menu.php"; ?>

<?php include "include/footer.php"; ?>
