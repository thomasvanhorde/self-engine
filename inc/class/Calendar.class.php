<?php

/**
 * Calendar control
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class Calendar extends classe_calendrier
{
    /**
     * Constructor.
     *
     * @param string $calendarName
     */
    public function __construct($calendarName = 'myCalendar')
    {
        $this->loadParent();
        parent::__construct($calendarName);
    }

    /**
     * @param string $conteneur
     * @param mixed  $ajax_url
     */
    public function init($conteneur = 'ajax_calendrier', $ajax_url = false)
    {
        if (!$ajax_url) {
            $ajax_url = SYS_FOLDER.'ajax_calendar/';
        }

        $this->afficheMois();
        // $this->afficheSemaines(true);
        $this->afficheJours(true);
        $this->afficheNavigMois(true);
        // $this->activeLienMois();
        // $this->activeLiensSemaines();
        $this->activeJoursPasses();
        $this->activeJourPresent();
        $this->activeJoursFuturs();
        $this->activeJoursEvenements();

        $this->activeAjax($conteneur, $ajax_url);
    }

    /**
     * @return ?
     */
    public function generate()
    {
        $year  = isset($_POST['annee']) ? $_POST['annee'] : date('Y');
        $month = isset($_POST['mois'])  ? $_POST['mois']  : date('m');

        return $this->makeCalendrier($year, $month);
    }

    /**
     * Adds an event.
     *
     * @param $date
     * @param $label
     * @param $url
     */
    public function addEvent($date, $label, $url)
    {
        parent::ajouteEvenement($date, $label, $url);
    }

    /**
     * Imports the required files.
     */
    private function loadParent()
    {
        if (file_exists(FOLDER_CLASS_EXT.'calendar/classe_dates.php'))
            require_once FOLDER_CLASS_EXT.'calendar/classe_dates.php';
        elseif (file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_dates.php'))
            require_once ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_dates.php';

        if( file_exists(FOLDER_CLASS_EXT.'calendar/classe_calendrier.php'))
            require_once FOLDER_CLASS_EXT.'calendar/classe_calendrier.php';
        elseif (file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_calendrier.php'))
            require_once ENGINE_URL.FOLDER_CLASS_EXT.'calendar/classe_calendrier.php';   
    }
}