<?php
if()
{
	$title = $_POST[];
	$dateRelease = $_POST[];
	$authorId = $_POST[];

	$query = 'INSERT INTO OEUVRE(noOeuvre, titre, dateParution, idAuteur)
	          VALUES(NULL, \'' . $title . '\', \'' . $dateRelease . '\', \'' . $authorId . '\')';
}
?>

<?php include "include/header.php"; ?>
<?php include "include/menu.php"; ?>



<?php include "include/footer.php"; ?>
