<html>
	<head>
		<title>Crearte</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" title="style" href="style.css" />
	</head>
	<body>
    	<div id="header" class="header">
			<a href="home.html"><h2 align="center">CreArte</h2></a>
        </div>
        
		<div id="leftmenu" class="menu">
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=home'" value="Home"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=info'" value="Chi siamo"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=servizi'" value="Servizi"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=eventi'" value="Eventi"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=galleria'" value="Galleria"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=contatti'" value="Contatti"></input>
		</div>
    
		<div id="contents" class="content">
			<?php
			if(!($database=mysql_connect("localhost", "root", "acdc")))die ("Non è stato possibile connettersi al DB");
				mysql_select_db("crearte");
			
			if(isset($_GET['numarticolo'])){
				$ar="SELECT * FROM articolo WHERE articolo.key='".$_GET['numarticolo']."'";
				$art=mysql_query($ar);
				if($art===FALSE){
					die(mysql_error());
				}
				$articolo=mysql_fetch_array($art);
				$au="SELECT nome, cognome FROM autore WHERE id='".$articolo['autore']."'";
				$aut=mysql_query($au);
				if($aut===FALSE){
					die(mysql_error());
				}
				$autore=mysql_fetch_array($aut);
				echo"<fieldset>";
				echo"<legend><h2>".$articolo['titolo']."</h2></legend>";
				echo"<h4>".$articolo['sottotitolo']."</h4>";
				echo"<h4>".$articolo['testo']."</h4>";
				echo"<h6>Pubblicato da: ".$autore['nome']." ".$autore['cognome']."</br>";
				echo"Data di pubblicazione: ".$articolo['data']."</br>";
				if ($articolo['modifica']!=""){
					echo "Ultima modifica: ".$articolo['modifica']."";
				}echo"</h6></fieldset>";
			}
			?>
		</div>
	</body>
</html>