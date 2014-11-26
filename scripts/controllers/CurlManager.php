<?php

class CurlManager {

    /**
     * 
     * @param type $url
     * @param type $port
     * @param type $api
     * @param type $parameters
     * @param type $headers
     * @param type $method
     * @return type
     */
    protected function send($url, $port, $api, $method, $parameters = array(), $headers = array()) {
//        logme("SEND CURL", array($url, $port, $api, $method, $parameters, $headers));
        $url_send = $url . ":" . $port . "/" . $api;
        
        $headers[] = "Content-Type: application/json";
        $result = $this->sendPostData($url_send, $parameters, $headers, $method);
              
           
        return json_decode($result);
    }

    private function sendPostData($url, $post, $headers, $method) {
       //$post = array("quota_set" => array("security_groups" => 45));
        $ch = curl_init($url);
        

        date_default_timezone_set("UTC");
        
        
        
        $file = fopen(getcwd() . '/controllers/curl' . date("Ymd", strtotime("now")) . '.txt', 'a');
        curl_setopt($ch, CURLOPT_STDERR, $file);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        
  
        if (count($post) > 0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        }
        
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        
        
        
        if (curl_errno($ch)) { 
        	throw new Exception("Error in curl request : " . json_encode(curl_error($ch)));
            return curl_error($ch);
        }

        $debugText = "=====================DEBUG================== <BR><BR>";

        $debugText .= "<-- start data_sent-><br>";
        $debugText .= "<pre>" . json_encode($post) . "</pre>";
        $debugText .= "<-- end data_sent--><br>";
        
        $err = curl_error($ch);
        $debugText .= "<-- start err-><br>";
        $debugText .= "<pre>" . print_r($err, TRUE) . "</pre>";
        $debugText .= "<-- end err--><br>";

        $debugText .= "<-- start headers-><br>";
        $debugText .= "<pre>" . print_r($headers, TRUE) . "</pre>";
        $debugText .= "<-- end headers--><br>";

        $info = curl_getinfo($ch);
        $debugText .= "<-- start info-><br>";
        $debugText .= "<pre>" . print_r($info, TRUE) . "</pre>";
        $debugText .= "<-- end info--><br>";

        $debugText .= "<-- start result-><br>";
        $debugText .= "<pre>" . print_r($result, TRUE) . "</pre>";
        $debugText .= "<-- end result-><br>";
        
       
        
        
        fputs($file, $debugText);
        fclose($file);

        curl_close($ch);
        return $result;
    }

}
