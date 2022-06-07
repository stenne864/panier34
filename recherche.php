<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Recherche</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

	<header>
			<p>
				Bienvenue dans le monde du basket-ball urbain !
			</p>
		</header>

		<body>
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

	<h2>Recherchez un panier près de chez vous !</h2>

		
	
<p>
	Vous pouvez rechercher un panier par ville ou type de panier.
	Sélectionnez ce qui vous intéresse à partir des menus déroulants :

	<ul>

	<li>Ville</li>
	<br>

	<form method="POST" id="rechVille">		
		<p>
			<label for="VILLE">Sélectionner une ville :</label>
		<select name="VILLE" id="VILLE">
			<option>--Sélectionner une ville--</option>			
			<option value="CLAPIERS">Clapiers</option>
			<option value="LE CRES">Le Crès</option>
			<option value="MONTFERRIER">Montferrier</option>
			<option value="MONTPELLIER">Montpellier</option>
			<option value="PEROLS">Pérols</option>

		</select>
	<br>
	<br>
		<input type="submit" value="Lancer la recherche">
		</p>
	</form>

<?php	
// on récupère les données du formulaire par la méthode POST, les champs ne doivent pas être vides

if(!empty($_POST))
{
	if (
		isset($_POST['VILLE']) && !empty($_POST['VILLE'])
	)

	{


//on connecte la base 
include 'include/CNXBD.php'; 
 		global $db;


 		//le formulaire est complet
 		//on récupère les données en les protégeant (failles XSS)
 		//on retire toutes les balises

$VILLE=strip_tags($_POST['VILLE']);

//on écrit la requête de sélection de recherche des paniers par ville

$sql='SELECT * from PANIER where ville=:VILLE';

//on prépare la requête 

$query=$db->prepare($sql);

//on injecte les valeurs

$query->bindValue(':VILLE',$VILLE,PDO::PARAM_STR);

//on exécute la requête, si elle n'est pas correcte on afficher un message d'erreur

if (!$query->execute())
{
	die("Une erreur est survenue");
}

	//on va rechercher toutes les données dans la base
$paniers=$query->fetchAll(); 

//on crée une boucle pour afficher les données avec un tableau
foreach ($paniers as $panier) {

?>
<p><?php echo 'Panier n°',' ',$panier['ID'],'  ', 'Type de panier :',' ',$panier['TYPE'],'  ','Adresse : ',' ', $panier['RUE'],'  ',$panier['VILLE'] ; ?></p>

<?php
}

}
}

	
?>

		<br>
		<br>
		

	<li>Type de panier</li>
	<br>

	<form method="POST" id="rechPanier">
		<p>
			<label for="TYPE">Sélectionner un type de panier :</label>
		<select name="TYPE" id="TYPE">
			<option>--Sélectionner un type de panier--</option>
		<option value="CITY STADE">City Stade</option>
		<option value="ENTRAINEMENT">Panier d'entrainement</option>
	<option value="TERRAIN">Terrain</option>
		</select>
		<br>
		<br>
	<input type="submit" value="Lancer la recherche">
		</p>
	</form>	
		<br/>
		<br>
		</ul>

<?php

if(!empty($_POST))
{
	if (
		isset($_POST['TYPE']) && !empty($_POST['TYPE'])
	)

	{
		//on connecte la base 
include 'include/CNXBD.php'; 
global $db;


$TYPE=strip_tags($_POST['TYPE']);

//on écrit la requête de sélection de recherche des paniers par type de panier
$sql='SELECT * FROM PANIER WHERE type=:TYPE';

$requete=$db->prepare($sql);
$requete->bindValue(':TYPE',$TYPE,PDO::PARAM_STR);
$requete->execute();

$types=$requete->fetchAll();

foreach ($types as $type) {
			?>

	<p id="retour"><?php echo 'Panier n°',' ',$type['ID'],' ', $type['VILLE'],' ',$type['RUE']?></p>
		<?php
						  }

						}
					}
		?>
	<br>
	<br>

</body>
</html>