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
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=info'" value="Chi siamo"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=servizi'" value="Servizi"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=eventi'" value="Eventi"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=galleria'" value="Galleria"></input>
			<input type="button" class="menubuttons" onclick="document.location='content.php?item=contatti'" value="Contatti"></input>
		</div>
    
		<div id="contents" class="content">
			<?php
				if(isset($_GET['dir'])){
					if (is_dir($_GET['dir'])){
						echo"<fieldset>";
						$galleria=strtok($_GET['dir'],'/');
						$galleria=strtok('/');
						echo"<legend><h4>Galleria: ".substr($galleria,6)."</h4></legend>";
						echo"<div id=\"galleria\">";
							//leggo tutte le immagini all'interno della cartella/
							$immagini=glob($_GET['dir']."/*.jpg");
							foreach ($immagini as $value){
								$titolo=strtok($value,'/');
								$titolo=strtok('/');
								$titolo=strtok('/');
								$titolo=substr($titolo,0,-4);
								
								echo"<p><h4>".$titolo."</h4><img src=\"".$value."\" class=\"img\"></img></p>";
							}
						echo"</div>";
						echo"</fieldset>";
					}else {
						header("Location:404.html");
					}
				}else {
					header("Location:404.html");
				}
			?>
		</div>
	</body>
	<footer><a href="https://www.linkedin.com/profile/view?id=285041913&trk=nav_responsive_tab_profile"><h6 class="center">License: (CC) 2014 Matteo Patrucco</h6></a></footer>
</html>
