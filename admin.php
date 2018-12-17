<?php
	/*comincia la sessione*/
	session_start();
	if(!($database=mysql_connect("localhost", "root", "acdc")))die ("Non è stato possibile connettersi al DB");
		mysql_select_db("crearte");
		/*controllo se l'utente è già loggato, se si ricerco la sua sessionid nel db*/
	if(isset($_COOKIE['crearte_admin'])){
		$c="SELECT * FROM autore WHERE autore.id='".$_COOKIE['crearte_admin']."'";
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
		<script src="jquery.js"></script>
	</head>
	<body>
    	<div id="header" class="header">
			<a href="home.html"><img src="immagini/logo.png" width=100%></img></a>
        </div>
        
		<div id="leftmenu" class="menu">
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=home'" value="Home"></input>
			<input type="button" class="menubuttons" onclick="document.location='cerca.php'" value="Modifica Articoli"></input>
			<input type="button" class="menubuttons" onclick="document.location='file.php'" value="Carica immagine"></input>
		</div>
    
		<div id="contents" class="content">
			<form method="post" action="admin.php">
			<input type="text" value="Titolo" name="titolo" class="text"></input>
			
			<?php
				if(isset($_POST['titolo'])){
					if($_POST['titolo']==""||$_POST['titolo']=="Titolo"){echo"<h5>Inserisci un titolo!</h5>";}
				}
			?>
			
			<input type="text" value="Sottotitolo" name="sottotitolo" class="text"></input>
			
			<?php
				if(isset($_POST['sottotitolo'])){
					if($_POST['sottotitolo']==""||$_POST['sottotitolo']=="Sottotitolo"){echo"<h5>Inserisci un sottotitolo!</h5>";}
				}
			?>
			
			<textarea class="widetext" name="testo">Inserisci qui il testo</textarea></br>
			
			<?php
				if(isset($_POST['testo'])){
					if($_POST['testo']==""||$_POST['testo']=="Inserisci qui il testo"){echo"<h5>Inserisci un testo!</h5>";}
				}
			?>

			<?php
				/*controllo che i dati siano stati inseriti e li invio al database*/
				if(isset($_POST['titolo'])&&isset($_POST['testo'])&&(isset($_POST['sottotitolo']))&&($_POST['titolo']!='Titolo')&&($_POST['testo']!='Inserisci qui il testo')&&($_POST['sottotitolo']!="Sottotitolo")){
					/*rimuovo opportunamente il problema degli apostrofi*/
					$_POST['titolo']= str_replace("'", "''", $_POST['titolo']);
					$_POST['sottotitolo']= str_replace("'", "''", $_POST['sottotitolo']);
					$_POST['testo']= str_replace("'", "''", $_POST['testo']);
					$ins="INSERT INTO articolo (titolo, data, autore, sottotitolo, testo, immagine, modifica) VALUES ('".$_POST['titolo']."', now() , '".$num['id']."', '".$_POST['sottotitolo']."', '".$_POST['testo']."', NULL, NULL)";
					$inser=mysql_query($ins);
					if($inser===FALSE){
						die(mysql_error());
					}else echo"<h4>Contenuto pubblicato correttamente</h4>";
				}
				session_destroy();
			?>
			<input type="submit" value="Pubblica" class="button"></input>
			
			</form>
		</div>
	</body>
</html>