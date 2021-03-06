<!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <!-- FEUILLES DE STYLE -->
  <link rel="icon" type="text/css" href="./images/favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css"></link>
  <link rel="stylesheet" type="text/css" href="css/style.css"></link>
  <link rel="stylesheet" type="text/css" href="css/carrousel.css"></link>
  <link rel="stylesheet" type="text/css" href="css/menu.css"></link>
  <link rel="stylesheet" type="text/css" href="css/footer.css"></link>
  <link rel="stylesheet" type="text/css" href="css/main.css"></link>
  <!-- STYLE DU RESPONSIVE DESIGN -->
  <link rel="stylesheet" type="text/css" href="css/max1630px.css" media="screen and (min-width: 1445px) and (max-width: 1630px)"></link>
  <link rel="stylesheet" type="text/css" href="css/max1445px.css" media="screen and (min-width: 1280px) and (max-width: 1445px)"></link>
  <link rel="stylesheet" type="text/css" href="css/max1280px.css" media="screen and (min-width: 1032px) and (max-width: 1280px)"></link>
  <link rel="stylesheet" type="text/css" href="css/max1032px.css" media="screen and (min-width: 768px) and (max-width: 1032px)"></link>
  <link rel="stylesheet" type="text/css" href="css/mobile.css" media="screen and (max-width: 768px)"></link>
  <!-- ************************** -->
  <title>Congrès APLIUT 2018 - Sponsors</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery-2-1-4-min.js"></script>
</head>
<body>
  <!-- EN-TETE -->
  <header>
    <?php
    require('php/connexion.php');
    include('php/convertirDate.php');
    include('php/menu.php');
    include('php/affichagesPartenaires.php')
    ?>
  </header>

  <!-- PAGE PRINCIPAL -->
  <div class="page-principale">
    <div id="push" style="padding-top:60px;"></div>
    <!-- GRAND TITRE -->
    <div class="conteneur conteneur-mentions conteneur-mentions-h1">
      <h1>Sponsors</h1>
    </div>

    <!-- PARTENAIRES -->
    <div class="conteneur conteneur-mentions conteneur-mentions-presentation conteneur-sponsors" id="mentions1">
     <?php
        affichagePartenaires("s");
     ?>
   </div>

   <div id="topButton"><span class="glyphicon glyphicon-menu-up"></span></div>

 </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 <script type="text/javascript" src="js/jquery-2-1-4-min.js"></script>
 <script type="text/javascript" src="js/bootstrap.js"></script>
 <script type="text/javascript" src="js/colloque2018.js">
 </script>

 <!-- PIED DE PAGE -->
 <footer style="margin-top:<?php
 $resultats = $db->prepare('SELECT count(*) FROM partenaires WHERE choix=:choix');
 $execute = $resultats->execute(array("choix" => "s"));
 $row = $resultats->fetch();
 $val=($row[0]/2)*145;
 echo $val.'px';
 ?>;">
     <?php include('php/footer.php'); ?>
 </footer>

</body>
</html>
