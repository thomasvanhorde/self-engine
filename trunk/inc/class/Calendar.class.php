<?php
/**
 * User: Thomas
 * Date: 27/05/11
 * Time: 11:43
 */


if(file_exists(FOLDER_CLASS_EXT.'calendar/classe_dates.php'))
	require_once FOLDER_CLASS_EXT.'calendar/classe_dates.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_dates.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_dates.php';

if(file_exists(FOLDER_CLASS_EXT.'calendar/classe_calendrier.php'))
	require_once FOLDER_CLASS_EXT.'calendar/classe_calendrier.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_calendrier.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_calendrier.php';


 
class Calendar extends classe_calendrier{

    public function __construct($calendarName = 'myCalendar'){
        parent::__construct($calendarName);
    }

    public function init($conteneur = 'ajax_calendrier', $ajax_url = false){

        if(!$ajax_url)
            $ajax_url = SYS_FOLDER.'ajax_calendar/';


        $this->afficheMois();
    //    $this->afficheSemaines(true);
        $this->afficheJours(true);
        $this->afficheNavigMois(true);

    //    $this->activeLienMois();
    //    $this->activeLiensSemaines();

        $this->activeJoursPasses();
        $this->activeJourPresent();
        $this->activeJoursFuturs();

        $this->activeJoursEvenements();

        $this->activeAjax($conteneur,$ajax_url);


    }

    public function generate(){
        return ($this->makeCalendrier((isset($_POST['annee']) ? $_POST['annee'] : date("Y")),(isset($_POST['mois']) ? $_POST['mois'] : date("m"))));
    }

    public function addEvent($date, $label, $url){
        parent::ajouteEvenement($date, $label, $url);
    }

}
