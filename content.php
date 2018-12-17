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
			if(!($database=mysql_connect("localhost", "root", "acdc")))die ("Non è stato possibile connettersi al DB");
				mysql_select_db("crearte");
				
				if($_GET['item']=='home'){
					header("location:home.html");
				}
				else if($_GET['item']=='info'){
					echo "<fieldset><legend><h2>Chi siamo</h2></legend><h4>	
							La società cooperativa “CreArte” nasce il 1° Agosto 2013, dall’idea di nove giovani donne mosse dal desiderio di creare nuove opportunità lavorative sfruttando le loro capacità apprese nell’ambito scolastico e lavorativo.
							</br>I servizi da noi offerti rientrano nei seguenti settori:
							<ul>
								<li><b>Produzione e lavoro:</b> prestazione di attività didattiche, educative e formative; gestione di scuole, asili e centri estivi; assistenza amministrativa, fiscale e tributaria; servizi informatici; manutenzione di aree verdi; e altri servizi utili alla collettività.</li>
								<li><b>Servizi sociali:</b> gestione di strutture pubbliche e private sanitarie e socio assistenziali.</li>
								<li><b>Cultura:</b> sviluppo e gestione di eventi culturali e servizi annessi, supporto e promozione di attività che si occupano della valorizzazione di beni culturali e artistici.</li>
								<li><b>Sport:</b> diffusione di attività sportive, organizzazione di eventi e gestione di impianti sportivi.</li>
								<li><b>Ambiente e Turismo:</b> organizzazione di attività incentrate sulla valorizzazione del patrimonio  paesaggistico, artistico e storico del Monferrato e del Piemonte.</li>
							</ul>
							Se vuoi più informazioni a riguardo, puoi scaricare la nostra <a href=\"documenti/Lettera_di_presentazione.pdf\" >lettera di prestazione <img src=\"immagini/pdf.png\" width=25px></img></a>
							
						</h4></fieldset>";
				}
				else if($_GET['item']=='eventi'){
				/*conto quanti articoli sono presenti nel db*/
					$tot="SELECT COUNT(*) as tot FROM articolo";
					$tota=mysql_query($tot);
					if($tota===FALSE){
						die(mysql_error());
					}
					$totale=mysql_fetch_assoc($tota);
					/*eseguo una serie di calcoli per ottenere il numero totale di pagine per gli articoli*/
					$pag=$totale['tot']/5;
					$pagtot=(int)$pag;
					if($totale['tot']%5>0){$pagtot+=1;}
				/*seleziono il range di articoli da visualizzare*/
					
					if(isset($_GET['numero'])){
					//codici per evitare valori sporchi nel db
						if (filter_var($_GET['pagina'],FILTER_VALIDATE_INT)){
							if ((int)$_GET['pagina']<=$pagtot){
								if (filter_var($_GET['numero'],FILTER_VALIDATE_INT)){
									$num0=$_GET['numero'];
									$num=$_GET['numero']+5;
									$pagina=$_GET['pagina']+1;
								}else header("Location:404.html");
							}else header("Location:404.html");
						}else header("Location:404.html");
					}else {$num=5; $num0=0; $pagina=1;}
					
					if($totale['tot']-($num-5)<=0){
					/*sono arrivato all'ultima pagina da visualizzare*/
						echo"<h4>Non sono presenti altri articoli da visualizzare</h4>";
					}
					else{
					$ev="SELECT articolo.*, nome, cognome FROM articolo join autore on articolo.autore=autore.id ORDER BY data DESC LIMIT ".$num0.",".$num."";
					
					$even=mysql_query($ev);
					if($even===FALSE){
						die(mysql_error());
					}
					while($eventi=mysql_fetch_array($even)){
						echo"<fieldset>";
						echo"<legend><a href=\"articolo.php?numarticolo=".$eventi['key']."\"><h2>".$eventi['titolo']."</h2></a></legend>";
						echo"<h4>".$eventi['sottotitolo']."</h4>";
						echo"<h6>Pubblicato da: ".$eventi['nome']." ".$eventi['cognome']."</br>";
						echo"Data di pubblicazione: ".$eventi['data']."</br>";
						if ($eventi['modifica']!=""){
							echo "Ultima modifica: ".$eventi['modifica']."";
						}echo"</h6>";
						echo"</fieldset>";
					}
					echo"<h4 class=\"center\">Pagina ".$pagina." di ".$pagtot."</h4>";
					echo"<a href=\"content.php?item=eventi&numero=".$num."&pagina=".$pagina."\"><h4 class=\"center\">Mostra meno recenti</h4></a>";
				}
				
				}
				else if($_GET['item']=='servizi'){
					echo"<h4>Servizi</h4>";
				}
				else if($_GET['item']=='galleria'){
					echo"<fieldset>";
					echo"<legend><h4>Gallerie fotografiche</h4></legend>";
					echo"<div id=\"galleria\">";
					//leggo tutte le cartelle all'interno di galleria/
					$dir=glob("galleria/*", GLOB_ONLYDIR);
					arsort($dir);
					foreach ( $dir as $cartella){
						$i=0;
						foreach( glob($cartella."/*.jpg") as $img){
							if ($i==0){
								$titolo=strtok($cartella,'/');
								$titolo=strtok('/');
								$titolo=substr($titolo,6);
								echo"<p><h4 class=\"center\">".$titolo."</h4><h4 class=\"center\"><a href=\"galleria.php?dir=".$cartella."\"><img src=\"".$img."\" width=\"50%\" ></img></a></h4></p>";
								$i=1;
							}
						}
					}
				
				echo"</div>";
				echo"</fieldset>";
				}
				else if($_GET['item']=='contatti'){
					echo"<h4 style=\"text-align:center\"><b>Contatti:</b></br>Via Savio 14, 15033 Casale Monferrato (AL) </br>Cell. 1: 366-2731371</br>Cell. 2: 348-9380804</br>E-mail: documenti.crearte@libero.it</br>Indirizzo PEC: creartecooperativa@pec.it</h4>";
				}
				else {
					header("Location:404.html");
				}
			?>
		</div>
	</body>
	<footer><a href="https://www.linkedin.com/profile/view?id=285041913&trk=nav_responsive_tab_profile"><h6 class="center">License: (CC) 2014 Matteo Patrucco</h6></a></footer>
</html>
