<?php

class encode_controller extends Component{

    public  function defaut(){
       echo selEncode($_GET['param'][0], ENCODE_METHOD);
    }

}


