
<!-- Liens pratiques de redirection vers partenaire et mentions légales -->
<div class="lienspratiques">
	<li>
	<a href="partenaires.php">Partenaires</a></li>
	<span class="separator-v" display="inline-block"></span>
	<li><a href="sponsor.php">Sponsors</a></li>
	<span class="separator-v" display="inline-block"></span>
	<li><a href="mentions.php">Mentions légales</a></li>
</div>
<div class="credits">
	<p>© 40ème Congrès de l'APLIUT 2018 - Tous droits réservés</p>
</div>
<div class="partenaires container">
	<div class=''>
	<?php
	include("../php/connexion.php");
	$res = $db->prepare('SELECT * from partenaires where choix="p"');
	$res->execute();
	//Affichage des partenaires dans le footer
	?><h3>Partenaires du Congrès</h3> <?php
	while($data = $res->fetch()) {
		?>
			<img src="<?php echo "../".$data['photoP'];?>" width='auto' height="100px" style="margin-left:10px;border-radius:15px;"/>
		<?php
	}
	 ?>
	</div>
	<br/>
</div>
