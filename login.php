<?php
/*comincia la sessione*/
	session_start();
	if(!($database=mysql_connect("localhost", "root", "acdc")))die ("Non è stato possibile connettersi al DB");
		mysql_select_db("crearte");
		$id=session_id();	//genero un id per la sessione
		/*controllo se l'utente è già loggato, se si ricerco la sua sessionid nel db*/
		if(isset($_COOKIE['crearte_admin'])){
		$c="SELECT autore.sessione FROM autore WHERE autore.id='".$_COOKIE['crearte_admin']."'";
		$cookie=mysql_query($c);
		if($cookie===FALSE){
			die(mysql_error());
		}
		$num=mysql_fetch_array($cookie);
		/*confronto la sessionid dell'utente con quella attuale, se combaciano l'utente prosegue, altrimenti deve loggarsi*/
		if ($num['sessione']==$_COOKIE['PHPSESSID']){header("Location:admin.php");}else header("Location:login.php");
	}
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
		</div>
		
		<div id="contents" class="content">
			
			<fieldset>
			<legend><h2>Esegui il Login</h2></legend>
			<form method="post" action="login.php">
			<h4 class="center">Nome Utente</h4><input type="text" name="nome" class="login" style="margin:0 auto" placeholder="Nome Utente"></input>
			<h4 class="center">Password</h4><input type="password" name="password" class="login" style="margin:0 auto" placeholder="password"></input>
			<?php
				/*se ho premuto il pulsante di login, controllo che i campi non siano vuoti*/
				if(isset($_POST['nome'])&&isset($_POST['password'])&&($_POST['nome']!="")&&($_POST['password']!="")){
					/*ricerco l'utente nel db*/
					$us="SELECT * FROM autore WHERE mail='".$_POST['nome']."'";
					$user=mysql_query($us);
					if($user===FALSE){
						die(mysql_error());
					}
					$userid=mysql_fetch_array($user);
					
					$pass=$userid['password'];
					/*calcolo l'hash della password inserita e la confronto con quella salvata nel db*/
					if (md5($_POST['password'])==$pass){
						$reg="UPDATE autore SET sessione='".$id."'"; /*aggiorno la sessionid dell'utente*/
						$registra=mysql_query($reg);
						if($registra===FALSE){
							die(mysql_error());
						}
						/*creo un cookie che mantenga il nome dell'utente loggato e reindirizzo alla pagina di amministrazione*/
					setcookie("crearte_admin", $userid['id']);
					header("location:admin.php");
					}else echo "<h5>Dati inseriti non corretti</h5>";
				}
				echo "<p class=\"center\"><input type=\"submit\" value=\"Login\" class=\"button\" style=\"margin:0 auto\"></input>";
				
				session_destroy();
				
			?>
			
			</form>
			</fieldset>
		</div>
	</body>
</html>