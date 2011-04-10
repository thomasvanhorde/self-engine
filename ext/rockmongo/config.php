<?php
/**
 * RockMongo configuration
 *
 * Defining default options and server configuration
 * @package rockmongo
 */

$MONGO = array();
$MONGO["features"] = array( 
	"log_query" => "off" // log queries
);

/**
* Configuration of MongoDB servers
*/
$MONGO["servers"] = array(
	array(
		"host" => "flame.mongohq.com", // Replace your MongoDB host ip or domain name here
		"port" => "27033/lpcm", // MongoDB connection port
		"username" => "lpcm", // MongoDB connection username
		"password" => "lpcm", // MongoDB connection password
		"auth_enabled" => true,//Enable authentication, set to "false" to disable authentication
		/*"admins" => array(
			"lpcm" => "lpcm", // Administrator's USERNAME => PASSWORD
			//"iwind" => "123456",
		),
*/
		// show only following databases (and also allow to pick custom db by name):
		"show_dbs" => array(
		    'lpcm'
		)
		
	),
	array(
		"host" => "localhost", // Replace your MongoDB host ip or domain name here
		"port" => "27017", // MongoDB connection port
		"username" => "", // MongoDB connection username
		"auth_enabled" => true,//Enable authentication, set to "false" to disable authentication
		/*"admins" => array(
			"lpcm" => "lpcm", // Administrator's USERNAME => PASSWORD
			//"iwind" => "123456",
		),
*/
		// show only following databases (and also allow to pick custom db by name):
		"show_dbs" => array(
		    'test'
		)

	),
	/**array(
		"host" => "192.168.1.1",
		"port" => "27017",
		"username" => null,
		"password" => null,
		"auth_enabled" => true,
		"admins" => array( 
			"admin" => "admin"
		)
	),**/
);


?>