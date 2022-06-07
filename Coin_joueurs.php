<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Le coin des joueurs</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
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
					<a href="recherche.php"target="_BLANK">
						Rechercher un panier
					</a>					
				</li>
				<li class="btn">
					<a href="incident.php"target="_BLANK">
						Déclarer un incident
					</a>
				</li>
				<li  class="btn">
					<a href="Coin_joueurs.php"target="_BLANK">
						Coin des joueurs
					</a>
				</li>
			</ul>
		</nav>


		<p>Créez votre compte !</p>

		
	<form method="post" action="">
	<input type="text" name="PSEUDO" id="PSEUDO" placeholder="Votre pseudo" ><br>
	<input type="text" name="NOM" id="NOM" placeholder="votre nom" ><br>
	<input type="text" name="PRENOM" id="PRENOM" placeholder="Votre prénom" ><br>
	<input type="email" name="EMAIL" id="EMAIL" placeholder="Votre adresse mail"><br>
	<input type="password" name="MOTDEPASSE" id="MOTDEPASSE" placeholder="Votre mot de passe" ><br>
	</br>
	<input type="submit" value="OK"><br>


	<?php
	//var_dump($_POST);
	// on récupère les données du formulaire par la méthode POST, les champs ne doivent pas être vides


 		if(!empty($_POST))
 		{
 			if(
 				isset($_POST['PSEUDO'], $_POST['NOM'], $_POST['PRENOM'], $_POST['EMAIL'], 
 					$_POST['MOTDEPASSE'])
 				&& !empty($_POST['PSEUDO']) && !empty($_POST['NOM']) && !empty($_POST['PRENOM']) 
				&& !empty($_POST['EMAIL']) && !empty($_POST['MOTDEPASSE'])
 			   )
 
			 
 				{
 					//on connecte la base
 					include 'include/CNXBD.php';  
 					global $db;
 					//le formulaire est complet
 					//on récupère les données en les protégeant (failles XSS)
 					//on retire toutes les balises du Nom, prénom et âge (strip_tags)
					$PSEUDO=strip_tags($_POST['PSEUDO']);
 					$NOM=strip_tags($_POST['NOM']);
 					$PRENOM=strip_tags($_POST['PRENOM']);
 					$EMAIL=strip_tags($_POST['EMAIL']);
					$MOTDEPASSE= password_hash($_POST['MOTDEPASSE'], PASSWORD_DEFAULT);


					//on écrit la requête d'insertion des données du compte dans la table jouer
		$sql="INSERT INTO JOUEUR (PSEUDO, NOM, PRENOM, EMAIL, MOTDEPASSE) VALUES (:PSEUDO, :NOM, :PRENOM, :EMAIL, :MOTDEPASSE)";
 		
 		//on prépare la requête

 		$query=$db->prepare($sql);
 		//on injecte les valeurs

		$query->bindValue(":PSEUDO",$PSEUDO, PDO::PARAM_STR);
 		$query->bindValue(":NOM",$NOM, PDO::PARAM_STR);
 		$query->bindValue(":PRENOM",$PRENOM, PDO::PARAM_STR);
 		$query->bindValue(":EMAIL",$EMAIL, PDO::PARAM_STR);
		$query->bindValue(":MOTDEPASSE",$MOTDEPASSE, PDO::PARAM_STR);

 		//On exécute la requête
 		if(!$query->execute())
 		{
 			die("Une erreur est survenue");
 		}

 		//on récupère l'id du compte pour l'afficher en retour



 		die("$PSEUDO, votre compte est créé avec succès !");

 			}else{
 				die("Le formulaire est incomplet");
 			}
 		}

 			?>

 		<h2>Faites une proposition de jeu</h2>

	<a href="proposition.php"target="_BLANK">Donnez rendez-vous aux joueurs en précisant date, heure et l'emplacement du panier.</a>

    <h2>Demander un nouveu panier</h2>

	<a href="installation.php"target="_BLANK">Faites une demande d'installation en cliquant sur ce lien.</a>

	<h3>Contactez-nous :</h3>
        <a href="mailto:genevieve.stenne@gmail.com">Envoyer votre email.</a>

<script src="app.js"></script>



</body>
</html>