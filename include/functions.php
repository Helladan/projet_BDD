<?php
	function connectDB()
	{
		include(realpath('.').'../../config_BDD.php');

		$dsn = 'mysql:dbname='.$base.';host='.$host.';charset=utf8';
		
		try
		{
			$link = new PDO($dsn, $user, $pwd);
			
			// Pour afficher les erreurs
			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			// Pour récuperer le résultat des requêtes SELECT sous forme de tableaux associatifs
			$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			
		}
		catch(PDOException $e)
		{
			die('Connexion échouée : '.$e->getMessage());
		}
		
		return $link;
	}
	
	function setPageTitle($title)
	{		
		echo '
        <script type="text/javascript">
            document.title = "'.$title.'";
        </script>';
	}

	// Go to indicate page - NO TIMER
	function goPage($url)
	{
		echo "
		<script type=text/javascript>window.location.replace('".$url."');</script>;
		";
	}

	// Go to indicate page  - ON TIMER
	function goPageTimer($url, $timer)
	{
		echo '
		<script type="text/javascript">window.setTimeout("location=(\''.$url.'\');",'.$timer.');</script>
		';
	}
