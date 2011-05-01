<?php

class encode_controller extends Component{

    public  function defaut(){
       if(isset($_GET['param'][1]))
            $encode = $_GET['param'][1];
       else
            $encode = ENCODE_METHOD;
        
       echo selEncode($_GET['param'][0], $encode);
    }

}


