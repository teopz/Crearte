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
		
			<form method="post" action="cerca.php">
			<h4>Inserisci le parole chiave:</h4>
			<input type="text"  name="keywords" class="text"></input>
			<?php
				if(isset($_POST['keywords'])){
					if($_POST['keywords']==""){echo"<h5>Inserisci almeno una parola chiave!</h5>";}
				}
			?>	
			
			<?php
			echo"</br><input type=\"submit\" value=\"Cerca\" class=\"button\"></input>";
			echo"</form>";
			
			if (!isset($_POST['keywords'])){
			echo "<h4>Tutti gli articoli</h4>";
			$ev="SELECT * FROM articolo ORDER BY data DESC";
				$even=mysql_query($ev);
				if($even===FALSE){
					die(mysql_error());
				}
				while($eventi=mysql_fetch_array($even)){
					$kart=$eventi['key'];
					//volendo aggiungere la possibilità di modificare articoli da qui decommentare e aggiungere il link sul titolo
					echo "<a href=\"modifica.php?k=$kart\"><h2>".$eventi['titolo']."</h2></a>";
					echo $eventi['sottotitolo']."</br>";
					echo $eventi['testo'] ;
					echo"<br/><input type=\"button\" value=\"Elimina\" class=\"button\" onclick=\"document.location='modifica.php?k=$kart&elimina=1'\"></input>";
				}
			}
			
			
				if(isset($_POST['keywords'])&&($_POST['keywords']!="")){
					$_POST['keywords']= str_replace("'", "''", $_POST['keywords']);
					/*creazione di un pattern di ricerca per la query*/
					$spazio=" ";
					$sost="%' AND testo LIKE '%";
					$key=str_replace($spazio, $sost, $_POST['keywords']); /*sostituisco gli spazi con AND*/
					$cerca="SELECT * FROM articolo WHERE articolo.testo LIKE '%".$key."%'";
					$cerca_art=mysql_query($cerca);
					if($cerca_art===FALSE){
						die(mysql_error());
					}else $display_art=mysql_fetch_array($cerca_art);
					/*se non ho trovato nulla avviso, se no stampo i risultati*/
					if ($display_art['titolo']==""){ 
						echo"<h5>Non sono stati trovati articoli contenenti le parole '".$_POST['keywords']."'</h5>";
					}else {
						echo"<form method=\"post\" action=\"modifica.php\">";
						/*stampa del primo elemento trovato*/
						$k=$display_art['key'];
						echo "<h2>".$display_art['titolo']."<input type=\"submit\" value=\"Modifica\" class=\"button\"></input></h2>";
						echo"<input type=\"hidden\" name=\"k\" value=\"$k\"></input>";
						echo "</h4>".$display_art['sottotitolo']."</h4></br>";
						echo "</h4>".$display_art['testo']."</h4>";
						echo "</br>";
						/*stampa dei successivi elementi trovati*/
						while($display_art=mysql_fetch_array($cerca_art)){
							$k=$display_art['key'];
							echo "<h2>".$display_art['titolo']."<input type=\"submit\" value=\"Modifica\" class=\"button\"></input></h2>";
							echo"<input type=\"hidden\" name=\"k\" value=\"$k\"></input>";
							echo "</h4>".$display_art['sottotitolo']."</h4></br>";
							echo "</h4>".$display_art['testo']."</h4>";
							echo "</br>";
						}
					echo"</form>";
					}
				}
				session_destroy();
			?>
			
		</div>
	</body>
</html>