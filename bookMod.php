<?php include "include/functions.php"; ?>

<?php
if()
{
	$id = $_POST[];
	$title = $_POST[];
	$dateRelease = $_POST[];
	$authorId = $_POST[];

	$query = 'UPDATE OEUVRE
	          SET titre = \'' . $titre . \', dateParution = \'' . $dateRelease . '\', idAuteur = \'' . $authorId . '\'
	          WHERE noOeuvre = ' . $id;
}
?>

<?php include "include/header.php"; ?>
<?php include "include/menu.php"; ?>



<?php include "include/footer.php"; ?>
