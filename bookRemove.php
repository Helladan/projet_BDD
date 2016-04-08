<?php include "include/functions.php"; ?>

<?php
if()
{
	$id = $_POST[];

	$query = 'DELETE FROM OEUVRE
	          WHERE noOeuvre = ' . $id;
}
?>

<?php include "include/header.php"; ?>
<?php setPageTitle('Suppression d\'exemplaire')?>
<?php include "include/menu.php"; ?>



<?php include "include/footer.php"; ?>
