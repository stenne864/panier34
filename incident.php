<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Incident</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<script>alert ("Vous devez créer un compte pour utiliser cette page, rendez-vous sur le coin des joueurs");</script>
	<header> 
			<p>
				Bienvenue dans le monde du basket-ball urbain !
			</p>
		</header>
		<!--menu de navigation-->

		<nav class="menu-nav">
			<ul>
				<li class="btn">
					<a href="index.html">
						Accueil
					</a>
				</li>
				<li class="btn">
					<a href="recherche.php" target="_BLANK">
						Rechercher un panier
					</a>					
				</li>
				<li class="btn">
					<a href="incident.php" target="_BLANK">
						Déclarer un incident
					</a>
				</li>
				<li  class="btn">
					<a href="Coin_joueurs.php" target="_BLANK">
						Coin des joueurs
					</a>
				</li>
			</ul>
		</nav>




<h2>Déclarer un incident sur un panier</h2> 

  
<form method="POST" id="PSEUDO">
	<p>Entrer votre pseudo :</p>
	<input type="text" name="PSEUDO" id="PSEUDO" required><br/>

<br>
<br>

<form method="POST" id="IDPANIER">
	<p>Entrer le numéro du panier :</p>
	<input type="number" name="IDPANIER" id="IDPANIER" required><br/>



	<br>
	<form action=" " method="POST" id="libelle">

	Cochez le type d'incident (un seul choix possible) : 
	<br>
	<br>
	<input type="radio" name="LIBELLE" id="LIBELLE" value="PANNEAU CASSE"><label>Panneau endommagé</label><br>
	<input type="radio" name="LIBELLE" id="LIBELLE" value="CERCEAU CASSE"><label>Cerceau cassé</label><br>
	<input type="radio" name="LIBELLE" id="LIBELLE" value="FILET ABSENT"><label>Filet absent</label><br>
	<input type="radio" name="LIBELLE" id="LIBELLE" value="FILET DECHIRE"><label>Filet déchiré</label><br>
	<input type="radio" name="LIBELLE" id="LIBELLE" value="POTEAU CASSE"><label>Poteau endommagé</label><br>
	<br>
	<input type="submit" name="Envoyer">

</form>


<?php

if(!empty($_POST))
 		{
 			if(
 				isset($_POST['PSEUDO'], $_POST['IDPANIER'], $_POST['LIBELLE']) 
 				&& !empty($_POST['PSEUDO']) && !empty($_POST['IDPANIER']) && !empty($_POST['LIBELLE'])
 			   )
 				{

 					//le formulaire est complet
 					//on récupère les données en les protégeant (failles XSS)
 					//on retire toutes les balises du Nom, prénom,
					$PSEUDO=strip_tags($_POST['PSEUDO']);
 					$IDPANER=strip_tags($_POST['IDPANIER']);
 					$LIBELLE=strip_tags($_POST['LIBELLE']);
 					$COMMENT="INCIDENT ENREGISTRE";

 

		include 'include/CNXBD.php'; //on connecte la base 
 		global $db;

		$sql="INSERT INTO INCIDENT (IDPANIER, LIBELLE, PSEUDO, COMMENT) VALUES (:IDPANIER, :LIBELLE, :PSEUDO, :COMMENT)";
 		
 		//on prépare la requête

 		$query=$db->prepare($sql);
 		//on injecte les valeurs

 		$query->bindValue(":IDPANIER",$IDPANER, PDO::PARAM_INT);
 		$query->bindValue(":LIBELLE",$LIBELLE, PDO::PARAM_STR);
 		$query->bindValue(":PSEUDO",$PSEUDO, PDO::PARAM_STR);
 		$query->bindValue(":COMMENT",$COMMENT, PDO::PARAM_STR);

 		//On exécute la requête

 	
 		if(!$query->execute())
 		{
 			die("Une erreur est survenue");
 		}

 		//on récupère l'id de l'incident

 		$id = $db->lastInsertId();

 		die("Incident enregistré sous le numéro $id");

 			}else{
 				die("Le formulaire est incomplet");
 			}
 		}

 		?>
	<br>


	<p>Pour connaître la prise en charge de l'incident, cliquez sur ce lien :</p>

	<a href="traitement.php" target="_BLANK">Vous devrez saisir le n° d'incident vous consulter l'avancement de la réparation.</a>
	


</body>

</html>