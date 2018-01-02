<?php
session_start();
require("../php/connexion.php");
if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
{
	?>
		<!DOCTYPE html>
		<html lang="fr">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
			<!-- FEUILLES DE STYLE -->
			<link rel="icon" type="text/css" href="../images/favicon.ico"></link>
			<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"></link>
			<link rel="stylesheet" type="text/css" href="../css/style.css"></link>
			<link rel="stylesheet" type="text/css" href="../css/carrousel.css"></link>
			<link rel="stylesheet" type="text/css" href="../css/menu.css"></link>
			<link rel="stylesheet" type="text/css" href="../css/footer.css"></link>
			<link rel="stylesheet" type="text/css" href="../css/main.css"></link>
			<!-- STYLE DU RESPONSIVE DESIGN -->
			<link rel="stylesheet" type="text/css" href="../css/max1630px.css" media="screen and (min-width: 1445px) and (max-width: 1630px)"></link>
			<link rel="stylesheet" type="text/css" href="../css/max1445px.css" media="screen and (min-width: 1280px) and (max-width: 1445px)"></link>
			<link rel="stylesheet" type="text/css" href="../css/max1280px.css" media="screen and (min-width: 1032px) and (max-width: 1280px)"></link>
			<link rel="stylesheet" type="text/css" href="../css/max1032px.css" media="screen and (min-width: 768px) and (max-width: 1032px)"></link>
			<link rel="stylesheet" type="text/css" href="../css/mobile.css" media="screen and (max-width: 768px)"></link>
			<!-- ************************** -->
			<title>Session admin | Partenaires</title>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
			<script type="text/javascript" src="js/jquery-2-1-4-min.js"></script>
		</head>
		<body>
			<!-- EN-TETE -->
			<header>
				<?php
				include('menu.php'); 						// Importation du menu
				include('../php/convertirDate.php');		// Importation de la fonction de convertion de date
				include('../php/reponse_formulaire.php');	// Importation de la fonction de modification des images
    			$choix = 'sponsor';
				?>
			</header>
            <div class="conteneur conteneur-colloque conteneur-colloque-h1">
                <?php
                if($choix == 'partenaire') { ?>
                    <h1>Partenaires</h1>
                <?php }
                else { ?>
                    <h1>Sponsors</h1>
                <?php
                }
                ?>
            </div>

            <div class="conteneur conteneur-colloque conteneur-colloque-div" id="partenaires">
                <?php
            //selectionne tous les partenaires
            $allpartenaires= $db->prepare('SELECT * FROM partenaires');
            $allpartenairesExecute=$allpartenaires->execute();
            if(!$allpartenairesExecute){
                echo"<p> Erreur lors de la recherche des partenaires existants.</p>";
            }
            if($choix == 'sponsor') {
                if(isset($_POST['modifierPartenaire'])) {
                    //donne la possibilté de modifier les images et les noms des partenaires
                    ?>
                    <form method="post" action="sponsor.php" enctype="multipart/form-data"><!-- par default enctype  est de type tetxe. ici précise qu'il y a un fichier-->
                    <?php
                    $i=0;
                    foreach($allpartenaires as $chaqueS){
                        if($chaqueS[3]=='s') {
                            ?><input type="hidden" name="<?php echo 'id'.$i; ?>" value="<?php echo $chaqueS['idP']; ?>"><br/>
                            <input class="form-control" name="<?php echo 'nom'.$i;?>" value="<?php echo $chaqueS['nomP'];?>" required>	<br/>
                            <input type="file" name="<?php echo 'imageModifiee'.$i; ?>" /><br/>
                            <img src="<?php echo ".././".$chaqueS['photoP'];?>" width='300px' height="auto"/><br/>
                            <?php
                        }
                        $i++;
                    }
                    ?><button type="submit" name="EnregistrerSponsor"> Enregistrer les sponsors</button>
                    <input type="hidden" name="choix" value="<?php echo $_POST['choix']; ?>">

                </form>
                <?php
                }
                else{
                    //affiche normallement
                    ?>
                    <form method="post" action="sponsor.php">
                        <?php
                        $i=0;
                        foreach($allpartenaires as $chaqueP){
                            if($chaqueP[3] == 's') {
                                ?><input type="radio" name="SponsorASupprimer" value="<?php echo $chaqueP[0];?>"/>  <?php
                                $sponsorTrouve = $chaqueP[2];
                                echo"Sponsor: $sponsorTrouve";

                                ?>
                                <p> <img src="<?php echo "../".$chaqueP[1];?>"width='300px' height="auto"/> </p><br/>
                                <?php
                                $sponsorTrouve++;
                            }
                            $i++;
                        }
                        ?>
                        <button type="submit" name="modifierPartenaire" >Modifier sponsor</button>
                        <button type="submit" name="AjouterSponsor" >Ajouter un sponsor</button>
                        <button type="submit" name="SupprimerSponsor" >Supprimer un sponsor</button>
                        <input type="hidden" name="choix" value="<?php echo $choix; ?>">

                    </form>
                <?php
                }
            }


            if(isset($_POST['EnregistrerSponsor'])){
                //compte le nombre de partenaires
                $nombreSponsor = $db->prepare('SELECT count(*)FROM partenaires');
                $nombreSponsorExecute=$nombreSponsor->execute();
                if(!$nombreSponsorExecute){
                    echo"<p> Erreur pour compter des partenaires existants.</p>";
                }
                $nbSponsor=$nombreSponsor->fetch();
                //pour chaque partenaires
                $BienEnregistrerSponsor=0;//compte le nombre de partenaires bien enregistrés
                for($i=0;$i<$nbSponsor[0];$i++){
                    $idSponsor="id".$i;
                    $nomSponsor = "nom".$i;
                    //si les champs sont remplis
                    if(!empty($_POST[$nomSponsor])){
                        //modifie la BDD
                        $modificationSponsor = $db->prepare('UPDATE partenaires SET nomP = :nom WHERE idP = :id');
                        $modS = $modificationSponsor->execute(array(  "nom"	=> $_POST[$nomSponsor],
                        "id"	=> $_POST[$idSponsor]));

                        if(!$modS){
                            echo '<p>Erreur lors de la requête de modification</p>';
                        }
                        else{
                            //si il y a une image à modifer
                            $NomImageChoisie="imageModifiee".$i;
                            $imaageChoisie=$_FILES[$NomImageChoisie];
                            if($imaageChoisie['error']== 0){
                                //verifie si contient .jpg
                                $pattern='/(.jpg)$/i'; //$= oblige en fin de chaine./i indiférent à la casse
                                if(preg_match($pattern,$imaageChoisie['name'])==1) {    //analyse le nom de l'image pour trouver $pattern. si oui  return 1
                                    //insérer l'image dans le dossier
                                    $nomS=str_replace(' ','',$_POST[$nomSponsor]);//enlève les espaces dans le nom
                                    $nameImage="./images/".$_POST[$nomSponsor].".jpg";
                                    $reussi=move_uploaded_file($imaageChoisie["tmp_name"], "../".$nameImage);//télécharge l'image de l'utilisateur dans le dossier images en écrasant l'existante
                                    if(!$reussi){
                                        echo"<p>Erreur lors du téléchargement de l'image. Veuillez réessayer</p>";
                                    }
                                    else{
                                        //modifie dans la base de données
                                        $enregistrementImage = $db-> prepare('UPDATE partenaires SET photoP=:photo WHERE idP=:id ;');
                                        $BienEnregistrerImage=$enregistrementImage ->execute(array('photo'=>$nameImage,
                                            'id'=>$_POST[$idSponsor]));
                                            if($BienEnregistrerImage){
                                                $BienEnregistrerSponsor++;
                                            }
                                            else{
                                                echo"<p> Erreur lors de l'enregistrement de l'image dans la base de données.</p>";
                                            }
                                        }
                                }
                                else{
                                    echo"Format de l'image incorrect. Le format doit être <b>JPG</b>.";
                                }
                            }
                        }
                    }

                }//fin for
                //si il y a au moins  des champs vides pour au moins  1 partenaire on affiche un message d'avertissement

                if($BienEnregistrerSponsor==$nbSponsor[0]){
                    echo"<p> L'enregistrement à bien été effectué</p>";
                    //rafraichir la page
                    echo"<meta http-EQUIV=\"Refresh\" CONTENT=\"0; url=sponsor.php\"/>";
                }
            }	//fin bouton enregistrer

            if(isset($_POST['AjouterSponsor'])){
            ?>
                <form action ="sponsor.php" method="post"  enctype="multipart/form-data"><!-- enctype par default tetxe. ici précise que il y a un fichier-->
                    <input type="file" name="imageA" required/>	<br/>
                    <div class="figcaption-div figcaption-div-gauche">
                        <h4 class="conferencies-h4">Nom</h4><br/>
                        <p class="figcaption-p-info conferencies-nom"> <input class="form-control" name="nomA" required> </p>
                    </div>
                    <button type="submit" name="ajouterS">Enregistrer le sponsor</button>
                    <input type="hidden" name="choix" value="<?php echo $_POST['choix']; ?>">

                </form>
            <?php
            }


            if(isset($_POST['ajouterS'])){
                if(!empty($_POST["nomA"])){
                        //si le partenaire n'existe pas déja . on insere dans BDD
                    $sponsor=$db->prepare("SELECT * from partenaires WHERE nomP=:nom ");
                    $RbienExec4=$sponsor->execute(array('nom'=>$_POST['nomA']));
                    if($RbienExec4){
                        if($sponsor->fetch()!=false){
                            echo"<p>Un sponsor de ce nom existe déjà. veuillez réessayer avec un autre nom.</p> ";
                        }
                        else{
                                $ajoutS = 's';
                                //insérer dans BDD
                                $nomS=str_replace(' ','',$_POST['nomA']);//enlève les espaces dans le nom
                                $nameImage="./images/".$nomS.'.jpg';
                                $ajouterligne = $db-> prepare('INSERT INTO partenaires(nomP,photoP,choix) VALUES (:nom, :photo, :choix)');
                                $RbienExec3=$ajouterligne->execute(array('nom'=>$_POST['nomA'],
                                                                         'photo'=>$nameImage,
                                                                         'choix' => $ajoutS));
                                if(!$RbienExec3){
                                    echo"<p>Erreur lors de l'insertion du sponsor. Veuillez réessayer</p>";
                                }
                                else{
                                    echo"<p>L'enregistrement des données à bien été fait.</p>";
                                    //si il y a une image à ajouter
                                    if($_FILES['imageA']['error'] == 0){
                                        //verifie si contient .jpg/.gif/.png
                                        $pattern='/(.jpg)$/i'; //$= oblige en fin de chaine./i indiférent à la casse
                                        if(preg_match($pattern,$_FILES['imageA']['name'])==1) {    //preg_match :analyse le nom de l'image pour trouver $pattern. si oui  return 1
                                            //insérer l'image dans le dossier
                                            $reussi=move_uploaded_file($_FILES['imageA']["tmp_name"], "../".$nameImage.'.jpg');//télécharge l'image de l'utilisateur dans le dossier images
                                            //si le tranfert n'a pas reussi
                                            if(!$reussi){
                                                echo"Erreur lors du téléchargement de l'image. Veuillez réessayer";
                                            }
                                            else{
                                                echo"<p>L'enregistrement  de l'image à bien été effectué</p>";
                                                    //recharger la page
                                                echo"<meta http-EQUIV=\"Refresh\" CONTENT=\"0; url=sponsor.php\">";
                                            }
                                        }
                                        else{
                                            echo"Le format de l'image doit etre <n>JPG</b>.";
                                        }
                                    }
                                }
                            }
                        }
                    }//fin if

                }//fin  enregistrer d'ajouter

                if(isset($_POST['SupprimerSponsor'])){
                    if(!empty($_POST['SponsorASupprimer'])){
                                //chercher le chemin	de l'image
                        $cheminS = $db-> prepare('SELECT photoP FROM partenaires WHERE idP=:id ');
                        $cheminS->execute(array('id'=>$_POST['SponsorASupprimer']));
                        $cheminASupprimer=$cheminS->fetch();
                                //Supprimer la ligne concernant le partenaire dans la BDD
                        $SupprimerS = $db-> prepare('DELETE FROM partenaires WHERE idP=:id ');
                        $BienSupprS=$SupprimerS->execute(array('id'=>$_POST['SponsorASupprimer']));
                        if($BienSupprS){
                            unlink($cheminASupprimer[0]);
                            echo"<p> L'enregistrement à bien été supprimé.<br/></p>";
                                    //rafraichir la page
                            echo"<meta http-EQUIV=\"Refresh\" CONTENT=\"0; url=sponsor.php\">";
                        }
                        else{
                            echo"<p>Erreur lors de la suppression du sponsor dans la Base de données</p>";
                        }
                    }//fin if
                    else{
                        echo"<p>Veuiilez cocher un sponsor pour supprimer un sponsor</p>";
                    }
            }// fin  bouton supprimer ?>
            </div>
    <script type="text/javascript" src="../js/menu.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/colloque2018.js"></script>
    <footer>
        <?php include('./footer_admin.php'); ?>
    </footer>
<?php
}
else {
	echo "Redirection vers la page de connexion";
	header("Refresh:0;url=index.php");
}
?>
