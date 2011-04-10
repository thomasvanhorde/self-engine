<?php

class encode_controller {

    public  function encode_controller(){}

    public  function defaut(){
       echo selEncode($_GET['param'][0], ENCODE_METHOD);
    }

}


