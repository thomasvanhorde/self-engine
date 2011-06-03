<?php

/**
 * Load the CSS library Turbine and output the CSS call in HTML
 *
 */
class Turbine
{
	// Attributes
	private $style;
	
	/**
	 * Constructor
	 *
	 * @param: an array including the css and cssp files
	 */
	public function __construct($styleFiles = array())
	{
		require_once PHP.'/turbine/inc/turbine.php';
		$this->style = get_turbine(PHP.'turbine/css.php', $styleFiles, 'html');
	}
	
	/**
	 * Get the style line for the template head
	 *
	 * @return: a string which looks like <link rel="stylesheet" href="...">
	 */
	public function getStyle()
	{
		return $this->style;
	}
}


/* -- End of line -- */