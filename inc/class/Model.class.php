<?php

class Model {

    private function getClassName(){
        $trace = debug_backtrace();
        $obj = $trace[0]['object'];
        return get_class($obj);
    }

    public function getExtensions(){
        $class = $this->getClassName();
        $folder = FOLDER_CLASS_EXTENSION.$class;
        $extensions = array();
        foreach($this->ScanDirectory(ENGINE_URL.$folder) as $ext){
            include $ext['directory'].'/'.$ext['file'];

            $className = $class.'_'.$ext['name'].EXTENSION_NAME_EXT;
            $extensions[] = new $className();
        }
        return $extensions;
    }


    private function ScanDirectory($Directory){
        $return = array();
        $MyDirectory = opendir($Directory) or die('Erreur');
        while($Entry = @readdir($MyDirectory)) {
            if(is_dir($Directory.'/'.$Entry)) {
                if($Entry != '.' && $Entry != '..' && $Entry != '.svn')
                    $return[] = $this->ScanDirectory($Directory.'/'.$Entry);
            }
            else {
                $t = explode(EXTENSION_EXT, $Entry);

                $tmp['directory'] = $Directory;
                $tmp['file'] = $Entry;
                $tmp['name'] = $t[0];
                $return[] = $tmp;
            }
        }
        closedir($MyDirectory);

        return $return;
    }

}