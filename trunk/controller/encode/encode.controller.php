<?php

/**
* Controlleur encode
* Encodage de chaines de caractères
*
* encode/<<string>>/[methodeName]
* ex : encode/lorem/base64
* ex : encode/lorem
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class encode_controller extends Component{

    public  function defaut(){
       if(isset($_GET['param'][1]))
            $encode = $_GET['param'][1];
       else
            $encode = ENCODE_METHOD;
        
       echo selEncode($_GET['param'][0], $encode);
    }

}


