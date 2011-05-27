<?php
	include "classe_dates.php";
	include "classe_calendrier.php";
	
	$obj_cal = new classe_calendrier('moncalendrier');
	$obj_cal->afficheMois();
	$obj_cal->afficheSemaines(true);
	$obj_cal->afficheJours(true);
	$obj_cal->afficheNavigMois(true);
	
	$obj_cal->activeLienMois();
	$obj_cal->activeLiensSemaines();

	$obj_cal->activeJoursPasses();
	$obj_cal->activeJourPresent();
	$obj_cal->activeJoursFuturs();
	
	$obj_cal->activeJoursEvenements();
	$obj_cal->ajouteEvenement("05/04/2010","&eacute;v&egrave;nement 1<br>");
	$obj_cal->ajouteEvenement("2010-04-30","&eacute;v&egrave;nement 2");
	
	$obj_cal->activeAjax("ajax_calendrier","calendrier.php");

	print ($obj_cal->makeCalendrier((isset($_POST['annee']) ? $_POST['annee'] : date("Y")),(isset($_POST['mois']) ? $_POST['mois'] : date("m"))));


?>