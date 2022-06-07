<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Incident</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<script>alert ("Votre message sera en ligne après validation de son contenu par notre modérateur.");</script>
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
	<p>PROPOSITION DE JEU</p>
<form action=" " method="POST" id="PSEUDO">
	<p>Vous devez possoder un compte. Entrer votre pseudo :</p>
	<input type="text" name="PSEUDO" id="PSEUDO" required><br/>

<br>
<br>


	<h2 class="installation"> Détaillez votre proposition de jeu:</h2>
                <textarea placeholder="Votre message, date et heure, lieu" id="MESSAGE" name="MESSAGE" rows="3" cols="70"></textarea>
        </br>
            <button type="submit">Envoyer</button>
        </form>
    </br>


<?php
	// on récupère les données du formulaire par la méthode POST, les champs ne doivent pas être vides
if(!empty($_POST))
 		{
	if(
		isset($_POST['PSEUDO'], $_POST['MESSAGE'])
		&& !empty($_POST['PSEUDO']) && !empty($_POST['MESSAGE'])
	)
	{
		//on connecte la base

		include 'include/CNXBD.php';  
		global $db;
		
		//le formulaire est complet
 		//on récupère les données en les protégeant (failles XSS)
 		//on retire toutes les balises


	$PSEUDO=strip_tags($_POST['PSEUDO']);
	$MESSAGE=strip_tags($_POST['MESSAGE']);
	$MODERATEUR="F";
	
	// on écrit la requête de sélectionne pour contrôler l'existance du compte
	$sql='SELECT * FROM JOUEUR where pseudo=:PSEUDO';

	//on prépare la requête
	$requete = $db->prepare($sql);
	//on injecte le pseudo saisi par le joueur
	$requete->bindValue(':PSEUDO',$PSEUDO,PDO::PARAM_STR);
	//on exécute la requête
	$requete->execute();

	//on va rechercher les données dans la base
	 if($data = $requete->fetch())
	 	//si le compte existe on applique ce code :
	{
		if (!empty($_POST['PSEUDO']) && !empty($_POST['MESSAGE']))
		{

			//requête d'insertion de la proposition de jeu
		$sql2="INSERT INTO PROPOSITION (PSEUDO, MESSAGE, MODERATEUR) VALUES (:PSEUDO, :MESSAGE, :MODERATEUR)";
		//on prépare la requête

 		$requete2=$db->prepare($sql2);
 			//on injecte les valeurs

	$requete2->bindValue(':PSEUDO',$PSEUDO,PDO::PARAM_STR);
	$requete2->bindValue(':MESSAGE',$MESSAGE,PDO::PARAM_STR);
	$requete2->bindValue(':MODERATEUR',$MODERATEUR,PDO::PARAM_STR);
	//On exécute la requête

	$requete2->execute();
}
	// on retourne du texte après l'insertion réussie.

	die("Votre prosition de jeu est enregistrée, elle sera en ligne après validation de notre modérateur");

	}else {
		echo "Vous devez créer un compte";
	}
    
	}
}
				//on connecte la base

		include 'include/CNXBD.php';  
				global $db;
		//ici on affiche les propositions validées par le modérateur, filtrées par le "T" (=true) du champ MODERATEUR de la table proposition

 		//on écrit la requête de sélection

	$sql3="SELECT * from PROPOSITION where moderateur='T'";

//on prépare la requête 

$query=$db->prepare($sql3);


//on exécute la requête

$query->execute();

//on va chercher toutes les données de la table
$propositions=$query->fetchAll();

//on crée une boucle pour afficher les données avec un tableau
foreach ($propositions as $proposition) {

?>
<p><?php echo 'Proposition de jeu : ',$proposition['PSEUDO'],'  ',$proposition['MESSAGE']; ?></p>

<?php
}
?>
<p>Si votre message est en ligne c'est qu'il a été validé par notre modérateur</p>