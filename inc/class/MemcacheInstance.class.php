<?php

class MemcacheInstance extends Memcache{

    public function __construct(){
        parent::pconnect('localhost', 11211);
    }

    public function getServerStatus(){
        return parent::getServerStatus('localhost', 11211);
    }

    public function set($key, $value){
        if(parent::set($key, $value, MEMCACHE_COMPRESSED , 0)){
            FB('ok');
            return true;
        }else{
            FB('error');
            return false;
        }
    }

    public function get($key){
        return parent::get($key);
    }

}