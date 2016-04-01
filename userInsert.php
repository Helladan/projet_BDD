<?php include "include/header.php"; ?>
<?php include "include/menu.php"; ?>

<?php
function userInsert($surname, $address, $datePay)
{
	$query = 'INSERT INTO ADHERENT(idAdherent, nomAdherent, adresse, datePaiement)
	          VALUES(NULL, \'' . $surname . '\', \'' . $address . '\', \'' . $datePay . '\')';
}
?>

<?php include "include/footer.php"; ?>
