<?php
/*

DOC : http://www.thetricky.net/php/php-class-loader

	****************************************************************
	PHP Class Loader
	Copyright (C) 2008  Sébastien Roch
	
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	****************************************************************

	
	PHP Class Loader
	Author : Sébastien Roch <sebastien@thetricky.net>
	Date : 21.10.2008
	Version: 1.0
	
	PHP Class Loader
	========================
	Include this file at the beginning of your pages, it will automatically include classes when
	you invoke un-included classes.
	The following things are required for this library to work:
	- your class names must have the same names as your filenames. case is not sensitive.
	- all your class files have to end with the same suffix. Default is ".class.php".
	- one class per file
	
	CACHE
	========================
	A basic cache stores the found paths to your classes. It stores its data with APC, in a file or
	in a session (Don't forget session_start()), depending on the configuration.
	
	As class files rarely change of directory, there is no cache expiration time: you'll have
	to delete manually the cache if you move your files or change your directory structure!
	Use one of these public functions, depending on the type of cache you use in your configuration:
	classLoader::clearCache_APC();
	classLoader::clearCache_file();
	classLoader::clearCache_session();
	
	CONFIGURATION
	========================
	You can configure the library at the beginning of the class classLoader. Each setting has
	an explanation. Don't touch the rest, should run...
	
	FEEDBACK
	========================
	Comments, bug report and criticisms appreciated. Send to sebastien@thetricky.net
*/

/**
 *  Main class
 */
abstract class classLoader{
	
	/***************************/
	/* EDIT CONFIGURATION HERE */
	/***************************/
	
	/**
	 * The directory where the classes are locateda
	 * Will be browsed recursively
	 */
	const CLASSFILES_DIRECTORY = 'inc/class';
	
	/**
	 * Only files ending with this suffix will be taken into account
	 */
	const CLASSFILE_SUFFIX = CLASS_EXTENSION;
	
	/**
	 * Set whether or not to use the cache. If you have a lot of classes,
	 * highly recommended to true!
	 */
	const USE_CACHE = true;
	
	/**
	 * What to use for cache
	 * 'APC': the fastest, but must be supported by your configuration
	 * 'FILE': second best choice, but you need a writable directory somewhere
	 * 'SESSION': last choice, if APC and FILE not possible. You have to care about session_start()!
	 */
	const CACHE_TYPE = 'SESSION';
	
	/**
	 * The path to the cache file when using a file for cache
	 * Make sure PHP can write in the directory
	 */
	const CACHEFILE_PATH = "cache/classLoader.cache";
	
	/**
	 * The cache lifetime in seconds when using APC cache
	 * Default to 0, never expire. Clear the cache manually with classLoader::clearCache_APC()
	 */
	const APC_CACHE_LIFETIME = 0;
	
	/*************************/
	/* END OF CONFIGURATION  */
	/*************************/
	
	/**
	 * Called by __autoload function. Get and cache the path of given class
	 *
	 * @param string $className
	 * @return string the path to the file
	 */
	public static function getAndCache_file($className){
		$path = null;
		if(!self::USE_CACHE){
			return self::getClassPath($className.self::CLASSFILE_SUFFIX);
		}
		
		if(file_exists(self::CACHEFILE_PATH)){
			// the cache file exist, we try to extract the class path
			$fp = fopen(self::CACHEFILE_PATH, 'r+b');
			$cacheData = unserialize(fread($fp, filesize(self::CACHEFILE_PATH) > 0 ? filesize(self::CACHEFILE_PATH) : 1));
			// the classname was found
			if(isset($cacheData[$className])){
				$path = $cacheData[$className];
			}
			// else get the path and update the cache
			else{
				$path = classLoader::getClassPath($className.self::CLASSFILE_SUFFIX);
				$cacheData[$className] = $path;
				rewind($fp);
				if(fwrite($fp, serialize($cacheData)) === false){
					trigger_error('Could not write in cache file ' . self::CACHEFILE_PATH . '.');
				}
			}
			fclose($fp);
		}
		else{
			$path = classLoader::getClassPath($className.self::CLASSFILE_SUFFIX);
			$toStore = serialize(array($className => $path));
			$fp = @fopen(self::CACHEFILE_PATH, 'wb');
			if($fp){
				if(fwrite($fp, self::CACHEFILE_PATH, $toStore) === false){
					trigger_error('Could not write in cache file ' . self::CACHEFILE_PATH . '.');
				}
				fclose($fp);
			}
			else{
				trigger_error('Could not open cache file: ' . self::CACHEFILE_PATH, E_USER_ERROR . '.');
			}
		}
		return $path;
	}
	
	/**
	 * Called by __autoload function. Get and cache the path of given class
	 * into session. Don't forget session_start()!
	 *
	 * @param string $className
	 * @return string the path to the file
	 */
	public static function getAndCache_session($className){
		$path = null;
		if(!self::USE_CACHE){
			return self::getClassPath($className.self::CLASSFILE_SUFFIX);
		}
		
		if(isset($_SESSION['classLoader'])){
			if(isset($_SESSION['classLoader'][$className])){
				$path = $_SESSION['classLoader'][$className];
			}
			else{
				$path = classLoader::getClassPath($className.self::CLASSFILE_SUFFIX);
				$_SESSION['classLoader'][$className] = $path;
			}
		}
		else{
			$path = classLoader::getClassPath($className.self::CLASSFILE_SUFFIX);
			$_SESSION['classLoader'] = array();
			$_SESSION['classLoader'][$className] = $path;
		}
		return $path;
	}
	
	/**
	 * Called by __autoload function. Get and cache the path of given class
	 * into APC cache.
	 *
	 * @param string $className
	 * @return string the path to the file
	 */
	public function getAndCache_APC($className){
		$path = null;
		if(!self::USE_CACHE){
			return self::getClassPath($className.self::CLASSFILE_SUFFIX);
		}
		$path = apc_fetch($className);
		if($path !== false){
			return $path;
		}
		else{
			$path = classLoader::getClassPath($className.self::CLASSFILE_SUFFIX);
			apc_store($className, $path, self::APC_CACHE_LIFETIME);
		}
		return $path;
	}
	
	/**
	 * Call this function to delete the file cache
	 *
	 * @return boolean true if file was deleted
	 */
	public static function clearCache_file(){
		if(@file_exists(self::CACHEFILE_PATH )){
			return unlink(self::CACHEFILE_PATH);
		}
		return false;
	}
	
	/**
	 * Call this function to delete the cache in session
	 */
	public static function clearCache_session(){
		if(isset($_SESSION['classLoader'])){
			unset($_SESSION['classLoader']);
			return true;
		}
		return false;
	}
	
	/**
	 * Call this function to delete the APC cache
	 */
	public static function clearCache_APC(){
		return apc_clear_cache();
	}
	
	/**
	 * get a class name and a directory path to search
	 * Tries to find the corresponding file ending with CLASSFILE_SUFFIX and
	 * return its path
	 * Recursive function
	 *
	 * @param string $className "Site.class.php" for example
	 * @param string $basePath
	 * @return string the path to the file
	 */
	private static function getClassPath($className, $basePath=self::CLASSFILES_DIRECTORY){

	/* patch ENGINE_URL */
		if(!file_exists($basePath.'/'.$className)){
			$basePath = ENGINE_URL.$basePath.'/'.$className;
			return $basePath;
		}
		else {
			$basePath = $basePath.'/'.$className;
			return $basePath;
		}
	

		$handle = @opendir($basePath);
		
		if($handle === false){
			trigger_error('Could not open directory ' . $basePath . '.', E_USER_ERROR);
			return null;
		}
		
		while(false !== ($file = readdir($handle))){
			if($file != '.' && $file != '..'){
				if(is_dir($basePath.'/'.$file)){
					$in_dir = self::getClassPath($className, $basePath.'/'.$file);
					if(!is_null($in_dir)){
						return $in_dir;
					}
				}
				else{
					if(strtolower($file) == strtolower($className)){
						return $basePath.'/'.$file;
					}
				}
			}
		}

		return null;
	}
}

/**
 * Executed automatically by PHP when a class could not be found
 *
 * @param string $className
 */
function __autoload($className){

	/* PATCH POUR DOCTRINE */
	if(preg_match('/^Doctrine_/', $className)) {
		$Cn = str_replace('Doctrine_', '', $className);
		if(Count(explode('_',$Cn)) == 2) {
			$u = explode('_',$Cn);
			$Cn = $u[0].'/'.$u[1];
		}
		if(Count(explode('_',$Cn)) == 3) {
			$u = explode('_',$Cn);
			$Cn = $u[0].'/'.$u[1].'/'.$u[2];
		}
		$path = FOLDER_CLASS_EXT.'Doctrine-1.2.3/Doctrine/'.$Cn.'.php';
	}
	else {
		switch(classLoader::CACHE_TYPE){
			case 'APC': $path = classLoader::getAndCache_APC($className); break;
			case 'FILE': $path = classLoader::getAndCache_file($className); break;
			case 'SESSION': $path = classLoader::getAndCache_session($className); break;
			default: trigger_error('Configuration: cache type not supported: "'.classLoader::USE_SESSION_CACHE.'".', E_USER_ERROR);
		}
	}
	
	if(is_null($path)){
		trigger_error('Could not load class ' . $className . '.', E_USER_ERROR);
	}

	if(file_exists($path))
		require_once $path;
	elseif(file_exists(ENGINE_URL.$path))
		require_once ENGINE_URL.$path;	
}

?>