<?php include "include/functions.php"; ?>

<?php
if()
{
	$id = $_POST[];

	$query = 'DELETE FROM ADHERENT
	          WHERE idAdherent = ' . $id;
}
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'utilisateur')?>
<?php include "include/menu.php"; ?>

<?php include "include/footer.php"; ?>
