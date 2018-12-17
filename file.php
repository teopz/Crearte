<?php
	/*comincia la sessione*/
	session_start();
	if(!($database=mysql_connect("localhost", "root", "acdc")))die ("Non è stato possibile connettersi al DB");
		mysql_select_db("crearte");
		/*controllo se l'utente è già loggato, se si ricerco la sua sessionid nel db*/
		if(isset($_COOKIE['crearte_admin'])){
		$c="SELECT autore.sessione FROM autore WHERE autore.id='".$_COOKIE['crearte_admin']."'";
		$cookie=mysql_query($c);
		if($cookie===FALSE){
			die(mysql_error());
		}
		$num=mysql_fetch_array($cookie);
		/*confronto la sessionid dell'utente con quella attuale, se combaciano l'utente prosegue, altrimenti deve loggarsi*/
		if ($num['sessione']==$_COOKIE['PHPSESSID']){}else header("Location:login.php");
	}else header("Location:login.php");
?>

<html>
	<head>
		<title>Crearte</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" title="style" href="style.css" />
	</head>
	<body>
    	<div id="header" class="header">
			<a href="home.html"><img src="immagini/logo.png" width=100%></img></a>
        </div>
		<div id="leftmenu" class="menu">
		<input type="button" class="menubuttons" onclick="document.location='content.php?item=home'" value="Home"></input>
		<input type="button" class="menubuttons" onclick="document.location='cerca.php'" value="Modifica Articoli"></input>

		<?php 
			//lista cartelle disponibili
			echo "<h4>Cartelle disponibili:</h4><h4>";
			foreach ( glob("galleria/*", GLOB_ONLYDIR) as $cartella){
				echo $cartella."</br>";
			}
			echo "</h4></div>";
		?>
		<div id="contents" class="content">
		<h4 class="center">Cartella di destinazione:</br>
			<form method="post" action="file.php" enctype="multipart/form-data">
			<input type="text" class="text" value="galleria/" name="destinazione"></input>
			<input type="submit" class="button" name="crea" value="crea"></input>
		</h4>
		</br>
		
		<?php
			/*caricamento di un file*/
			if (isset($_POST['crea'])){
				if (isset($_POST['destinazione'])){
					if(file_exists($_POST['destinazione'])){
						echo "<h5>La cartella esiste già</h5>";
					}else if($_POST['destinazione']=""){
						echo "<h5>Impossibile creare una cartella senza nome</h5>";
					}else {	
						$oldmask = umask(0);
						if (mkdir($_POST['destinazione'],0777,true)){
							echo "<h4>Cartella creata correttamente</h4>";
						}else {
							echo "<h5>Impossibile creare la cartella</h5>".$_POST['destinazione'];
						}
						umask($oldmask);
					}
				} else echo "<h5>Inserire un percorso per la nuova cartella<7h5>";
			}
			if (isset($_FILES["file"]) and !isset($_POST['crea'])){
				if (isset($_POST['destinazione'])){
					if (is_dir($_POST['destinazione'])){
						$dest=$_POST['destinazione'];
					}else {
						echo "<h5>La cartella selezionata non esiste</h5>";
						$dest="";
					}
				}else $dest="galleria/";
				if ($dest!=""){
					if ($_FILES["file"]["error"] > 0){
						echo "<h5>File non trasferito, errore: " . $_FILES["file"]["error"] . "</h5>";
					}
					else if (file_exists($dest.$_FILES["file"]["name"])){
						echo "<h5>".$_FILES["file"]["name"] . " esiste già.</h5>";
					}else if(move_uploaded_file($_FILES["file"]["tmp_name"],$dest.$_FILES["file"]["name"])){
						echo "<h4 class=\"center\">File traferito</h4>";
					} else echo "<h5>File non trasferito, errore: ".$_FILES["file"]["error"]."</h5>";
					//echo $dest.$_FILES["file"]["name"];
				}
			}
			session_destroy();
			?>
		<h4 class="center"><input type="file" name="file" id="file" multiple="multiple"></input></br>
		<input type="submit" value="Carica" class="button"></input>
		</h4>
		</div>
	</body>
</html>