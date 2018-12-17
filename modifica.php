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
			<input type="button" class="menubuttons" onclick="document.location='admin.php'" value="Amministrazione"></input>
			<input type="button" class="menubuttons" onclick="document.location='cerca.php'" value="Modifica articoli"></input>
		</div>
    
		<div id="contents" class="content">
			
			<form method="post" action="modifica.php">
			
			<?php
			
			/*k è la chiave identificativa dell'articolo*/
			if(isset($_POST['k'])){
				$k=$_POST['k'];
			}else if (isset($_GET['k'])){
				$k=$_GET['k'];
			}
			if (isset($_GET["elimina"])){
				$canc=mysql_query("DELETE FROM articolo WHERE articolo.key='".$k."'");
				if($canc===FALSE){
					die(mysql_error());
				}else 
					header("location:cerca.php");
			}else{
				$art="SELECT * FROM articolo WHERE articolo.key='".$k."'";
				$articolo=mysql_query($art);
				if($articolo===FALSE){
					die(mysql_error());
				}
				$testo=mysql_fetch_array($articolo);
				/*disegno i campi di testo con all'interno il risultato della query*/
				echo"<input type=\"text\" value=\"".$testo['titolo']."\" name=\"titolo\" class=\"text\"></input>";
				echo"<input type=\"text\" value=\"".$testo['sottotitolo']."\" name=\"sottotitolo\" class=\"text\"></input>";
				echo"<textarea class=\"widetext\" name=\"testo\">".$testo['testo']."</textarea></br>";
				echo"<input type=\"hidden\" value=\"".$k."\" name=\"k\"></input>";
				/*controllo che non siano vuoti i campi*/
				if(isset($_POST['titolo'])&&isset($_POST['sottotitolo'])&&isset($_POST['testo'])&&($_POST['titolo']!="")&&($_POST['sottotitolo']!="")&&($_POST['testo']!="")){
					/*eseguo l'aggiornamento dei campi modificati*/
					/*rimuovo opportunamente il problema degli apostrofi*/
					$_POST['titolo']= str_replace("'", "''", $_POST['titolo']);
					$_POST['sottotitolo']= str_replace("'", "''", $_POST['sottotitolo']);
					$_POST['testo']= str_replace("'", "''", $_POST['testo']);
					$ins="UPDATE articolo SET titolo='".$_POST['titolo']."', sottotitolo='".$_POST['sottotitolo']."', testo='".$_POST['testo']."', modifica=now() WHERE articolo.key='".$k."'";
					$inser=mysql_query($ins);
					if($inser===FALSE){
						die(mysql_error());
					}else echo"<h4>Articolo modificato correttamente</h4>";
				}
				
				echo"<input type=\"submit\" value=\"Conferma modifiche\" class=\"button\"></input>";
				echo"<input type=\"button\" value=\"Cercane un altro\" class=\"button\" onclick=\"document.location='cerca.php'\"></input>";
				echo"<input type=\"button\" value=\"Elimina articolo\" class=\"button\" onclick=\"document.location='modifica.php?k=$k&elimina=1'\"></input>";
				session_destroy();
			}
			?>
			
			</form>
		</div>
	</body>
</html>