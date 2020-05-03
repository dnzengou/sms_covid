<?php
        #We obtain the data which is contained in the post url on our server.

        // Reads the variables sent via POST
        $text=$_GET['USSD_STRING']; // This is what will be saved by the user's entry, USSD_STRING=<name*ward_name*time>
        $sessionId   = $_POST["sessionId"]; // Generates a unique value when the session starts and sent every time a mobile subscriber response has been received. 
        $phonenumber=$_GET['MSISDN']; // We choose fot testing purpose MSISDN=0713038301
        $serviceCode=$_GET['serviceCode']; // Refers to your USSD code, for which we choose for testing purpose serviceCode=*144#


        //$level = explode("*", $text);
        //This is the first menu screen
        if (isset($text)) {
            // https://<app_url>/?MSISDN=0713038301&USSD_STRING=&serviceCode=*144#
   

        if ( $text == "" ) {
            $response="CON Hi welcome, I can help you with COVID-19 related care options \n";
            // CON means an intermediate menu Or that the session is CONtinuing
            $response .= "1. Testing. Please enter you name"; // Holds the answer to the user input
        }
        // https://<app_url>/?MSISDN=0713038301&USSD_STRING=Desire&serviceCode=*144#

        if(isset($level[0]) && $level[0]!="" && !isset($level[1])){

          $response="CON Hi ".$level[0].", enter your ward name";
             
        }
        // https://<app_url>/?MSISDN=0713038301&USSD_STRING=Desire*Kigali&serviceCode=*144#
        else if(isset($level[1]) && $level[1]!="" && !isset($level[2])){
                $response="CON Please ".$level[0].", enter the time of your preference\n"; 
                $response .= "We will come to ".$level[1]." for testing";

        }
        // https://<app_url>/?MSISDN=0713038301&USSD_STRING=Desire*Kigali*13&serviceCode=*144#
        else if(isset($level[2]) && $level[2]!="" && !isset($level[3])){
            //Save data to database
            $data=array(
                'phonenumber'=>$phonenumber,
                'name' =>$level[0],
                'ward' => $level[1],
                'time'=>$level[2]
                );

            
            // https://<app_url>/?MSISDN=0713038301&USSD_STRING=john%20doe*Kigali*13&serviceCode=*144
            $response="END Thank you ".$level[0]." for scheduling testing appointment.\nWe will get back to you when confirmation"; 
    }

        header('Content-type: text/plain');
        echo $response;

    }

?>
