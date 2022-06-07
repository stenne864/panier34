<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Incident</title>
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


 	<br>
	<p>DEMANDE D'INSTALLATION D'UN NOUVEAU PANIER</p>
	<form action=" " method="POST" id="PSEUDO">
	<p>Vous devez possoder un compte. Entrer votre pseudo :</p>
	<input type="text" name="PSEUDO" id="PSEUDO" required><br/>

<br>
<br>

	<p>Entrer le nom de la ville :</p>
	<input type="text" name="VILLE" id="VILLE" required><br/>

	<h2 class="installation"> Détailler votre demande :</h2>
                <textarea placeholder="Adresse, type de panier" id="DETAIL" name="DETAIL" rows="3" cols="70"></textarea>
        </br>
            <button type="submit">Envoyer</button>
        </form>
    </br>


<?php
if(!empty($_POST))
 		{
	if(
		isset($_POST['PSEUDO'], $_POST['VILLE'], $_POST['DETAIL']) 
		&& !empty($_POST['PSEUDO']) && !empty($_POST['VILLE']) && !empty($_POST['DETAIL'])
	)
	{
		
		include 'include/CNXBD.php'; //on connecte la base 
		global $db;

		//le formulaire est complet
 		//on récupère les données en les protégeant (failles XSS)
 		//on retire toutes les balises

	$PSEUDO=strip_tags($_POST['PSEUDO']);
	$VILLE=strip_tags($_POST['VILLE']);
	$DETAIL=strip_tags($_POST['DETAIL']);
	

	$sql='SELECT * FROM JOUEUR where pseudo=:PSEUDO';

	$requete = $db->prepare($sql);
	$requete->bindValue(':PSEUDO',$PSEUDO,PDO::PARAM_STR);

	$requete->execute();

	
	 if($data = $requete->fetch())
	{
		//echo "Votre compte existe";

		$sql2="INSERT INTO INSTALLATION (PSEUDO, VILLE, DETAIL) VALUES (:PSEUDO, :VILLE, :DETAIL)";
		//on prépare la requête

 		$requete2=$db->prepare($sql2);
 			//on injecte les valeurs

	$requete2->bindValue(':PSEUDO',$PSEUDO,PDO::PARAM_STR);
	$requete2->bindValue(':VILLE',$VILLE,PDO::PARAM_STR);
	$requete2->bindValue(':DETAIL',$DETAIL,PDO::PARAM_STR);
	//On exécute la requête

	$requete2->execute();

	$id = $db->lastInsertId();
	die("Demande d'installation enregistrée sous le numéro $id, vous serez contacté par mail pour vous informer de l'avancement du projet");

	}else {
		echo "Vous devez créer un compte";
	}
    





	}
}
?>